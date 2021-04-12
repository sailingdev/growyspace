<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Config;
use App\Category; 
use App\User_collection; 
use App\Product; 
use App\Skill; 
use App\User;  
use App\Opportunity_card_field; 
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Opportunity_card;
use App\Opentowork_card;
use App\User_skill; 
use App\User_education; 
use App\User_experience; 
use App\Endorse_list;
class SearchController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user_id = 0;
		if(Auth::guard('user')->check()) {
			// session(['redirect_back' => url()->full()]);
			// return redirect('user/login');
			$user_id = Auth::guard('user')->user()->id;
		}
		
		
		$countries = Config::get('countries');
		$all_opc_fields = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
		$all_skills = Skill::orderBy('name','asc')->pluck('name')->toArray();
		$search_url = URL::to('/').'/search';
		
		$opc_fields = isset($_GET['opc_fields']) && !empty($_GET['opc_fields']) ? explode(',',$_GET['opc_fields']) : [];
		$skills = isset($_GET['skills']) && !empty($_GET['skills']) ? explode(',',$_GET['skills']) : [];
		$country = isset($_GET['country']) ?  ($_GET['country']) : '';
		$city = isset($_GET['city']) ? $_GET['city'] : '';
		$city1 = $city;
		$from_salary = isset($_GET['from_salary']) ? $_GET['from_salary'] : '';
		$to_salary = isset($_GET['to_salary']) ? $_GET['to_salary'] : '';
		$from_hour = isset($_GET['from_hour']) ? $_GET['from_hour'] : '';
		$to_hour = isset($_GET['to_hour']) ? $_GET['to_hour'] : '';
		$education = isset($_GET['education']) ? $_GET['education'] : '';
		$keyword = isset($_GET['search']) ? $_GET['search'] : '';
		$profession = isset($_GET['profession']) ? $_GET['profession'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : 0;
	
		$available = isset($_GET['available']) && !empty($_GET['available']) ? explode(',',$_GET['available']) : [];
		$opportunity_cards = NULL;
		$opentowork_cards = NULL;
		$users = NULL;
		if($city){
			foreach($countries as $country_code => $coutry_name){
				if(strtolower($coutry_name) == strtolower($city)){
					$country = $country_code;
					$city1 = '';
				}
			}
		}		
		//addslashes
		$sub_query = "1=1";
		$sub_query2 = "1=1";
		$sub_query3 = "1=1";
		$need_to_process_for_searching = false;
		$need_to_process_for_searching_users = false;
		$need_to_process_for_searching_cards = false;
		$need_to_process_for_searching_open = false;
		
		
		if($type == 2 || $type == 0) {
			if($type == 2) {
				$need_to_process_for_searching = true;
				$need_to_process_for_searching_cards = true;
			}
			if(!empty($opc_fields)) {
				$t = "";
				
				foreach($opc_fields as $k =>  $f) {
					$f = addslashes($f);
					$t .= ($k == 0 ? "" : " OR ")."opportunity_cards.fields LIKE '%$f%'";
				}
				
				$sub_query .= " AND (".$t.")";
				$need_to_process_for_searching = true;
				$need_to_process_for_searching_cards = true;
			}
			
			
			
			if(trim($country) != '') {
				$country = addslashes($country);
				$sub_query .= " AND opportunity_cards.country_code='$country'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($city1) != '') {
				$city1 = addslashes($city1);
				$sub_query .= " AND opportunity_cards.city LIKE '$city1'";
				$need_to_process_for_searching = true;
			}
			if(trim($from_salary) != '') {
				$from_salary = addslashes($from_salary);
				$sub_query .= " AND opportunity_cards.salary >= '$from_salary'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($to_salary) != '') {
				$to_salary = addslashes($to_salary);
				$sub_query .= " AND opportunity_cards.salary <= '$to_salary'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($from_hour) != '') {
				$from_hour = addslashes($from_hour);
				$sub_query .= " AND opportunity_cards.hours >= '$from_hour'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($to_hour) != '') {
				$to_hour = addslashes($to_hour);
				$sub_query .= " AND opportunity_cards.hours <= '$to_hour'";
				$need_to_process_for_searching = true;
			}
			
			if(!empty($keyword)) {
				$keyword = addslashes($keyword);
				$sub_query .= " AND 
					(
						opportunity_cards.title LIKE '%$keyword%' OR 
						opportunity_cards.company LIKE '%$keyword%' OR
						opportunity_cards.description LIKE '%$keyword%' OR
						opportunity_cards.city LIKE '%$keyword%' OR
						opportunity_cards.fields LIKE '%$keyword%' 
					)
				";
				$need_to_process_for_searching = true;
			}
			
			if($need_to_process_for_searching === true) {

				$opportunity_cards = Opportunity_card::whereRaw($sub_query)->orderBy('id','desc')->
						paginate(100);
							
				/*$opportunity_cards = DB::table('opportunity_cards')
					->leftJoin('opportunity_card_fields', 'users.id', '=', 'posts.user_id')
					->get();	*/		
					
							
			}
		}	
		//open-to-work
		if($type == 3 || $type == 0) {
			if($type == 3) {
				$need_to_process_for_searching = true;
				$need_to_process_for_searching_open = true;
				
			}
			if(!empty($opc_fields)) {
				$t = "";
				
				foreach($opc_fields as $k =>  $f) {
					$f = addslashes($f);
					$t .= ($k == 0 ? "" : " OR ")."opentowork_cards.fields LIKE '%$f%'";
					$t .= ($k == 0 ? "" : " OR ")."opentowork_cards.roles LIKE '%$f%'";
				}
				
				$sub_query3 .= " AND (".$t.")";
				$need_to_process_for_searching = true;
				$need_to_process_for_searching_open = true;
			}
			
			
			
			if(trim($country) != '') {
				$country = addslashes($country);
				$sub_query3 .= " AND opentowork_cards.country_code='$country'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($city1) != '') {
				$city1 = addslashes($city1);
				$sub_query3 .= " AND opentowork_cards.city LIKE '$city1'";
				$need_to_process_for_searching = true;
			}
			
			
			if(!empty($keyword)) {
				$keyword = addslashes($keyword);
				$sub_query3 .= " AND 
					(
						opentowork_cards.title LIKE '%$keyword%' OR 
						opentowork_cards.description LIKE '%$keyword%' OR
						opentowork_cards.city LIKE '%$keyword%' OR
						opentowork_cards.fields LIKE '%$keyword%' OR
						opentowork_cards.roles LIKE '%$keyword%' 
					)
				";
				$need_to_process_for_searching = true;
			}
			
			if($need_to_process_for_searching === true) {
				$opentowork_cards = Opentowork_card::whereRaw($sub_query3)->where('refer',0)->orderBy('id','desc')->
						paginate(100);		
				/*$opportunity_cards = DB::table('opportunity_cards')
					->leftJoin('opportunity_card_fields', 'users.id', '=', 'posts.user_id')
					->get();	*/		
							
							
			}
		}	



		if($type == 1  || $type == 0) {
			if($type == 1) {
				$need_to_process_for_searching = true;
			}
			if(!empty($skills)) {
				$t = "";
				
				foreach($skills as $k => $s) {
					$s = addslashes($s);
					$t .= ($k == 0 ? "" : " OR ")."user_skills.name LIKE '%$s%'";
				}
				
				$sub_query2 .= " AND (".$t.")";
				$need_to_process_for_searching = true;
			}
			
			if(trim($country) != '') {
				$country = addslashes($country);
				$sub_query2 .= " AND users.country_code='$country'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($city1) != '') {
				//var_dump($city);exit;
				$city1 = addslashes($city1);
				$sub_query2 .= " AND users.city LIKE '$city1'";
				$need_to_process_for_searching = true;
			}
			
			if(trim($education) != '') {
				$education = addslashes($education);
				$sub_query2 .= " AND ( user_educations.school LIKE '%$education%' OR user_educations.type_of_title LIKE '%$education%' OR user_educations.title LIKE '%$education%' OR user_educations.description LIKE '%$education%' )";
				$need_to_process_for_searching = true;
			}
			//var_dump($available);exit;
			if(!empty($available)) {
				$tmp = '';
				foreach($available as $k => $a) {
					$availability_values_map = [
						1 => 1,
						2 => 0
					];
					
					$av = isset($availability_values_map[$a]) ? $availability_values_map[$a] : $a;
					$tmp .= ($k == 0 ? "" : " OR "). "users.available = '$av' ";
				}
				
				$sub_query2 .= " AND ( {$tmp} ) ";
				$need_to_process_for_searching = true;
			}
			
			
			if(trim($profession) != '') {
				$profession = addslashes($profession);
				$sub_query2 .= " AND users.profession LIKE '%$profession%'";
				$need_to_process_for_searching = true;
			}
			
			if(!empty($keyword)) {
				$keyword = addslashes($keyword);
				$sub_query2 .= " AND 
					(
						users.full_name LIKE '%$keyword%' OR 
						users.profession LIKE '%$keyword%' OR 
						user_educations.school LIKE '%$keyword%' OR
						user_educations.type_of_title LIKE '%$keyword%' OR
						user_educations.title LIKE '%$keyword%' OR
						user_educations.description LIKE '%$keyword%' OR
						user_skills.name LIKE '%$keyword%'
					)
				";
				$need_to_process_for_searching = true;
			}
			
			$sub_query2 .= " AND users.is_deleted =0";
			$sub_query2 .= " AND users.is_hidden =0";
			$sub_query2 .= " AND users.id != 1";
			$sub_query2 .= " AND users.id != 2";
			
			if($need_to_process_for_searching === true) {
				
				$users = DB::table('users')
					->leftJoin('user_educations', 'users.id', '=', 'user_educations.user_id')
					->leftJoin('user_skills', 'users.id', '=', 'user_skills.user_id')
					 
					->whereRaw($sub_query2)
					->select(
						'users.*'
					)
					->groupBy('users.id')->orderBy('id','desc')
					->paginate(100); 

				
			}
		}
		
		$user_collections = User_collection::where('user_id',$user_id)->get();
		
		
		//echo '<pre>';
		//print_r( $uc_map);exit;
	
		$opportunityList = Opportunity_card::where('user_id',$user_id)->get();
		$opentoworkList = Opentowork_card::where('user_id',$user_id)->get();
		return view('search',[
			'need_to_process_for_searching' => $need_to_process_for_searching,
			'search_url' => $search_url,
			'all_opc_fields' => $all_opc_fields,
			'opc_fields' => $opc_fields,
			'countries' => $countries,
			'country' => $country,
			'city' => $city,
			'from_salary' => $from_salary,
			'to_salary' => $to_salary,
			'from_hour' => $from_hour,
			'to_hour' => $to_hour,
			'type' => $type,
			'opportunity_cards' => $opportunity_cards,
			'opentowork_cards' => $opentowork_cards,
			'user_id' => $user_id,
			'available' => $available,
			'education' => $education,
			'profession' => $profession,
			'all_skills' => $all_skills,
			'skills' => $skills,
			'users' => $users,
			'user_collections' => $user_collections,
			'opc_list' => $opportunityList,
			'opt_list' => $opentoworkList,
		]);
	}
	
	public function findmatch($user_id){
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('/');
		}

		$user = User::find($user_id);
		$third_person = true;
		if($user === null) {
			return abort(404);
		}

		if($user->matchmaking == 0 || Auth::guard('user')->user()->id != $user->id){
			return abort(404);
		}
		
		$opportunity_cards = Opportunity_card::where('user_id',$user_id)->get();
		$opentowork_card = Opentowork_card::where('user_id',$user_id)->get();
		$user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();
		$user_educations = User_education::where('user_id',$user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();

		$user_experiences = User_experience::where('user_id',$user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();


		if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
			$logged_in_user_id = Auth::guard('user')->user()->id;
			if($logged_in_user_id == $user_id) $third_person = false;
		}

		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$type = '';
		$card_id = 0;
		$opw_rlt = array();	 
		$opt_rlt = array();	 
		if(trim($id) != '') { 
			$tmp = explode('_',$id);
			$type = $tmp[0];
			$card_id = $tmp[1];
			if($type == 'opw'){//open-to-work. so, I need to find the opportunity.
				$opc  = Opentowork_card::where('id',$card_id)->first();
				$targetopc  = Opportunity_card::all();
		
				if($opc === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				//roles of interest = title of opportunity card  2 points
				//country 1 point
				//and city 1 point
				//1 endorced the same skill with requested skill in opportunity card => 2 point
				//1 the same skill with requested skill in opportunity card => 1 point
				$dbroles = $opc->roles;
				$roles = [];					
				if (trim($dbroles) != '') {
					$roles = json_decode($dbroles,true);
				}

				$country_code = $opc->country_code;
				$city = $opc->city;
				$dbskills = $opc->fields;
				$skills = [];					
				if (trim($dbskills) != '') {
					$skills = json_decode($dbskills,true);
				}
				//edorced skill id and track it through the opportunity_card_fileds
				
				$final = array();
				$hasOneSkill = 0;
				foreach($targetopc as $key => $value){
					$opc_fields_json = $value['fields'];
					$targetSkills = [];
					
					if (trim($opc_fields_json) != '') {
						$targetSkills = json_decode($opc_fields_json,true);
					}
					$matched_skills = array_intersect($targetSkills, $skills);
					$count = count($matched_skills);
					$score = 0;
					if($count > 0) {
						$hasOneSkill = 1;
						$score = $score + ($count * 1);					
						$endorceList  = Endorse_list::where('received_user_id',$value['user_id'])->get();
						$endorceNoList = array();
						if($endorceList){
							foreach($endorceList as $ekey => $evalue){
								$tmp = Opportunity_card_field::where('id',$evalue->skill_id)->first();							array_push($endorceNoList,$tmp->name);
							}

						}
						if(count($endorceNoList) > 0) $score = $score + (count($endorceNoList) * 2);

						if($country_code == $value['country_code']){
							$score = $score + 1;
						}
						if($country_code == $value['country_code'] && $city == $value['city']){
							$score = $score + 2;
						}
						if($roles){
							foreach($roles as $rkey => $rvalue){
								$pos = strpos($value['title'], $rvalue);
								if ($pos !== false) {
									$score = $score + 2;	
								}
							}
							
						}
						
						if($hasOneSkill || $score > 5){
							array_push($final,['score' => $score,'index' => $key]);
							// echo $score;
						}
					}
					

					

				}
				
				usort($final, function ($item1, $item2) {
					return $item2['score'] > $item1['score'];
				});

				
				foreach($final as $k => $v){
					array_push($opt_rlt, $targetopc[$v['index']]);
				}

				
			}else if($type == 'opt'){// must find the open-to-work
				$opc  = Opportunity_card::where('id',$card_id)->first();
				$targetopc  = Opentowork_card::all();
		
				if($opc === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				$dbroles = $opc->roles;
				$roles = [];					
				if (trim($dbroles) != '') {
					$roles = json_decode($dbroles,true);
				}

				$country_code = $opc->country_code;
				$city = $opc->city;
				$dbskills = $opc->fields;
				$skills = [];					
				if (trim($dbskills) != '') {
					$skills = json_decode($dbskills,true);
				}
				//edorced skill id and track it through the opportunity_card_fileds
				
				$final = array();
				$hasOneSkill = 0;
				foreach($targetopc as $key => $value){
					$opc_fields_json = $value['fields'];
					$targetSkills = [];
					
					if (trim($opc_fields_json) != '') {
						$targetSkills = json_decode($opc_fields_json,true);
					}
					$matched_skills = array_intersect($targetSkills, $skills);
					$count = count($matched_skills);
					$score = 0;
					if($count > 0) {
						$hasOneSkill = 1;
						$score = $score + ($count * 1);						
						$endorceList  = Endorse_list::where('received_user_id',$value['user_id'])->get();
						$endorceNoList = array();
						if($endorceList){
							foreach($endorceList as $ekey => $evalue){
								$tmp = Opportunity_card_field::where('id',$evalue->skill_id)->first();							array_push($endorceNoList,$tmp->name);
							}

						}
						if(count($endorceNoList) > 0) $score = $score + (count($endorceNoList) * 2);

						if($country_code == $value['country_code']){
							$score = $score + 1;
						}
						if($country_code == $value['country_code'] && $city == $value['city']){
							$score = $score + 2;
						}
						if($roles){
							foreach($roles as $rkey => $rvalue){
								$pos = strpos($value['title'], $rvalue);
								if ($pos !== false) {
									$score = $score + 2;	
								}
							}
						}
						
						if($hasOneSkill || $score > 5){
							array_push($final,['score' => $score,'index' => $key]);
						}
					}
					

					

				}
				
				usort($final, function ($item1, $item2) {
					return $item2['score'] > $item1['score'];
				});

			
				foreach($final as $k => $v){
					// $ddd = $v['score']."_".$targetopc[$v['index']]->title;
					// echo $ddd."<br />";
					array_push($opw_rlt, $targetopc[$v['index']]);
				}

				
			}

		}
		return view('findmatch',[
			'opportunity_cards' => $opportunity_cards,
			'opentowork_card' => $opentowork_card,
			'user_skills' => $user_skills,
			'user_educations' => $user_educations,
			'user_experiences' => $user_experiences,
			'user' => $user,
			'user_id' => $user_id,
			'third_person'=> $third_person,
			'opt_rlt'=>$opt_rlt,
			'opw_rlt'=>$opw_rlt,
			'card_id'=>$card_id,
			'type' => $type
		]);
	}
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
}