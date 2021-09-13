<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Helpers;
use Config;
use App\User; 
use App\User_skill; 
use App\Opportunity_card_field;
use App\User_experience; 
use App\Order; 
use App\Shipping_method; 
use App\Opportunity_card; 
use App\Opentowork_card; 
use App\Forgot_password; 
use App\User_education; 
use App\User_collection; 
use App\Roles; 
use App\Endorse_list;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }
	
	public function activate_account($token,$email) {
		$user = User::where('email',$email)->first();
		
		if($user === null) {
			echo 'Wrong Request';exit;
		}
		
		$user_id = $user->id;
		
		$expected_activation_token = md5(md5(md5($user_id)));
		
		if($token !== $expected_activation_token) {
			echo 'Wrong token';exit;
		}
		
		if($user->verified == 1) {
			return redirect('/user/login')->withInput()->withErrors(['Your account already activated']);
		}
		
		$user->verified = 1;
		$user->save();
		
		$message = 'Your account activated successfully.';
        return redirect('/user/login')->with('message',  $message);
	}
	
	public function recover_password($token) {
		//var_dump($token);exit;
		$fp = Forgot_password::where('token',$token);
		
		if($fp->count() == 0) {
			return redirect('/')->withInput()->withErrors(['Wrong REquest']);
		}
		
		$created_at = $fp->first()->created_at;
		$now = date("Y-m-d H:i:s");
		
		$starttimestamp = strtotime($created_at);
		$endtimestamp = strtotime($now);
		$difference = abs($endtimestamp - $starttimestamp)/3600;
				
		if($difference > 0.5) {
			return redirect('/')->withInput()->withErrors(['Token expired or doesnot exist.']);
		}
		
		return view('user.recover_password',[
			'token' => $token
		]);
	}
	
	public function recover_password_post($token,Request $request) {
		$fp = Forgot_password::where('token',$token);
		
		if($fp->count() == 0) {
			return redirect('/')->withInput()->withErrors(['Wrong REquest']);
		}
		
		$fp_row = $fp->first();
		$created_at = $fp_row->created_at;
		$now = date("Y-m-d H:i:s");
		
		$starttimestamp = strtotime($created_at);
		$endtimestamp = strtotime($now);
		$difference = abs($endtimestamp - $starttimestamp)/3600;
				
		if($difference > 0.7) {
			return redirect('/')->withInput()->withErrors(['Token expired or doesnot exist.']);
		}
				
		$request->validate([
           'password' => 'required|string|confirmed|min:8|'
        ]);
		
		$email = $fp_row->email;
		$user = User::where('email',$email);
		
		if($user->count() == 0) {
			return redirect('/')->withInput()->withErrors(['Something is wrong']);
		}
		
		$user_row = $user->first();
        $user_row->password = bcrypt($request->get('password'));
        $user_row->save();
		
		$fp->delete();

		$message = 'Your password has successfully changed.';
        return redirect('/user/login')->with('message',  $message);
	}
	
	public function orders(Request $request) {
		if(!Auth::guard('user')->check()) {
			return redirect('/');
		}
			
		$user_id = Auth::guard('user')->user()->id;
		$orders = Order::where('user_id',$user_id)->whereIn('status',['pending','finished','cancelled'])->get();
		
		return view('user.orders',[
			'orders' => $orders
		]);
	}
	
	public function view_order($id) {
		if(!Auth::guard('user')->check()) {
			return redirect('/');
		}
				
		$order = Order::find($id);
		
		if (count((array)$order) == 0) {
			exit('Wrong Request');
		}
		
		$user_id = Auth::guard('user')->user()->id;
		
		if($order->user_id != $user_id) {
			exit('Wrong Request');
		}
		
		$shipping_method_row = Shipping_method::find($order->shipping_id);
		$shipping_method = isset($shipping_method_row->name) ? $shipping_method_row->name : '';
		$o = new Order;
		$order_products = $o->get_orders_products($id);
		
		return view('user.view_order',[
			'order' => $order,
			'shipping_method' => $shipping_method,
			'order_products' => $order_products
		]);
	}
	
	public function change_contact_info(Request $request) {
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/');
		}
		
		$user =  Auth::guard('user')->user();
		$countries = Config::get('countries');	
		
		return view('user.change_contact_info',[
			'user' => $user,
			'countries' => $countries
		]);
	}
		
	public function change_password() {
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/');
		}
		
		return view('user.change_password',[
			
		]);
	}
	
	public function settings() {
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/');
		}
		
		$user =  Auth::guard('user')->user();
		$countries = Config::get('countries');
		
		return view('user.settings',[
			'user' => $user,
			'countries' => $countries
		]);
	}
	
	public function view_user($user_id) {
		if(!Auth::guard('user')->check()) {
			$logged_in_user_id = 0;
		}else{
			$logged_in_user_id = Auth::guard('user')->user()->id;
		}
		
		
		$countries = Config::get('countries');
		$owner = false;
		
		if($logged_in_user_id == $user_id) {
			$owner = true;
		}
				
		$user = User::find($user_id);
		
		
		if($user === null) {
			return abort(404);
		}
				
		if ($user->is_deleted == 1) {
			$owner = false;
		}
		$licence = $user->licence;

		$country_code = $user->country_code;
		$country = isset($countries[$country_code]) ? $countries[$country_code] : '';
		$opportunity_cards = Opportunity_card::where('user_id',$user_id)->get();
		$opentowork_card = Opentowork_card::where('user_id',$user_id)->get();
		$user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();
		$user_educations = User_education::where('user_id',$user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();

		$opc_fields_json = $user->fields;
		$opc_fields = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields = json_decode($opc_fields_json,true);
		}

		$opc_roles_json = $user->roles;
		$opc_roles = [];
		
		if (trim($opc_roles_json) != '') {
			$opc_roles = json_decode($opc_roles_json,true);
		}
		//skill vs endorse
		$endorsed_users = [];
		foreach($opc_fields as $skill){
			$opSkill = Opportunity_card_field::where('name',$skill)->first();
			$itemList = Endorse_list::where('received_user_id', $user_id)->where('skill_id', $opSkill->id)->pluck('given_user_id')->toArray();
			$endorsed_users[$skill] = $itemList;
		}
		$months = [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
		];
		
		$user_experiences = User_experience::where('user_id',$user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
		$profile_image_src = false;
		
		if(trim($user->profile_image_cropped) != '') {
			$path = base_path() . '/public/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			
			if(is_file($path)) {
				$profile_image_src = URL::to('/').'/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			}
		}
		
		$collections_html = '';
		
		if($owner === false) {
			$user_collections = User_collection::where('user_id',$logged_in_user_id)->get();
			
			foreach($user_collections as $uc) {
				$ugi = $uc->items_with_user($user_id);
				
				if($ugi === null) {
					 $tmp = '<a action_type="add" item_type="user" collection_user_id = "'.$user_id.'" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a action_type="remove" item_type="user" collection_user_id = "'.$user_id.'" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
		}
		$third_person = true;
		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			if($logged_in_user_id == $user_id) $third_person = false;
		}
		//SEO
		$og_url = URL::to('/')."/user"."/".$user_id."/"."view";
		$og_title = $user->full_name;
		$og_description = $user->profession;
		$og_image = URL::to('/')."/assets/images/External-icon-user.png";
		return view('user.my_account',[
			'profile_image_src' => $profile_image_src,
			'countries' => $countries,
			'country' => $country,
			'opportunity_cards' => $opportunity_cards,
			'opentowork_card' => $opentowork_card,
			'user_skills' => $user_skills,
			'user_educations' => $user_educations,
			'user_experiences' => $user_experiences,
			'months' => $months,
			'user' => $user,
			'logged_in_user_id' => $logged_in_user_id,
			'owner' => $owner,
			'user_id' => $user_id,
			'third_person'=> $third_person,
			'collections_html' => $collections_html,
			'opportunity_card_page' => true,
			'og_url'=>$og_url,
			'og_title'=>$og_title,
			'og_description'=>$og_description,
			'og_image'=>$og_image,
			'opc_fields' => $opc_fields,
			'opc_roles' => $opc_roles,
			'opc_endorse' => $endorsed_users,
			'licence' => $licence,

		]);
	}
	public function unsubscribe($user_id) {
		
		
		$user = User::find($user_id);
		

		if($user === null) {
			exit;
		}
		$user->unsubscribe = 1;
		//$user->save();
		return redirect('/')->withInput()->withErrors(['You will not receive the reminder email from now on.']);
	}
	
	public function my_account() {
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/user/login');
		}
		
		
		
		$countries = Config::get('countries');
		$user_id = Auth::guard('user')->user()->id;
		$user = User::find($user_id);
		$licence = $user->licence;
		if ($user->is_deleted == 1) {
			Auth::guard('user')->logout();
			return redirect('/')->withInput()->withErrors(['Your account cancelled please contact support.']);
		}
		
		$country_code = $user->country_code;
		
		$country = isset($countries[$country_code]) ? $countries[$country_code] : '';
		$opportunity_cards = Opportunity_card::where('user_id',$user_id)->get();
		$opentowork_card = Opentowork_card::where('user_id',$user_id)->get();
		$user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();
		$user_educations = User_education::where('user_id',$user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();
		
		$opc_fields_json = $user->fields;
		$opc_fields = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields = json_decode($opc_fields_json,true);
		}

		$opc_roles_json = $user->roles;
		$opc_roles = [];
		
		if (trim($opc_roles_json) != '') {
			$opc_roles = json_decode($opc_roles_json,true);
		}
		//skill vs endorse
		$endorsed_users = [];
		foreach($opc_fields as $skill){
			$opSkill = Opportunity_card_field::where('name',$skill)->first();
			$itemList = Endorse_list::where('received_user_id', $user_id)->where('skill_id', $opSkill->id)->pluck('given_user_id')->toArray();
			$endorsed_users[$skill] = $itemList;
		}
		$months = [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
		];
		
		$user_experiences = User_experience::where('user_id',$user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
		
		$profile_image_src = false;
		
		if(trim($user->profile_image_cropped) != '') {
			$path = base_path() . '/public/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			
			if(is_file($path)) {
				$profile_image_src = URL::to('/').'/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			}
		}
		
		
		$third_person = true;
		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$logged_in_user_id = Auth::guard('user')->user()->id;
			if($logged_in_user_id == $user_id) $third_person = false;
		}
		return view('user.my_account',[
			'profile_image_src' => $profile_image_src,
			'countries' => $countries,
			'country' => $country,
			'opportunity_cards' => $opportunity_cards,
			'opentowork_card' => $opentowork_card,
			'user_skills' => $user_skills,
			'user_educations' => $user_educations,
			'user_experiences' => $user_experiences,
			'months' => $months,
			'user' => $user,
			'logged_in_user_id' => $logged_in_user_id,
			'owner' => true,
			'third_person'=> $third_person,
			'user_id' => $user_id,
			'opc_fields' => $opc_fields,
			'opc_roles' => $opc_roles,
			'opc_endorse' => $endorsed_users,
			'licence' => $licence,

		]);
	}
	public function updateAccount($param_id) {
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/user/login');
		}

		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$logged_in_user_id = Auth::guard('user')->user()->id;
			if($logged_in_user_id != $param_id) abort(404);
		}
		
		
		$countries = Config::get('countries');
		$user_id = Auth::guard('user')->user()->id;
		$user = User::find($user_id);
		
		if ($user->is_deleted == 1) {
			Auth::guard('user')->logout();
			return redirect('/')->withInput()->withErrors(['Your account cancelled please contact support.']);
		}
		
		$country_code = $user->country_code;
		
		$country = isset($countries[$country_code]) ? $countries[$country_code] : '';
		$opportunity_cards = Opportunity_card::where('user_id',$user_id)->get();
		$opentowork_card = Opentowork_card::where('user_id',$user_id)->get();
		// $user_skills_all = User_skill::orderBy('name','asc')->pluck('name')->toArray();
		$opc_fields = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
		$opc_roles = Roles::orderBy('name','asc')->pluck('name')->toArray();
		// $user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();

		$opc_fields_json = $user->fields;
		$opc_fields_db = [];
		
		if (trim($opc_fields_json) != '') {
			$opc_fields_db = json_decode($opc_fields_json,true);
		}

		$opc_roles_json = $user->roles;
		$opc_roles_db = [];
		
		if (trim($opc_roles_json) != '') {
			$opc_roles_db = json_decode($opc_roles_json,true);
		}

		$user_educations = User_education::where('user_id',$user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();

		if($user->looking_for == 1){ // opporutniy seeker

		}
		
		$months = [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
		];
		$user_experiences = [];
		$ue = User_experience::where('user_id',$user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
		if(count($ue) > 0) $user_experiences = $ue;
		$profile_image_src = false;
		
		if(trim($user->profile_image_cropped) != '') {
			$path = base_path() . '/public/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			
			if(is_file($path)) {
				$profile_image_src = URL::to('/').'/uploads/profile/'.$user_id.'/'.$user->profile_image_cropped;
			}
		}

		$opc_roles = Roles::orderBy('name','asc')->pluck('name')->toArray();
		

		return view('user.edit_profile',[
			'profile_image_src' => $profile_image_src,
			'countries' => $countries,
			'country' => $country,
			'opportunity_cards' => $opportunity_cards,
			'opentowork_card' => $opentowork_card,
			'opc_fields' => $opc_fields,
			'opc_fields_db' => $opc_fields_db,
			'user_educations' => $user_educations,
			'user_experiences' => $user_experiences,
			'months' => $months,
			'opc_roles' => $opc_roles,
			'opc_roles_db' => $opc_roles_db,
			'user' => $user,
			'owner' => true,
			'third_person'=> false,
			'user_id' => $user_id
		]);
	}
	
	public function login() {
		return redirect('/');
		if(isset($_GET['test'])) {
			
			//$is_sent = Helpers::send_ses_email($data);
			$user = User::find(1);
			$logo_url = URL::to('/').'/assets/images/SmallLogo.png';
			$token = md5(md5(md5($user->id)));
			$profile_activation_link = URL::to('/').'/user/activate_account/'.$token.'/'.'test-wxwplsj1u@srv1.mail-tester.com';
						
			$email_html = (String)view('email_templates.register',[
				'profile_activation_link' => $profile_activation_link,
				'email' => 'artashespapikyan1984@mail.ru',
				'logo_url' => $logo_url
			]);
			
			Helpers::send_mail_html('artashespapikyan1984@mail.ru', 'New growyspace account', $email_html, 'no_reply@growyspace.com');
		}
		
		if(!session()->has('url.intended'))
		{
			session(['url.intended' => url()->previous()]);
		}
		
		return view('user.login',[
			
		]);
	}
	
	public function register() {
		return redirect('/');
		$countries = Config::get('countries');
		
		return view('user.register',[
			'countries' => $countries
		]);
	}
	
	public function logout() {
		session()->forget('redirect_back');
		Auth::guard('user')->logout();
        return redirect('/');
	}
	
	public function change_contact_info_post(Request $request) {
		$user = Auth::guard('user')->user();
				
		$validation_fields = [
			'email' => 'required|string|unique:users,email,'.$user->id ,
			'full_name' => 'required|string'
		];
		
		$v = Validator::make($request->all(), $validation_fields);		
			
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
		
		
		$user->email             = $request->email;
		$user->full_name         = $request->full_name;
		$user->country_code      = $request->country_code;
		$user->city              = $request->city;
		$user->profession        = $request->profession;
		$user->save();
		return redirect()->back()->with("success","Account Updated Successfully");
	}
	
	public function change_password_post(Request $request) {
		
		if (!(Hash::check($request->get('current_password'), Auth::guard('user')->user()->password))) {
            // The passwords matches
			return redirect()->back()->withInput()->withErrors(['current_password' => "Your current password does not matches with the password you provided. Please try again."]);
            //return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->withInput()->withErrors(['current_password' => "New Password cannot be same as your current password. Please choose a different password."]);
			//return redirect()->back()->with("error",);
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
		
		$user = Auth::guard('user')->user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
	}	
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login_post(Request $request)
    {
		//--- Validation Section
        $rules = [
		   'email' => 'required',
		   'password' => 'required'
		];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
        }
        //--- Validation Section Ends
		// Attempt to log the user in
		$user = User::where('email',$request->email)->first();
		
		if($user === null) {
			return redirect()->back()->withErrors([ 'wrong_login_details' => 'Credentials Does Not Match !' ]);
			exit;
		}
		if($user->verified == 0){
			return redirect()->back()->withErrors([ 'wrong_login_details' => 'Please activate your email in your inbox or spam folder' ]);
			exit;
		}

			if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password,'verified' => 1 /*,'is_deleted' => 0*/ ], $request->remember)) {
				
				$redirect_back = session('redirect_back');
				
				if($redirect_back) {
					return redirect($redirect_back);
				} else {
					return redirect('/user/my_account');
				}
				
				
			}
			return redirect()->back()->withErrors([ 'wrong_login_details' => 'Credentials Does Not Match !' ]);



		
	}
	
	public function registration_post(Request $request)
    {
		$validation_fields = [
			'email' => 'required|string|unique:users,email' ,
			'password' => 'required|string|confirmed|min:8|',
			'full_name' => 'required|string',
			'looking_for' => 'required|string',
			'profession' => 'required|string',
			'country_code' => 'required|string',
			'city' => 'required|string'
		];
				
		$v = Validator::make($request->all(), $validation_fields);
					
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v->errors());
		}
		
		$user = new User;
		$user->email           = $request->email;
		$user->profession           = $request->profession;
		$user->country_code           = $request->country_code;
		$user->city           = $request->city;
		$user->password        = bcrypt($request->password);
		$user->full_name        = $request->full_name;
		$user->looking_for        = $request->looking_for;
		$user->licence        = 1; //free version
		
		$user->save();
		$message = 'Congratulations! Your account has now been created, and an activation link has been sent to '.$request->email.' from no_reply@growyspace.com. If you haven\'t received it, please check your spam inbox.';
			

		$logo_url = URL::to('/').'/assets/images/SmallLogo.png';
		$token = md5(md5(md5($user->id)));
		$profile_activation_link = URL::to('/').'/user/activate_account/'.$token.'/'.$request->email;
		
		
		$email_html = (String)view('email_templates.register',[
			'profile_activation_link' => $profile_activation_link,
			'email' => $request->email,
			'logo_url' => $logo_url
		]);
				
		$data = [
			'to' => $request->email,
			'subject' => 'New growyspace account',
			'body' => $email_html
		];
		$is_sent = Helpers::send_ses_email($data);

		// Helpers::send_mail_html($request->email, 'New growyspace account', $email_html, 'no_reply@growyspace.com');		
		return redirect('/')->with('registration_success',  $message);
	}


	public function email_test()
    {
		
		
		
		$message = 'Congratulations! Your account has now been created, and an activation link has been sent to from no_reply@growyspace.com. If you haven\'t received it, please check your spam inbox.';
			

		$logo_url = URL::to('/').'/assets/images/SmallLogo.png';
		$profile_activation_link = URL::to('/').'/user/activate_account/';
		
		
		$email_html = (String)view('email_templates.register',[
			'profile_activation_link' => $profile_activation_link,
			'email' => 'alexanderandersson9212@gmail.com',
			'logo_url' => $logo_url
		]);
				
		$data = [
			'to' => 'alexanderandersson9212@gmail.com',
			'subject' => 'New growyspace account',
			'body' => $email_html
		];
		$is_sent = Helpers::send_ses_email($data);

		// Helpers::send_mail_html($request->email, 'New growyspace account', $email_html, 'no_reply@growyspace.com');		
	
	}
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}