<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Product_group;
use App\Product_group_images;
use App\Cart;
use App\Order;
use App\Order_product;
use App\User_coupon;
use App\Cart_product;
use App\Shipping_method;
use App\Mark;
use App\Mark_model;
use App\Forgot_password;
use App\User;
use App\Product_group_item;
use App\Mark_model_motorization;
use App\Mark_model_motorization_power;
use Artisan;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\URL;
use Config;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Storage;

use App\Opportunity_card;
use App\Opentowork_card;
use App\Opportunity_card_field;
use App\Roles;
use App\User_skill;
use App\Skill;
use App\User_education;
use App\User_experience;
use App\User_collection;
use App\User_collection_item;
use App\User_message;
use App\User_message_conversation;
use App\Endorse_list;
use Illuminate\Support\Str;


class AjaxController extends Controller
{
    public function __construct()
    {
      
    }
	
	public function get_unread_mesages_info(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$unread_messages_count = User_message_conversation::where('last_to_id',$user_id)->where('is_read',0)->count();
			
			echo json_encode(array(
				'complete' => true,
				'unread_messages_count' => $unread_messages_count
			));
		}
	}
	
	public function save_croped_image(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			
			if(!isset($request->crop_data)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(!isset($request->image)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			


			
			$data = $request->image;
			$image_array_1 = explode(";", $data);
			$image_array_2 = explode(",", $image_array_1[1]);
			$data = base64_decode($image_array_2[1]);
			$filename = 'profile-image-cropped-'.$user_id.'-'.date('YmdHis').'.png';
			$path = base_path() . '/public/uploads/profile/'.$user_id.'/'.$filename;
			
			$cropped_image_info_json = json_encode($request->crop_data);
			
			if($data !== false) {
				
				
				
				file_put_contents($path, $data);
				
				$u = User::find($user_id);
				
				if(trim($u->profile_image_cropped) !='') {
					$old_path = base_path() . '/public/uploads/profile/'.$user_id.'/'.$u->profile_image_cropped;
					
					if(is_file($old_path)) {
						//unlink($old_path);
					}
				}
				
				$u->profile_image_cropped = $filename;
				$u->cropped_image_info = $cropped_image_info_json;
				$u->save();
				
				echo json_encode(array(
					'complete' => true
				));
			} else {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
		
		}
	}
	
	public function upload_profile_image(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			
			if($request->file('profile_image') !== null ) { 
				$ext =  $request->file('profile_image')->getClientOriginalExtension();
				$original_name = $request->file('profile_image')->getClientOriginalName();
				$contentType = $request->file('profile_image')->getClientMimeType();
							
				//$filename      = $request->file('profile_image')->hashName();
				$filename = 'profile-image-'.$user_id.'-'.date('YmdHis').'.'.$ext;
				$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			
				if(! in_array($contentType, $allowedMimeTypes) ){
					echo json_encode(array('complete' => false, 'message' => 'You can only upload image file.'));exit;
				}
				
				$is_ok = $request->file('profile_image')->move(
					base_path() . '/public/uploads/profile/'.$user_id, $filename
				);
				
				$profile_image_src = '';
				
				if($is_ok) {
					$u = User::find($user_id);
					$u->profile_image = $filename;
					$u->profile_image_cropped = $filename;
					$u->save();
					
					$profile_image_src = URL::to('/').'/uploads/profile/'.$user_id.'/'.$filename;
				}
				
				echo json_encode(array(
					'profile_image_src' => $profile_image_src,
					'complete' => true
				));
			}
		}
	}
	
	public function update_my_pitch(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$my_pitch = isset($request->my_pitch) ? $request->my_pitch : false;
			$user = User::find($user_id);
			$user->my_pitch = $my_pitch;
			$user->save();
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function load_messages(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$to_id = isset($request->to_id) ? $request->to_id : 0;
			$last_msg_id = isset($request->last_msg_id) ? $request->last_msg_id : 0;
			$first_msg_id = isset($request->first_msg_id) ? $request->first_msg_id : 0;
			$matchingSend = isset($request->matchingSend) ? $request->matchingSend : 0;
			$user_id = Auth::guard('user')->user()->id;
			$messages_html = '';
			$older_messages_html = '';
			if($to_id != 0) {
				$u = User::find($to_id);
				
				if($u === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				if($to_id == $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
				$c = User_message_conversation::where('conversation_key',$conversation_key)->first();
				$conversation_id = 0;
				
				if($c !== null) {
					$conversation_id = $c->id;
				}
				
				$subquery = "1=1";
			
				if($last_msg_id > 0) {
					$subquery .= " AND id > '$last_msg_id'";
				} 
				
				
				//Lets get older messages
				if($first_msg_id > 0) {
					//$older_messages = User_message::where('id','<',$first_msg_id)->where('conversation_id',$conversation_id)->orderBy('created_at','desc')->limit(5)->get();
					$older_messages = User_message::where('id','<',$first_msg_id)->where('conversation_id',$conversation_id)->orderBy('created_at','desc')->get();
					$older_messages = $older_messages->reverse();
					
					$um = new User_message;
					$older_messages_html = $um->get_messages_html($older_messages,$user_id);
				}
				
				// $messages = User_message::whereRaw($subquery)->where('conversation_id',$conversation_id)->orderBy('created_at','desc')->limit(20)->get();
				$messages = User_message::whereRaw($subquery)->where('conversation_id',$conversation_id)->orderBy('created_at','desc')->get();
				$messages = $messages->reverse();
				
				$conversation_last_message = User_message::where('conversation_id',$conversation_id)->orderBy('created_at','desc')->first();
				
				if($conversation_last_message !== null) {
					if ($conversation_last_message->to_id == $user_id) {
						User_message::where('conversation_id',$conversation_id)->update(['is_read' => 1]);
						$c->is_read = 1;
						$c->save();
					}
				}
				
				$um = new User_message;
				$messages_html = $um->get_messages_html($messages,$user_id);
			}
			
			$um = new User_message;
			$m = isset($messages) ? $messages : NULL;
			$to_user = isset($u) ? $u : NULL;
			
			if(isset($conversation_id)) {
				$conversation_messages_count = User_message::where('conversation_id',$conversation_id)->count();
			} else {
				$conversation_messages_count = 0;
			}
			
			
			$con_html = $um->get_conversations_html($user_id,$m,$to_user,$conversation_messages_count);
			
			
		
						
			echo json_encode(array(
				'older_messages_html' => $older_messages_html,
				'messages_html' => $messages_html,
				'con_html' => $con_html,
				//'conversations' => $conversations,
				'complete' => true
			));exit;
		}
	}
	
	public function send_message(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$message = isset($request->message) ? $request->message : '';
			$to_id = isset($request->to_id) ? $request->to_id : 0;
			$last_msg_id = isset($request->last_msg_id) ? $request->last_msg_id : 0;
			$user_id = Auth::guard('user')->user()->id;
			//$last_message_id = isset($request->to_id) ? $request->to_id : 0;
			$lastCharacter = substr($message, -1);
			if($lastCharacter == "#"){

				$contains = Str::contains($message, url('/'));
				$tmpMsg = '';
				if($contains){
					$svr = url('/')."/";
					$split = explode($svr, $message);
					$tmpMsg = $split[0];
					$rlt = explode('/', $split[1]);
					$key = strtoupper($rlt[0]);
					if($key == "CARDS"){
						$key = "CARD";
					}
	
					// $ect = explode(' ', $rlt[1]);
	
					// $combined = '{'.$key.$ect[0].'}';
					// if(count($ect) > 0){
					// 	$message = $combined." ".$ect[1];
					// }else{
					// 	$message = $combined;
					// }
					$share_no = explode('#', $rlt[1]);
					
	
					$tmpMsg .= 	'{'.$key.$share_no[0].'}';
					$tmpMsg .= 	$share_no[1];
					$message = $tmpMsg;
	
				}
			}else{
				$svr = url('/')."/";
				$split = explode($svr, $message);
				$ordinaryUrl = true;
				$tmpMsg = '';
				if(count($split) > 1){ //user url
					$rlt = explode('/', $split[1]);
					if(count($rlt) > 2){
						if($rlt[0] == "user" && $rlt[2] == "view"){
							$tmpMsg .= 	'{USER'.$rlt[1].'}';
							$message = $tmpMsg;
							$ordinaryUrl = false;
						}
					}
				}
				if($ordinaryUrl){
					$message = preg_replace_callback(
						"@
							(?:http|ftp|https)://
							(?:
								(?P<domain>\S+?) (?:/\S+)|
								(?P<domain_only>\S+)
							)
						@sx",
						function($a){
							$link = "<a href='" . $a[0] . "' style='color:#fff'>";
							$link .= $a[0];
							$link .= "</a>";
							return $link;
						},
						$message
					);
				}


				
			}


			$u = User::find($to_id);
			
			if($u === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($to_id == $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(trim($message) == '') {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
			$umc = User_message_conversation::where('conversation_key',$conversation_key)->first();
			
			if($umc === null) {
				$umc = new User_message_conversation;
				$umc->conversation_key = $conversation_key;
			}
			
			$umc->last_message = $message;
			$umc->last_from_id = $user_id;
			$umc->last_to_id = $to_id;
			$umc->is_read = 0;
			$umc->sent_remind_email = 0;
			$umc->save();
						
			$conversation_id = $umc->id;
			$um = new User_message;
			$um->conversation_id = $conversation_id;
			$um->from_id = $user_id;
			$um->to_id = $to_id;
			$um->is_read = 0;
			$um->message = $message;;
			$um->save();
			$subquery = "1=1";
			
			if($last_msg_id > 0) {
				$subquery .= " AND id > '$last_msg_id'";
			} 
			
			$messages = User_message::whereRaw($subquery)->where('conversation_id',$conversation_id)->orderBy('created_at','desc')->limit(20)->get();
			
			
			$um = new User_message;
			$messages = $messages->reverse();
			$messages_html = $um->get_messages_html($messages,$user_id);
			
			if(isset($conversation_id)) {
				$conversation_messages_count = User_message::where('conversation_id',$conversation_id)->count();
			} else {
				$conversation_messages_count = 0;
			}
			
			
			$con_html = $um->get_conversations_html($user_id,$messages,$u,$conversation_messages_count);
			//
			echo json_encode(array(
				'messages_html' => $messages_html,
				'con_html' => $con_html,
				'complete' => true
			));
			
		}
	}
	public function send_reminder(Request $request) {
		if ($request->ajax()) {
			$user_id = Auth::guard('user')->user()->id;
			$unreceived_list = User_message_conversation::where('last_from_id',$user_id)->where('is_read',0)->whereNull('sent_remind_date')->get();
			if(count($unreceived_list) > 0){
				foreach($unreceived_list as $key => $val){
					$sender = User::where('id',$val['last_from_id'])->first();
					$receiver = User::where('id',$val['last_to_id'])->first();
					if($receiver && $receiver->unsubscribe == 0){

						$sender_image_src = URL::to('/').'/assets/images/noprofileIMG.png';
						if(trim($sender->profile_image_cropped) != '') {
							$path = base_path() . '/public/uploads/profile/'.$sender->id.'/'.$sender->profile_image_cropped;
							
							if(is_file($path)) {
							$sender_image_src = URL::to('/').'/uploads/profile/'.$sender->id.'/'.$sender->profile_image_cropped;
							}
						}
						$receiver_image_src = URL::to('/').'/assets/images/noprofileIMG.png';
						if(trim($receiver->profile_image_cropped) != '') {
							$path2 = base_path() . '/public/uploads/profile/'.$receiver->id.'/'.$receiver->profile_image_cropped;
							
							if(is_file($path2)) {
							$receiver_image_src = URL::to('/').'/uploads/profile/'.$receiver->id.'/'.$receiver->profile_image_cropped;
							}
						}
						$logo_url = URL::to('/').'/assets/images/Icon-message-new-message2.png';
						
						
						$email_html = (String)view('email_templates.message_notification',[
							'logo_url' => $logo_url,
							'receiver_image_src' => $receiver_image_src,
							'sender_image_src' => $sender_image_src,
							'sender' => $sender,
							'receiver' => $receiver,
							'url' => URL::to('/'),
	
						]);
							
						
					
						Helpers::send_mail_html($receiver->email, $sender->full_name.' messaged you.', $email_html, 'no_reply@growyspace.com');	   
	
						$msg_con = User_message_conversation::find($val['id']);
						$msg_con->sent_remind_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
						$msg_con->save(); 
	
						config(['yourconfig.reminderEmail' => 0]);
	
						echo json_encode(array(
							'complete' => true
						));exit;
					}else{
						$msg_con = User_message_conversation::find($val['id']);
						$msg_con->sent_remind_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
						$msg_con->save(); 
	
						config(['yourconfig.reminderEmail' => 0]);
	
						echo json_encode(array(
							'complete' => true
						));exit;						
					}
				}				
			}
		}
	}
	
	public function search_user(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$keyword = isset($request->keyword) ? $request->keyword : '';
			$users = [];
			$response = [];
			
			if(trim($keyword) != '') {
				$users = User::where('is_deleted',0)->where('full_name','like','%'.$keyword.'%')->limit(10)->get();
				
				if($users->count() > 0) {
					foreach($users as $u) {
						$response[] = [
							'id' => $u->id,
							'value' => $u->full_name
						];
					}
				} else {
					$response[] = [
						'id' => 0,
						'value' => 'No user found'
					];
				}
			}
						
			echo json_encode($response);
		}
	}
	public function update_availability(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$available = isset($request->available) ? $request->available : 0;
			$user_id = Auth::guard('user')->user()->id;
			$user = User::find($user_id);
			$user->available = $available;
			$user->save();
						
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function get_collection_items(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}



			$user_id = Auth::guard('user')->user()->id;
			$collection_id = isset($request->collection_id) ? $request->collection_id : false;
					
			$collection = User_collection::find($collection_id);
				
			if ($collection === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($collection->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}

			$third_person = true;
			if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
				$logged_in_user_id = Auth::guard('user')->user()->id;
				if($logged_in_user_id == $collection->user_id) $third_person = false;
			}

			$collection_item_user_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('user_id')->pluck('user_id')->toArray();
			$collection_item_opc_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('opportunity_card_id')->pluck('opportunity_card_id')->toArray();
			$collection_item_opentowork_ids = User_collection_item::where('collection_id',$collection_id)->whereNotNull('opentowork_card_id')->pluck('opentowork_card_id')->toArray();
			
			$users = User::whereIn('id',$collection_item_user_ids)->get();
			$opportunity_cards = Opportunity_card::whereIn('id',$collection_item_opc_ids)->get();

			$opentowork_cards = Opentowork_card::whereIn('id',$collection_item_opentowork_ids)->get();
			
			$items_count = $users->count() + $opportunity_cards->count();
			
			$countries = Config::get('countries');	
			$opportunityList = Opportunity_card::where('user_id',$user_id)->get();
			$opentoworkList = Opentowork_card::where('user_id',$user_id)->get();
			$collection_items_html = (String) view('collections.items',[
				'countries' => $countries,				
				'user_id' => $user_id,			
				'collection_id' => $collection_id,			
				'users' => $users,	
				'collection_name' => $collection->name,				
				'opportunity_cards' => $opportunity_cards,
				'opentowork_cards' => $opentowork_cards,
				'third_person' => $third_person,
				'opc_list' => $opportunityList,
				'opt_list' => $opentoworkList,
			]);
			
			echo json_encode(array(
				'collection_items_html' => $collection_items_html,
				// 'items_count' => $items_count,
				'complete' => true
			));
		}
	}
	
	public function delete_collection(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$collection_id = isset($request->collection_id) ? $request->collection_id : false;
					
			$collection = User_collection::find($collection_id);
				
			if ($collection === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($collection->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$collection->delete();
			User_collection_item::where('collection_id',$collection_id)->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function add_collection(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$collection_name = isset($request->collection_name) ? $request->collection_name : false;
			$collection_edit_mode = isset($request->collection_edit_mode) ? $request->collection_edit_mode : 0;
			$collection_id = isset($request->collection_id) ? $request->collection_id : false;
			
			if(empty($collection_name)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($collection_edit_mode == 1) {
				$collection = User_collection::find($collection_id);
				
				if($collection === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				if($collection->user_id != $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
			} else {
				$collection = new User_collection;
			}
						
			$collection->name = $collection_name;
			$collection->user_id = $user_id;
			$collection->save();
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function add_to_my_collection(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$collection_user_id = isset($request->collection_user_id) ? $request->collection_user_id : false;
			$collection_opc_id = isset($request->collection_opc_id) ? $request->collection_opc_id : false;
			$collection_id = isset($request->collection_id) ? $request->collection_id : false;
			$action_type = isset($request->action_type) ? $request->action_type : false;
			$item_type = isset($request->item_type) ? $request->item_type : false;
			$user_id = Auth::guard('user')->user()->id;
			
			if(!in_array($action_type,['add','remove'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(!in_array($item_type,['user','opc'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($item_type == 'user') {
				$u = User::find($collection_user_id);
				if($u === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
			}
			
			if($item_type == 'opc') {
				$o = Opportunity_card::find($collection_opc_id);
				if($o === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
			}
			
			
			
			
			$collection = User_collection::where('id',$collection_id)->where('user_id',$user_id)->first();
			
			if($collection === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($item_type == 'user') {
				$user_collection_item = User_collection_item::where('collection_id',$collection_id)->where('user_id',$collection_user_id)->first();
			} elseif($item_type == 'opc') {
				$user_collection_item = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$collection_opc_id)->first();
			}
			
			if($action_type == 'add' && $user_collection_item !== null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'User has already is in your collection',
				));exit;
			} else if($action_type == 'remove' && $user_collection_item == null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'The User is not on your collection to remove',
				));exit;
			}
			
			if($action_type == 'add') {
				$user_collection_item = new User_collection_item;
				$user_collection_item->collection_id = $collection_id;
				
				if($item_type == 'user') {
					$user_collection_item->user_id = $collection_user_id;
				} elseif($item_type == 'opc') {
					$user_collection_item->opportunity_card_id = $collection_opc_id;
				}
				
				$user_collection_item->save();
			} else if($action_type == 'remove') {
				$user_collection_item->delete();
			}
						
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				if($item_type == 'user') {
					$ugi = $uc->items_with_user($collection_user_id);
					//$item_type = 'user';
				} elseif($item_type == 'opc') {
					//$item_type = 'user';
					$ugi = $uc->items_with_opc($collection_opc_id);
				}
				
				if($ugi === null) {
					 $tmp = '<a action_type="add" item_type="'.$item_type.'" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a action_type="remove" item_type="'.$item_type.'" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
						
			echo json_encode(array(
				'complete' => true,
				'collections_html' => $collections_html
			));
		}
	}
	public function delete_my_individual_collection(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$collection_id = isset($request->collection_id) ? $request->collection_id : false;
			$item_type = isset($request->item_type) ? $request->item_type : false;
			$item_id = isset($request->item_id) ? $request->item_id : false;

			$user_id = Auth::guard('user')->user()->id;

			$collection = User_collection::where('id',$collection_id)->where('user_id',$user_id)->first();
			
			if($collection === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($item_type == 'user') {
				$user_collection_item = User_collection_item::where('collection_id',$collection_id)->where('user_id',$item_id)->delete();
			} elseif($item_type == 'opportunity') {
				$user_collection_item = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$item_id)->delete();
			} elseif($item_type == 'opentowork') {
				$user_collection_item = User_collection_item::where('collection_id',$collection_id)->where('opentowork_card_id',$item_id)->delete();
			}
			
			
						
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	public function add_to_my_opportunity_collection(Request $request) {
		if(!Auth::guard('user')->check()) {
			echo json_encode(array(
				'complete' => false,
				'message' => 'Wrong Request',
			));exit;
		}
        $inputs = Input::all();
		$item_type = $inputs['name'];
		$card_id = $inputs['pk'];
		
		$user_id = Auth::guard('user')->user()->id;
		if (Input::has('value')){
			$collection_list = $inputs['value'];
		
			if(is_array($collection_list)){
				foreach($collection_list as $key => $collection_id){
					
					$itemList = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->pluck('opportunity_card_id')->toArray();
					
					if(count($itemList) > 0) {
						// already registered
						//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
						
	
					}else{
						$user_collection_item = new User_collection_item;
						$user_collection_item->collection_id = $collection_id;
						$user_collection_item->opportunity_card_id = $card_id;
						$user_collection_item->save();
					}
				}
			}else{
				$collection_id = $collection_list;
				
				$itemList = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->pluck('opportunity_card_id')->toArray();
				
				if(count($itemList) > 0) {
					// already registered
					//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
					
					
	
				}else{
					$user_collection_item = new User_collection_item;
					$user_collection_item->collection_id = $collection_id;
					$user_collection_item->opportunity_card_id = $card_id;
					$user_collection_item->save();
				}
			}		
			echo json_encode(array(
				'complete' => true,
				'msg' => 'Opportunity was added in the collection successfully'
			));
		}else{
			
			$collection = User_collection::where('user_id',$user_id)->get();
			foreach($collection as $key =>$col){
				User_collection_item::where('collection_id',$col->id)->where('opportunity_card_id',$card_id)->delete();
			}	
			echo json_encode(array(
				'complete' => true,
				'msg' => 'Opportunity was removed in the collection successfully'
			));		
		}
					

		
	}	
	public function add_to_my_opentowork_collection(Request $request) {
		if(!Auth::guard('user')->check()) {
			echo json_encode(array(
				'complete' => false,
				'message' => 'Wrong Request',
			));exit;
		}
        $inputs = Input::all();
		$item_type = $inputs['name'];
		$card_id = $inputs['pk'];
		$user_id = Auth::guard('user')->user()->id;
		if (Input::has('value')){
			$collection_list = $inputs['value'];
			if(is_array($collection_list)){
				foreach($collection_list as $key => $collection_id){
					
					$itemList = User_collection_item::where('collection_id',$collection_id)->where('opentowork_card_id',$card_id)->pluck('opentowork_card_id')->toArray();
					
					if(count($itemList) > 0) {
						// already registered
						//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
						

					}else{
						$user_collection_item = new User_collection_item;
						$user_collection_item->collection_id = $collection_id;
						$user_collection_item->opentowork_card_id = $card_id;
						$user_collection_item->save();
					}
				}
			}else{
				$collection_id = $collection_list;
				
				$itemList = User_collection_item::where('collection_id',$collection_id)->where('opentowork_card_id',$card_id)->pluck('opentowork_card_id')->toArray();
				
				if(count($itemList) > 0) {
					// already registered
					//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
					
					

				}else{
					$user_collection_item = new User_collection_item;
					$user_collection_item->collection_id = $collection_id;
					$user_collection_item->opentowork_card_id = $card_id;
					$user_collection_item->save();
				}
			}
			echo json_encode(array(
				'complete' => true,
				'msg' => 'Professional card was added in the collection successfully'
			));
		}else{
			$collection = User_collection::where('user_id',$user_id)->get();
			foreach($collection as $key =>$col){
				User_collection_item::where('collection_id',$col->id)->where('opentowork_card_id',$card_id)->delete();
			}	
			echo json_encode(array(
				'complete' => true,
				'msg' => 'Professional card was removed in the collection successfully'
			));	
		}
					

		
	}	
	public function add_to_my_user_collection(Request $request) {
		if(!Auth::guard('user')->check()) {
			echo json_encode(array(
				'complete' => false,
				'message' => 'Wrong Request',
			));exit;
		}
        $inputs = Input::all();
		$item_type = $inputs['name'];
		$card_id = $inputs['pk'];
		
		$user_id = Auth::guard('user')->user()->id;
		if (Input::has('value')){
			$collection_list = $inputs['value'];
			if(is_array($collection_list)){
				foreach($collection_list as $key => $collection_id){
					
					$itemList = User_collection_item::where('collection_id',$collection_id)->where('user_id',$card_id)->pluck('user_id')->toArray();
					
					if(count($itemList) > 0) {
						// already registered
						//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
						
	
					}else{
						$user_collection_item = new User_collection_item;
						$user_collection_item->collection_id = $collection_id;
						$user_collection_item->user_id = $card_id;
						$user_collection_item->save();
					}
				}
			}else{
				$collection_id = $collection_list;
				
				$itemList = User_collection_item::where('collection_id',$collection_id)->where('user_id',$card_id)->pluck('user_id')->toArray();
				
				if(count($itemList) > 0) {
					// already registered
					//$o = User_collection_item::where('collection_id',$collection_id)->where('opportunity_card_id',$card_id)->delete();
					
					
	
				}else{
					$user_collection_item = new User_collection_item;
					$user_collection_item->collection_id = $collection_id;
					$user_collection_item->user_id = $card_id;
					$user_collection_item->save();
				}
			}
			echo json_encode(array(
				'complete' => true,
				'msg' => 'User was removed in the collection successfully'
			));
		}else{
			$collection = User_collection::where('user_id',$user_id)->get();
			foreach($collection as $key =>$col){
				User_collection_item::where('collection_id',$col->id)->where('user_id',$card_id)->delete();
			}	
			echo json_encode(array(
				'complete' => true,
				'msg' => 'User was removed in the collection successfully'
			));	
		}

		
	}	
	public function get_user_data(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			$logged_in_user_id = Auth::guard('user')->user()->id;
			$user_id = $request->data_user_id;
			$user = User::find($user_id);
			
			if($user === null) {
				echo json_encode(array(
					'message' => 'Wrong Request',
					'complete' => true,
				));exit;
			}
			
			$countries = Config::get('countries');				
			$country_code = $user->country_code;
			$country_name = isset($countries[$country_code]) ? $countries[$country_code] : '';;
			$user->country_name = $country_name;
			
			$user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();
			$skills_html = '';
			
			foreach($user_skills as $skill) {
				$skills_html .= '<span class="user_skill_item_block"><span class="user_skill_item">' . $skill .'</span></span>';
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
			
			$user_experiences = User_experience::where('user_id',$user_id)->get();		
			
			$user_experiences_html = (String) view('user.user_experience',[
				'user_experiences' => $user_experiences,
				'show_actions' => false
			]);
			
			$user_profile_url = URL::to('/').'/user/'.$user_id.'/view';
			$user_collections = User_collection::where('user_id',$logged_in_user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				$ugi = $uc->items_with_user($user_id);
				//var_dump(count((array)$ugi));
				if($ugi === null) {
					 $tmp = '<a action_type="add" item_type="user" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a action_type="remove" item_type="user" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
			
			$owner = false;
			
			if($logged_in_user_id == $user_id) {
				$owner = true;
			}
			
			echo json_encode(array(
				'user_experiences_html' => $user_experiences_html,
				'skills_html' => $skills_html,
				'user' => $user,
				'user_profile_url' => $user_profile_url,
				'collections_html' => $collections_html,
				'owner' => $owner,
				'complete' => true,
			));
		}
	}
	
	public function update_profession(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$profession = isset($request->profession) ? $request->profession : false;
				
				
			$user = User::find($user_id);
			$user->profession = $profession;
			$user->save();
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function delete_experience(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$experience_id = isset($request->exp_id) ? $request->exp_id : false;
			$user_id = Auth::guard('user')->user()->id;
			
			$experience = User_experience::find($experience_id);
			
			if($experience === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($experience->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$experience->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function get_experience_data(Request $request) {
		//
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$experience_id = isset($request->experience_id) ? $request->experience_id : false;
			$user_id = Auth::guard('user')->user()->id;
			
			$experience = User_experience::find($experience_id);
			
			if($experience === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$owner = false;
			
			if($experience->user_id == $user_id) {
				$owner = true;
			}
			/*if($experience->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}*/
			
			
			$from_date = $experience->from_date;
			$experience->from_date_f = date("m/Y", strtotime($from_date));
			
			$from_year = date("Y", strtotime($from_date));
			$from_month = date("m", strtotime($from_date));
			$experience->from_year  = $from_year;
			$experience->from_month = $from_month;
			$to_date = $experience->to_date;
			
			if(trim($to_date) != '') {
				$to_year = date("Y", strtotime($to_date));
				$to_month = date("m", strtotime($to_date));
				$experience->to_year  = $to_year;
				$experience->to_month = $to_month;
				$experience->to_date_f = date("m/Y", strtotime($to_date));
			}
			
			$company_logo_url = $experience->company_logo_url;
			$company_logo_src = '';
			$countries = Config::get('countries');
			
			$country_name = isset($countries[$experience->country_code]) ? $countries[$experience->country_code] : '';;
			$experience->country_name = $country_name;
			
			
			if(is_file(base_path() . '/public/uploads/exp/' . $experience->id . '/' . $company_logo_url)) {
				$company_logo_src = URL::to('/').'/uploads/exp/' . $experience->id . '/' . $company_logo_url;
			}
			
			echo json_encode(array(
				'complete' => true,
				'experience' => $experience,
				'company_logo_src' => $company_logo_src,
				'owner' => $owner
			));
		}
	}
	
	public function add_edit_experience(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$exp_id = isset($request->exp_id) ? $request->exp_id : false;
			$experience_edit_mode = isset($request->experience_edit_mode) ? $request->experience_edit_mode : false;
			
			if($experience_edit_mode == 1 && $exp_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$exp_company = isset($request->exp_company) ? $request->exp_company : false;
			$exp_country_code = isset($request->exp_country_code) ? $request->exp_country_code : false;
			$exp_city = isset($request->exp_city) ? $request->exp_city : false;
			$exp_title = isset($request->exp_title) ? $request->exp_title : false;
			// $exp_from_month = isset($request->exp_from_month) ? $request->exp_from_month : false;
			// $exp_from_year = isset($request->exp_from_year) ? $request->exp_from_year : false;
			// $exp_currently_working = isset($request->exp_currently_working) ? $request->exp_currently_working : 0;
			// $exp_to_month = isset($request->exp_to_month) ? $request->exp_to_month : false;
			// $exp_to_year = isset($request->exp_to_year) ? $request->exp_to_year : false;
			// $exp_description = isset($request->exp_description) ? $request->exp_description : false;
			$to_date = isset($request->exp_to_date) ? $request->exp_to_date : false;
			$from_date = isset($request->exp_from_date) ? $request->exp_from_date : false;
			$user_id = Auth::guard('user')->user()->id;
			
			if($experience_edit_mode == 1) {
				$ue = User_experience::find($exp_id);
				
				if($ue === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
				if($ue->user_id != $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
			} else {
				$ue = new User_experience;
			}
			
			
			if(trim($exp_company) == '') {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(trim($exp_country_code) == '') {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			// $expected_months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
			
			// if(!in_array($exp_from_month,$expected_months)) {
			// 	echo json_encode(array(
			// 		'complete' => false,
			// 		'message' => 'Wrong Request',
			// 	));exit;
			// }
			$exp_currently_working = 0;
			if(!$to_date) $exp_currently_working = 1;
			// if($exp_currently_working == 0) {
			// 	if(!in_array($exp_to_month,$expected_months)) {
			// 		echo json_encode(array(
			// 			'complete' => false,
			// 			'message' => 'Wrong Request',
			// 		));exit;
			// 	}
			// }
			
			// $from_date = $exp_from_year.'-'.$exp_from_month.'-00';
						
			$ue->user_id           = $user_id;
			$ue->company           = $exp_company;
			$ue->country_code      = $exp_country_code;
			$ue->city              = $exp_city;
			$ue->title             = $exp_title;
			$ue->currently_working = $exp_currently_working;
			
			if($exp_currently_working == 1) {
				$ue->to_date = NULL;
			} else {
				// $to_date = $exp_to_year.'-'.$exp_to_month.'-00';
				$ue->to_date = $to_date;
			}
			$ue->from_date = $from_date;
			// $ue->description = $exp_description;
			
			$ue->save();
			
			
			if($request->file('exp_company_logo') !== null ) {
				$ext =  $request->file('exp_company_logo')->getClientOriginalExtension();
				$original_name = $request->file('exp_company_logo')->getClientOriginalName();
				$contentType = $request->file('exp_company_logo')->getClientMimeType();
				
				if($experience_edit_mode == 0) {
					$exp_id = $ue->id;
				}
				
				//$filename      = $request->file('exp_company_logo')->hashName();
				$filename = 'exp'.$exp_id.' '.date('YmdHis').'.'.$ext;
				$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			
				if(! in_array($contentType, $allowedMimeTypes) ){
					echo json_encode(array('complete' => false, 'message' => 'You can only upload image file.'));exit;
				}
				
				$is_ok = $request->file('exp_company_logo')->move(
					base_path() . '/public/uploads/exp/'.$exp_id, $filename
				);
				
				if($is_ok) {
					$ue->company_logo_url = $filename;
					$ue->save();
				}
			}
					
			echo json_encode(array(
				'complete' => true,
				'last_inserted_id' =>$ue->id
			));
		}
	}
	public function update_profile(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}

			$profile_id = isset($request->profile_id) ? $request->profile_id : false;
			if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
				$logged_in_user_id = Auth::guard('user')->user()->id;
				if($logged_in_user_id != $profile_id) abort(404);
			}


			
			$full_name = isset($request->full_name) ? $request->full_name : false;
			$profession = isset($request->profession) ? $request->profession : false;
			$profile_country = isset($request->profile_country) ? $request->profile_country : false;
			$profile_city = isset($request->profile_city) ? $request->profile_city : false;
			$profile_presentation = isset($request->profile_presentation) ? $request->profile_presentation : false;
			$profile_looking_for = isset($request->looking_for) ? $request->looking_for : 0;

				$ue = User::find($profile_id);
				
				if($ue === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
				if($ue->id != $profile_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request2',
					));exit;
				}
			
						
			$ue->country_code      = $profile_country;
			$ue->city              = $profile_city;
			$ue->full_name             = $full_name;
			$ue->profession             = $profession;
			$ue->my_pitch             = $profile_presentation;
			$ue->looking_for             = $profile_looking_for;

			$ue->save();
			
	
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function delete_user_skill(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$skill = isset($request->skill) ? $request->skill : false;
			
			if($skill === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			
			$user_skill = User_skill::where('user_id',$user_id)->where('name',$skill)->first();
			
			if($user_skill === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Skill not found',
				));exit;
			}
			
			$user_skill->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function delete_edu(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$edu_id = isset($request->edu_id) ? $request->edu_id : false;
			
			if($edu_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$edu = User_education::find($edu_id);
		
			if($edu === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($edu->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$edu->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function get_edu_data(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
		}
		
		$edu_id = isset($request->edu_id) ? $request->edu_id : false;
		$user_id = Auth::guard('user')->user()->id;
		
		$edu = User_education::find($edu_id);
		
		if($edu === null) {
			echo json_encode(array(
				'complete' => false,
				'message' => 'Wrong Request',
			));exit;
		}
		
		/*if($edu->user_id != $user_id) {
			echo json_encode(array(
				'complete' => false,
				'message' => 'Wrong Request',
			));exit;
		}*/
		
		$owner = false;
			
		if($edu->user_id == $user_id) {
			$owner = true;
		}
		
		$countries = Config::get('countries');
		$country_code = $edu->country_code;
		$country_name = isset($countries[$country_code]) ? $countries[$country_code] : '';
		
		echo json_encode(array(
			'complete' => true,
			'edu' => $edu,
			'owner' => $owner,
			'country_name' => $country_name,
		));
	}
	
	public function add_edit_education(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$education_edit_mode = isset($request->education_edit_mode) ? $request->education_edit_mode : 0;
			$edu_id = isset($request->edu_id) ? $request->edu_id : false;
			
			if($education_edit_mode == 1 && $edu_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong REquest',
				));exit;
			}
			
			$school = isset($request->school) ? $request->school : false;
			$country_code = isset($request->country_code) ? $request->country_code : false;
			$city = isset($request->city) ? $request->city : false;
			
			$from_year = isset($request->from_year) ? $request->from_year : NULL;
			$to_year = isset($request->to_year) ? $request->to_year : NULL;
			
			if(trim($from_year) != '') {
				if( !($from_year > 1940 && $from_year <= date('Y')) ) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Year',
					));exit;
				}
			}	
			
			if(trim($to_year) != '') {			
				if( !($to_year > 1940 && $to_year <= date('Y') + 7) ) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Year',
					));exit;
				}
			}
			
			$description = isset($request->description) ? $request->description : NULL;
			//$degree  = isset($request->degree ) ? $request->degree  : false;
			$type_of_title  = isset($request->type_of_title ) ? $request->type_of_title  : false;
			$title  = isset($request->title ) ? $request->title  : false;
						
			if($school === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			// if($type_of_title === false) {
			// 	echo json_encode(array(
			// 		'complete' => false,
			// 		'message' => 'Wrong Request1',
			// 	));exit;
			// }
			
			$user_id = Auth::guard('user')->user()->id;
			
			if($education_edit_mode == 1) {
				$ue = User_education::find($edu_id);
				
				if($ue === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
				if($ue->user_id != $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
							
			} else {
				$ue = new User_education;
			}
						
			$ue->user_id = $user_id;
			$ue->school = $school;
			$ue->type_of_title = $type_of_title;
			$ue->title = $title;
			//$ue->degree = $degree;
			$ue->country_code = $country_code;
			$ue->city = $city;
			$ue->from_year = $from_year;
			$ue->to_year = $to_year;
			$ue->description = $description;
			$ue->save();
			
			echo json_encode(array(
				'complete' => true,
				'last_inserted_id' =>$ue->id
			));
		}
	}
	
	public function delete_opc(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc = Opportunity_card::find($opc_id);
		
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($opc->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	public function delete_opentowork(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc = Opentowork_card::find($opc_id);
		
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if($opc->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc->delete();
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function update_skills(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$skills = isset($request->skills) ? $request->skills : [];
			
			if(empty($skills)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			User_skill::where('user_id',$user_id)->delete();
			
			foreach($skills as $skill) {
				$s = Skill::where('name',$skill)->first();
				
				if($s === null) {
					$s_ = new Skill;
					$s_->name= $skill;
					$s_->save();
				}
				
				$user_skill = new User_skill;
				$user_skill->user_id = $user_id;
				$user_skill->name = $skill;
				$user_skill->save();
			}
			
			echo json_encode(array(
				'complete' => true
			));
		}
	}
	
	public function manage_skills(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$user_skills = User_skill::where('user_id',$user_id)->orderBy('name','asc')->pluck('name')->toArray();
			$all_skills = Skill::orderBy('name','asc')->pluck('name')->toArray();
			
			echo json_encode(array(
				'complete' => true,
				'all_skills' => $all_skills,
				'user_skills' => $user_skills,
			));
		}
	}
	
	public function get_opc_all_fields(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$all_opc_fields = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
			
			echo json_encode(array(
				'complete' => true,
				'all_opc_fields' => $all_opc_fields
			));
		}
	}
	
	public function add_edit_opportunity_card(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc_edit_mode = isset($request->opc_edit_mode) ? $request->opc_edit_mode : 0;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			$opc_fields = isset($request->opc_fields) ? $request->opc_fields : [];
			$opc_title = isset($request->opc_title) ? $request->opc_title : false;
			$opc_company = isset($request->opc_company) ? $request->opc_company : false;
			
			$opc_salary = isset($request->opc_salary) ? $request->opc_salary : false;
			$opc_hours = isset($request->opc_hours) ? $request->opc_hours : false;
			$opc_perks = isset($request->opc_perks) ? $request->opc_perks : false;
			$remote = isset($request->remote) ? $request->remote : false;
			
			$opc_country_code = isset($request->opc_country_code) ? $request->opc_country_code : false;
			$opc_city = isset($request->opc_city) ? $request->opc_city : false;
			$opc_description = isset($request->opc_description) ? $request->opc_description : false;
			
			if($opc_edit_mode == 1) {
				if($opc_id === false) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
				$user_id = Auth::guard('user')->user()->id;
				$opc = Opportunity_card::find($opc_id);
			
				if($opc === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				if($opc->user_id != $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
			}
			
			if(empty($opc_fields)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			if(empty($opc_title)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			if(empty($opc_company)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			/*if($opc_salary === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request4',
				));exit;
			}
			
			if(empty($opc_hours)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request5',
				));exit;
			}*/
			
			if(empty($opc_country_code)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request6',
				));exit;
			}
			
			if(empty($opc_city)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request7',
				));exit;
			}
			
			if(empty($opc_description)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request8',
				));exit;
			}
			
			if ($opc_edit_mode == 0) {
				$opc = new Opportunity_card;
			}
			
			$opc_fields_array = explode(',',$opc_fields);
			
			foreach($opc_fields_array as $opc_field) {
				$opf = Opportunity_card_field::where('name',$opc_field)->first();
				
				if ($opf === null) {
					$opf = new Opportunity_card_field;
					$opf->name = $opc_field;
					$opf->save();
				}
			} 
						
			$opc->user_id = Auth::guard('user')->user()->id;
			$opc->title = $opc_title;
			$opc->fields = json_encode($opc_fields_array);
			$opc->salary_range = $opc_salary;
			$opc->perks = $opc_perks;
			$opc->remote = $remote;
			$opc->company = $opc_company;
			$opc->hours = $opc_hours;
			$opc->country_code = $opc_country_code;
			$opc->city = $opc_city;
			$opc->description = $opc_description;
			$opc->save();
			
			if($request->file('opc_company_logo') !== null ) {
				$ext =  $request->file('opc_company_logo')->getClientOriginalExtension();
				$original_name = $request->file('opc_company_logo')->getClientOriginalName();
				$contentType = $request->file('opc_company_logo')->getClientMimeType();
							
				//$filename      = $request->file('opc_company_logo')->hashName();
				$filename = 'opc'.$opc->id.' '.date('YmdHis').'.'.$ext;
				$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			
				if(! in_array($contentType, $allowedMimeTypes) ){
					echo json_encode(array('complete' => false, 'message' => 'You can only upload image file.'));exit;
				}
				
				$is_ok = $request->file('opc_company_logo')->move(
					base_path() . '/public/uploads/opc/'.$opc->id, $filename
				);
				
				if($is_ok) {
					$opc->company_logo_url = $filename;
					$opc->save();
				}
			}
			$matching_users = [];
			if($opc_edit_mode == 0) { //create
				// $dbskills = $opc->fields;
				// $skills = [];					
				// if (trim($dbskills) != '') {
				// 	$skills = json_decode($dbskills,true);
				// }
				// $targetopc  = Opentowork_card::all();
				// foreach($targetopc as $key => $value){
				// 	$opc_fields_json = $value['fields'];
				// 	$targetSkills = [];
					
				// 	if (trim($opc_fields_json) != '') {
				// 		$targetSkills = json_decode($opc_fields_json,true);
				// 	}
				// 	$matched_skills = array_intersect($targetSkills, $skills);
				// 	$count = count($matched_skills);
				// 	if($count > 0) {
				// 		array_push($matching_users, $value['user_id']);
				// 	}
				// }


				// if(count($matching_users) > 0){
				// 	$user_id = 2; //Manuel
				// 	$message = "{CARD".$opc->id."}";
				// 	foreach($matching_users as $key => $to_id){
				// 		$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
				// 		$umc = User_message_conversation::where('conversation_key',$conversation_key)->first();
						
				// 		if($umc === null) {
				// 			$umc = new User_message_conversation;
				// 			$umc->conversation_key = $conversation_key;
				// 		}
						
				// 		$umc->last_message = $message;
				// 		$umc->last_from_id = $user_id;
				// 		$umc->last_to_id = $to_id;
				// 		$umc->is_read = 0;
				// 		$umc->sent_remind_email = 0;
				// 		$umc->save();
									
				// 		$conversation_id = $umc->id;
				// 		$um = new User_message;
				// 		$um->conversation_id = $conversation_id;
				// 		$um->from_id = $user_id;
				// 		$um->to_id = $to_id;
				// 		$um->is_read = 0;
				// 		$um->message = $message;;
				// 		$um->save();
				// 	}
				// }
			}	
		
			echo json_encode(array(
				'complete' => true,
				'last_inserted_id' =>$opc->id
			));
		}
	}
	public function add_edit_opentowork_card(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc_edit_mode = isset($request->opc_edit_mode) ? $request->opc_edit_mode : 0;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			$opc_fields = isset($request->opc_fields) ? $request->opc_fields : [];
			$opc_roles = isset($request->opc_roles) ? $request->opc_roles : [];
			$opc_title = isset($request->opc_title) ? $request->opc_title : false;
			$opc_email = isset($request->opc_email) ? $request->opc_email : false;
			
			$opc_salary = isset($request->opc_salary) ? $request->opc_salary : false;
			$opc_hours = isset($request->opc_hours) ? $request->opc_hours : false;
			
			$opc_country_code = isset($request->opc_country_code) ? $request->opc_country_code : false;
			$opc_city = isset($request->opc_city) ? $request->opc_city : false;
			$opc_description = isset($request->opc_description) ? $request->opc_description : false;
			$opc_phone = isset($request->opc_phone) ? $request->opc_phone : false;
			$refer = isset($request->refer) ? $request->refer : 0;

			if($opc_edit_mode == 1) {
				if($opc_id === false) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request1',
					));exit;
				}
				
				$user_id = Auth::guard('user')->user()->id;
				$opc = Opentowork_card::find($opc_id);
			
				if($opc === null) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
				
				if($opc->user_id != $user_id) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Request',
					));exit;
				}
			}
			
			if(empty($opc_fields)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			if(empty($opc_roles)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			if(empty($opc_title)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			
			
			if(empty($opc_country_code)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request6',
				));exit;
			}
			
			if(empty($opc_city)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request7',
				));exit;
			}
			
			if(empty($opc_description)) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request8',
				));exit;
			}
			
			if ($opc_edit_mode == 0) {
				$opc = new Opentowork_card;
			}
			
			$opc_fields_array = explode(',',$opc_fields);
			
			foreach($opc_fields_array as $opc_field) {
				$opf = Opportunity_card_field::where('name',$opc_field)->first();
				
				if ($opf === null) {
					$newopf = new Opportunity_card_field;
					$newopf->name = $opc_field;
					$newopf->save();
				}
			} 

			$opc_roles_array = explode(',',$opc_roles);
			
			foreach($opc_roles_array as $opc_role) {
				
				$opf_role = Roles::where('name',$opc_role)->get();
				
				if (count($opf_role) == 0) {
					$newopf_role = new Roles;
					$newopf_role->name = $opc_role;
					$newopf_role->save();
				}
			} 						
			$opc->user_id = Auth::guard('user')->user()->id;
			$opc->title = $opc_title;
			$opc->fields = json_encode($opc_fields_array);
			$opc->roles = json_encode($opc_roles_array);
			$opc->salary = $opc_salary;
			$opc->email = $opc_email;
			$opc->hours = $opc_hours;
			$opc->country_code = $opc_country_code;
			$opc->city = $opc_city;
			$opc->description = $opc_description;
			$opc->refer = $refer;
			$opc->phone = $opc_phone;
			$opc->save();
			
						
			echo json_encode(array(
				'complete' => true,
				'last_inserted_id' =>$opc->id
			));
		}
	}	
	public function get_opc_collections(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc = Opportunity_card::find($opc_id);
			
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				$ugi = $uc->items_with_opc($opc_id);
				//var_dump(count((array)$ugi));//
				if($ugi === null) {
					 $tmp = '<a collection_opc_id = "'.$opc_id.'" action_type="add" item_type="opc" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a collection_opc_id = "'.$opc_id.'" action_type="remove" item_type="opc" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
			
			echo json_encode(array(
				'complete' => true,
				'collections_html' => $collections_html
			));
			
		}
	}
	public function get_opc_collection_list(Request $request) {
		if ($request->ajax()) {
			$rlt = array();
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$opc = Opportunity_card::find($opc_id);
			
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				// $ugi = $uc->items_with_opc($opc_id);
				$collectonID = $uc->id;
				$user_collections_items = User_collection_item::where('collection_id',$collectonID)->whereNotNull('opportunity_card_id')->get();
				//$itemList = User_collection_item::where('collection_id',$collectonID)->where('opportunity_card_id',$opc)->pluck('opportunity_card_id')->toArray();
				//if(count($itemList) > 0){
				// if(count($user_collections_items))	$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				//}else{
					
				//}



				// foreach($itemList as $key => $value) {
				// 	$opc  = Opportunity_card::find($value);
				// 	if($opc && $opc->title){

				// 		$rlt[] = ["value" => $value, "text" => $opc->title];
				// 	}
				// }
				
				
				
			}
			
			echo json_encode($rlt);
			
		}
	}
	public function get_opentowork_collection_list(Request $request) {
		if ($request->ajax()) {
			$rlt = array();
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$opc = Opentowork_card::find($opc_id);
			
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				// $ugi = $uc->items_with_opc($opc_id);
				$collectonID = $uc->id;
				$user_collections_items = User_collection_item::where('collection_id',$collectonID)->whereNotNull('opentowork_card_id')->get();
			
				// if(count($user_collections_items))	$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				
			}
			
			echo json_encode($rlt);
			
		}
	}
	public function get_user_collection_list(Request $request) {
		if ($request->ajax()) {
			$rlt = array();
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->id) ? $request->id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$opc = User::find($opc_id);
			
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				$collectonID = $uc->id;
				$user_collections_items = User_collection_item::where('collection_id',$collectonID)->whereNotNull('user_id')->get();
				// if(count($user_collections_items))$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				$rlt[] = ["value" => $collectonID, "text" => $uc->name];
				
			}
			
			echo json_encode($rlt);
			
		}
	}
	public function get_endorse_list(Request $request) {
		if ($request->ajax()) {
			$rlt = array();
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			$skill = isset($request->skill) ? $request->skill : false;
	
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}

			$opSkill = Opportunity_card_field::where('name',$skill)->first();
			$given_userList = Endorse_list::where('received_user_id',$opc_id)->where('skill_id',$opSkill->id)->pluck('given_user_id')->toArray();

	
			
			foreach($given_userList as $user) {
				$name = User::where('id',$user)->first();
				$rlt[] = ["value" => $user, "text" => $name->full_name];
							
			}
			
			echo json_encode($rlt);
			
		}
	}
	
	
	public function get_user_collections(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$logged_in_user_id = Auth::guard('user')->user()->id;
			$user_id = isset($request->user_id) ? $request->user_id : false;
			
			$user = User::find($user_id);
			
			if($user === null) {
				echo json_encode(array(
					'message' => 'Wrong Request',
					'complete' => true,
				));exit;
			}
			
			$user_collections = User_collection::where('user_id',$logged_in_user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				$ugi = $uc->items_with_user($user_id);
				
				if($ugi === null) {
					 $tmp = '<a collection_user_id="'.$user_id.'" action_type="add" item_type="user" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a collection_user_id="'.$user_id.'" action_type="remove" item_type="user" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
			
			echo json_encode(array(
				'complete' => true,
				'collections_html' => $collections_html
			));
		}
	}
	
	public function get_opc_data(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
					'action' => 'redirect_to_login_page'
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$opc_id = isset($request->opc_id) ? $request->opc_id : false;
			
			if($opc_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$opc = Opportunity_card::find($opc_id);
			
			if($opc === null) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			
			if($opc->user_id == $user_id) {
				$owner = true;
			} else {
				$owner = false;
			}
			/*if($opc->user_id != $user_id) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}*/
			
			$company_logo_url = $opc->company_logo_url;
			$company_logo_src = '';
			
			if(is_file(base_path() . '/public/uploads/opc/' . $opc->id . '/' . $company_logo_url)) {
				$company_logo_src = URL::to('/').'/uploads/opc/' . $opc->id . '/' . $company_logo_url;
			}
			
			$all_opc_fields = Opportunity_card_field::orderBy('name','asc')->pluck('name')->toArray();
			$countries = Config::get('countries');
			
			$country_name = isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : '';;
			$opc->country_name = $country_name;
			
			$user_collections = User_collection::where('user_id',$user_id)->get();
			$collections_html = '';
			
			foreach($user_collections as $uc) {
				$ugi = $uc->items_with_opc($opc_id);
				//var_dump(count((array)$ugi));//
				if($ugi === null) {
					 $tmp = '<a action_type="add" item_type="opc" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/add_to_my_collection.png" /> Add to <strong>'.$uc->name.'</strong></a>';
				} else {
					$tmp = '<a action_type="remove" item_type="opc" collection_id = "'.$uc->id.'" class="add_to_my_collection" href="#"><img src="/assets/images/remove_from_collection.png" /> Remove from <strong>'.$uc->name.'</strong></a>';
				}
				
				$collections_html .= '<li>'.$tmp.'</li>';
			}
			
			
			
			echo json_encode(array(
				'complete' => true,
				'company_logo_src' => $company_logo_src,
				'opc_data' => $opc,
				'description_formatted' => nl2br($opc->description),
				'all_opc_fields' => $all_opc_fields,
				'owner' => $owner,
				'collections_html' => $collections_html
			));
		}
	}
	
	public function update_colissimo_address(Request $request) {
		if ($request->ajax()) {
			
			$adresse1 = isset($request->adresse1) ? $request->adresse1 : '';
			$adresse2 = isset($request->adresse2) ? $request->adresse2 : '';
			$adresse3 = isset($request->adresse3) ? $request->adresse3 : '';
			$codePays = isset($request->codePays) ? $request->codePays : '';
			$codePostal = isset($request->codePostal) ? $request->codePostal : '';
			$colissimo_address = $adresse1.' '.$adresse2.' '.$adresse3.' '.$codePostal.' '.$codePays;
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			$cart_row->colissimo_address = $colissimo_address;
			$cart_row->save();
			
			echo json_encode(array(
				'complete' => true,
				'colissimo_address' => $colissimo_address
			));
		}
	}
	
	public function forgot_password_request(Request $request) {
		if ($request->ajax()) {
			
			$account_email = isset($request->account_email) ? $request->account_email : false;
			
			if($account_email === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request'
				));
			}
			
			$user = User::where('email',$account_email);
			
			if($user->count() == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Your provided email is not in our system'
				));exit;
			}
			
			$token = md5(uniqid(rand(), true));
			$recover_email_link = URL::to('/').'/user/recover_password/'.$token;
			
			$fp = new Forgot_password;
			$fp->email = $account_email;
			$fp->token = $token;
			$fp->save();
			
			$logo_url = URL::to('/').'/assets/images/SmallLogo.png';
			$email_html = (String)view('email_templates.forgot_password',[
				'recover_email_link' => $recover_email_link,
				'logo_url' => $logo_url
			]);


		$data = [
			'to' => $user->first()->email,
			'subject' => 'Growyspace reset password',
			'body' => $email_html,
			'from' => 'no_reply@growyspace.com'
		];
		$is_sent = Helpers::send_ses_email($data);			
		// Helpers::send_mail_html($user->first()->email, 'Growyspace reset password', $email_html, 'no_reply@growyspace.com');
			
		echo json_encode(array(
			'complete' => true
		));
		}
	}
	
	public function get_colissimo_widget(Request $request) {
		if ($request->ajax()) {
			
			$url = 'https://ws.colissimo.fr/widget-point-retrait/rest/authenticate.rest';
			
			$data = array(
				"login" => "351420",
				"password" => "Autoouest22"
			);

			$postdata = json_encode($data);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$result = curl_exec($ch);
			curl_close($ch);
			$result_array = json_decode($result,true);			
			
			echo json_encode(array(
				'complete' => true,
				'token' => $result_array['token']
			));
		}
	}
	
	public function complete_cash_order(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('admin')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$cart_products = $cart_row->products;
			$cart_shipping_id = $cart_row->shipping_id;
					
			if(count($cart_products) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Shopping cart empty',
				));exit;
			}
			
			
			$user_id = isset($request->user_id) ? $request->user_id : 0;
			$by_facture = isset($request->by_facture) ? $request->by_facture : 0;
			$discount = isset($request->discount) ? $request->discount : 0;
			$user = User::find($user_id);
			
			if (count((array)$user) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Client',
				));exit;
			}
			
			////////////////////////////////////////////////
			$facture_max_id = Order::max('facture_id');
			# We insert a new order in the order table with the 'initialised' status
			$order = new Order;
			$order->user_id = $user->id;
			$order->status = 'pending';
					
			$order->products_count = count($cart_products);
			$order->subtotal = $cart_row->subtotal;
			$order->shipping_id = $cart_row->shipping_id;
			$order->shipping_price = $cart_row->shipping_price;
			
			if($discount > 0) {
				$order->coupon_price = $discount;
				$order->coupon_percentage = NULL;
				$order->coupon_code = 'Cash';
			}
						
			$order->order_total_price = $cart_row->order_total_price - $discount;
			$order->email = $user->email;
			$ship_phone = $user->ship_phone;
			
			if(trim($ship_phone) == '') {
				$ship_phone = $user->bill_phone;
			}
			
			$shipping_address_recipient_name = $user->ship_first_name.' '.$user->ship_last_name;
			
			if(trim($shipping_address_recipient_name) == '') {
				$shipping_address_recipient_name = $user->bill_first_name.' '.$user->bill_last_name;
			}
			
			$shipping_address_address = $user->ship_address;
			
			if(trim($shipping_address_address) == '') {
				$shipping_address_address = $user->bill_address;
			}
			
			$shipping_address_state = $user->ship_state;
			
			if(trim($shipping_address_state) == '') {
				$shipping_address_state = $user->bill_state;
			}
			
			$shipping_address_zip = $user->ship_zip; 
			
			if(trim($shipping_address_zip) == '') {
				$shipping_address_zip = $user->bill_zip; 
			}
			
			$shipping_address_country_id = $user->ship_country_id;
			
			if (trim($shipping_address_country_id) == '') {
				$shipping_address_country_id = $user->bill_country_id;
			}
			
			$order->is_professional = $user->is_professional;
			$order->company         = $user->company;;
			$order->intra_VAT_number = $user->intra_VAT_number; 
			$order->RCS_number      = $user->RCS_number; 
					
			$order->shipping_address_phone          = $ship_phone;
			$order->shipping_address_recipient_name = $shipping_address_recipient_name;
			$order->shipping_address_address        = $shipping_address_address; 
			$order->shipping_address_state          = $shipping_address_state; 
			$order->shipping_address_zip            = $shipping_address_zip; 
			$order->shipping_address_country_id     = $shipping_address_country_id; 
			
			$order->by_facture                      = $by_facture; 
			$order->info_text                      = $cart_row->info_text; 
			
			if($by_facture) {
				$order->facture_id                  = $facture_max_id + 1; 
			} else {
				$order->facture_id  = NULL;
			}
			
			$order->payment_type                    = 'Cash'; 	
			$order->save();
			$orderId = $order->id;
			
			# We insert the suborder (products) into the table
			foreach ($cart_products as $item) {
				$suborder = new Order_product;
				$suborder->order_id = $orderId;
				$suborder->product_id = $item->product_id;
				$suborder->product_title = $item->product_title;
				$suborder->product_group_id = $item->product_group_id;
				
				$product_image_path = base_path() . '/public/uploads/product_group_images/'.$item->product_group_id.'/'.$item->product_image_url;
				$order_images_path = base_path() . '/public/uploads/orders/'.$orderId;
				
				if (!is_dir($order_images_path)) {
					mkdir($order_images_path, 0755,true);
				}
				
				if(is_file($product_image_path)) {
					copy($product_image_path, $order_images_path.'/'.$item->product_image_url);
				}
				
				$suborder->product_image_url = $item->product_image_url;
				$suborder->quantity = $item->quantity;
				$suborder->product_price = $item->product_price;
				$suborder->include_exchange = $item->include_exchange;
				$suborder->include_seal = $item->include_seal;
				$suborder->include_exchange_price = $item->include_exchange_price;
				$suborder->include_seal_price = $item->include_seal_price;
				$suborder->unit_price         = $item->unit_price;
				$suborder->total_price        = $item->total_price;
				$suborder->ref_item           = $item->ref_item;
				$suborder->save();
			}

			$cart_ref_items = Cart_product_ref_item::where('cart_id',$cart_row->id)->get();

			foreach($cart_ref_items as $cart_ref_item) {
				$opri = new Order_product_ref_item;
				$opri->order_id        = $orderId;
				$opri->product_id      = $cart_ref_item->product_id;
				$opri->ref_item        = $cart_ref_item->ref_item;
				$opri->qty             = $cart_ref_item->qty;
				$opri->facture_item_id = $cart_ref_item->facture_item_id;
				$opri->save();
			}

			$o = new Order;
			$order_product = $o->get_orders_products($orderId);
			$countries = Config::get('countries');	
			
			$invoice_html = (String)view('checkout.order_html',[
				'order' => $order,
				'width' => 'width:1000px',
				'order_product' => $order_product,
				'countries' => $countries
			]);
			
			$email_html = (String)view('checkout.order_html',[
				'order' => $order,
				'width' => 'width:600px',
				'order_product' => $order_product,
				'countries' => $countries
			]);
					 
			$order_images_path = base_path() . '/public/uploads/orders/'.$orderId;	
				
			PDF::loadHTML($invoice_html)->setPaper('a4', 'landscape')->setWarnings(false)->save($order_images_path.'/invoice.pdf');
			$subject = "New Auto-Turbo Order";
			Helpers::mail_attachment($user->email, $subject, $email_html, 'auto-turbo22@hotmail.com', $order_images_path.'/invoice.pdf','invoice.pdf');
			
			Cart_product::where('cart_id',$cart_row->id)->delete();
			$cart_row->delete();
			setcookie("cart", -1, time()- 3600*24*30,'/'); 
			
			echo json_encode(array(
				'complete' => true,
			));
			
		}
	}
	
	public function update_cart_row_ref(Request $request) {
		if ($request->ajax()) {
			
			if(!Auth::guard('admin')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$ref = isset($request->ref) ? $request->ref : '';
			$cart_row_id = isset($request->cart_row_id) ? $request->cart_row_id : 0;
			
			
			$cart_product_row = Cart_product::where('id',$cart_row_id)->where('cart_id',$cart_row->id)->first();
			
			if(count((array)$cart_product_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$cart_product_row->ref_item = $ref;
			$cart_product_row->save();
						
			echo json_encode(array(
					'complete' => true,
			));
		}
	}
	
	
	public function remove_cart_coupon(Request $request) {
		if ($request->ajax()) {
						
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$subtotal = $cart_row->subtotal;
			$coupon_price = 0;
			$shipping_price = $cart_row->shipping_price;
			$cart_row->coupon_price = $coupon_price;
			$cart_row->coupon_code = NULL;
			$cart_row->coupon_percentage = 0;
			
			$order_total_price = $subtotal + $shipping_price;
			$cart_row->order_total_price = $order_total_price;
			
			$cart_row->save();
						
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function apply_coupon(Request $request) {
		if ($request->ajax()) {
			$coupon_code = isset($request->coupon_code) ? $request->coupon_code : false;
			
			if($coupon_code === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$coupon = User_coupon::where('code', $coupon_code)->first();
			
			if(count((array)$coupon) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Coupon Code',
				));exit;
			}
			
			$percentage = $coupon->percentage;
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$subtotal = $cart_row->subtotal;
			$coupon_price = ($subtotal*$percentage)/100;
			$shipping_price = $cart_row->shipping_price;
			$cart_row->coupon_price = $coupon_price;
			$cart_row->coupon_code = $coupon_code;
			$cart_row->coupon_percentage = $percentage;
			
			$order_total_price = $subtotal - $coupon_price  + $shipping_price;
			$cart_row->order_total_price = $order_total_price;
			
			$cart_row->save();
						
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function update_cart_aditional_text(Request $request) {
		if ($request->ajax()) {
			$order_aditional_info = isset($request->order_aditional_info) ? $request->order_aditional_info : '';
						
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$cart_row->info_text = $order_aditional_info;
			$cart_row->save();
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}

	public function update_shipping_method(Request $request) {
		if ($request->ajax()) {
			$shipping_id = isset($request->shipping_id) ? $request->shipping_id : false;
			
			if($shipping_id === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			if($shipping_id == 0) {
				$cart_row->shipping_id = NULL;
			} else {
				$shipping_method = Shipping_method::find($shipping_id);
				
				if(count((array)$shipping_method) == 0) {
					echo json_encode(array(
						'complete' => false,
						'message' => 'Wrong Shipping method.',
					));exit;
				}
				
				$cart_row->shipping_id = $shipping_id;
				$cart_row->shipping_price = $shipping_method->price;
				$coupon_price = (float)$cart_row->coupon_price;
				$cart_row->order_total_price = (trim($cart_row->shipping_price) == '' ? 0 : $cart_row->shipping_price) + $cart_row->subtotal - $coupon_price;
			}
			
			$cart_row->save();
			
			echo json_encode(array(
				'complete' => true,
			));
		}
	}
	
	public function update_cart(Request $request) {
		
		if ($request->ajax()) {
			$product_id = isset($request->product_id) ? $request->product_id : false;
			$cart_product_qty = isset($request->cart_product_qty) ? $request->cart_product_qty : false;
			$include_exchange = isset($request->include_exchange) ? $request->include_exchange : false;
			$include_seal = isset($request->include_seal) ? $request->include_seal : false;
			$cart_row_id = isset($request->cart_row_id) ? $request->cart_row_id : false;
			
			if(
				$cart_row_id === false ||
				$product_id === false ||
				$cart_product_qty === false ||
				$include_exchange === false ||
				$include_seal === false
			) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request1',
				));exit;
			}
			
			if(!isset($_COOKIE['cart'])) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request2',
				));exit;
			}
			
			$token = $_COOKIE['cart'];
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request3',
				));exit;
			}
			
			$product = Product::find($product_id);
			
			if(count((array)$product) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request4',
				
				));exit;
			}
			
			$price = $product->group->price;
			$price2 = $product->group->price2;
			
			$is_fair_request = Cart_product::where('id',$cart_row_id)->where('cart_id',$cart_row->id)->count() > 0 ? true : false;

			if($is_fair_request === false) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request4',
				
				));exit;
			}
			
			/////////////////////////
			$needed_product_count_in_cart = $cart_product_qty;
			
			$ref_items = Product_group_item::where('group_id',$product->group_id)->pluck('name')->toArray();
			$available_ref_items_count = Facture_item::whereIn('reference',$ref_items)->where('available_quantity','>',0)->sum('available_quantity');
						
			if($available_ref_items_count < $needed_product_count_in_cart) {
				if($cart_product_qty == 1) {
					$message2 = 'Pour commander ce produit veuillez contacter l’équipe de auto-turbo.fr par courrier électronique ou téléphone afin de pouvoir effectuer les démarches ensemble .Notre équipe est à votre disposition';
				} else {
					$message2 = 'Pour raison de stock insuffisant, veuillez contacter l’équipe  de auto-turbo.fr afin de pouvoir commander le quantité nécessaire . Notre équipe est à votre disposition .';
				}
				
				$cart = new Cart;
				$cart_products = $cart->get_cart_products($token);
				$shipping_methods = Shipping_method::all();
				$cart_shipping_id = $cart_row->shipping_id;
				$order_aditional_info  = $cart_row->info_text;
				$users = User::all();
				
				$shopping_cart_html = (String) view('checkout.shopping_cart',[
					'cart_products' => $cart_products,
					'shipping_methods' => $shipping_methods,
					'cart_shipping_id' => $cart_shipping_id,
					'order_aditional_info' => $order_aditional_info,
					'cart_row' => $cart_row,
					'users' => $users
					
				]);
				
				echo json_encode(array(
					'complete' => false,
					'message' => 'No enough available in stock',
					'availability_problem' => 1,
					'message2' => $message2,
					'shopping_cart_html' => $shopping_cart_html,
					'available_ref_items' => $available_ref_items_count,
					'needed_product_count_in_cart' => $needed_product_count_in_cart
				));exit;
			}

			$available_ref_items = Facture_item::whereIn('reference',$ref_items)->where('available_quantity','>',0)->orderBy('available_quantity','desc')->get();
			
			Cart_product_ref_item::where('cart_id',$cart_row->id)->where('product_id',$product_id)->delete();
			$t = $needed_product_count_in_cart;
			
			foreach($available_ref_items as $available_item) {
				$available_quantity = $available_item->available_quantity;
				$facture_item_id = $available_item->id;
				
				if($t > 0 && $t <= $available_quantity) {
					$cpri = new Cart_product_ref_item;
					$cpri->cart_id = $cart_row->id;
					$cpri->product_id = $product_id;
					$cpri->ref_item = $available_item->reference;
					$cpri->qty = $t;
					$cpri->facture_item_id = $facture_item_id;
					$cpri->save();
					$t = 0;
				} else if($t > 0 && $t > $available_quantity) {
					$cpri = new Cart_product_ref_item;
					$cpri->cart_id = $cart_row->id;
					$cpri->product_id = $product_id;
					$cpri->ref_item = $available_item->reference;
					$cpri->qty = $available_quantity;
					$cpri->facture_item_id = $facture_item_id;
					$cpri->save();
					$t = $t - $available_quantity;
				}
			}
			
			if($cart_product_qty == 0) {
				Cart_product::find($cart_row_id)->delete($cart_row_id);
			} else {
				
				$cart_product = Cart_product::find($cart_row_id);
				$product_price = $price;
				$include_exchange_price = 0.00;
				$include_seal_price = 0.00;
				
				if ($include_exchange == 1) {
					$include_exchange_price = $product->group->price2;
				}
				
				if($include_seal) {
					$include_seal_price = 15.00;
				}
				
				$main_image = Product_group_images::where('group_id',$product->group_id)->where('is_main',1)->first();
				$image_url = '';
								
				if(count((array)$main_image) > 0) {
					$image_url = $main_image->image_url;
				}
								
				$unit_price   = $product_price + $include_exchange_price + $include_seal_price;
				$total_price  = $unit_price * $cart_product_qty;
				
				$cart_product->cart_id = $cart_row->id;
				$cart_product->product_id = $product_id;
				$cart_product->product_title = $product->title;
				$cart_product->product_group_id = $product->group_id;
				$cart_product->product_image_url = $image_url;
				$cart_product->product_price = $product_price;
				$cart_product->include_seal = $include_seal;
				$cart_product->include_exchange = $include_exchange;
				$cart_product->include_seal_price = $include_seal_price;
				$cart_product->include_exchange_price = $include_exchange_price;
				$cart_product->quantity = $cart_product_qty;
				$cart_product->total_price = $total_price;
				$cart_product->unit_price = $unit_price;
				$cart_product->save();
								
				Cart_product::where('id','!=',$cart_row_id)->where('cart_id',$cart_row->id)->
										where('product_id',$product_id)->
										where('include_seal',$include_seal)->
										where('include_exchange',$include_exchange)->delete();
			}
			
			$cart_count = Cart_product::where('cart_id',$cart_row->id)->count();
			$cart_subtotal = Cart_product::where('cart_id',$cart_row->id)->sum('total_price');
			$cart_row->subtotal = $cart_subtotal;
			
			if(trim($cart_row->shipping_id) == '') {
				$default_shipping_method = Shipping_method::where('default',1)->first();
				
				if(count((array)$default_shipping_method) > 0) {
					$cart_row->shipping_id = $default_shipping_method->shipping_id;
					$cart_row->shipping_price = $default_shipping_method->price;
					//$cart_row->order_total_price = (trim($cart_row->shipping_price) == '' ? 0 : $cart_row->shipping_price) + $cart_row->subtotal;
				}
				
			} else {
				
			}
			
			$coupon_percentage = (float) $cart_row->coupon_percentage;
			$coupon_price = 0.00;
			
			if($coupon_percentage > 0) {
				$coupon_price = ($cart_subtotal*$coupon_percentage) / 100;
			}
			
			if($cart_count == 0) {
				$cart_row->shipping_id = NULL;
				$cart_row->shipping_price = 0;
				$cart_row->coupon_price = 0;
				$cart_row->coupon_code = NULL;
				$cart_row->coupon_percentage = 0;
			}
			
			$cart_row->coupon_price = $coupon_price;
			$cart_row->order_total_price = (trim($cart_row->shipping_price) == '' ? 0 : $cart_row->shipping_price) + $cart_row->subtotal - $coupon_price;
			$cart_row->products_count = $cart_count;
			$cart_row->save();
			
			$cart = new Cart;
			$cart_products = $cart->get_cart_products($token);
			$shipping_methods = Shipping_method::all();
			$cart_shipping_id = $cart_row->shipping_id;
			$order_aditional_info  = $cart_row->info_text;
			$users = User::all();
			
			$shopping_cart_html = (String) view('checkout.shopping_cart',[
				'cart_products' => $cart_products,
				'shipping_methods' => $shipping_methods,
				'cart_shipping_id' => $cart_shipping_id,
				'order_aditional_info' => $order_aditional_info,
				'cart_row' => $cart_row,
				'users' => $users
				
			]);
			
			echo json_encode(array(
				'complete' => true,
				'shopping_cart_html' => $shopping_cart_html,
				'cart_count' => $cart_count,
				'coupon_price' => $coupon_price,
				'cart_row' => $cart_row,
				'coupon_percentage' => $coupon_percentage
			));
			
		}
	}
	public function add_to_cart(Request $request) {
		if ($request->ajax()) {
			$product_id = isset($request->product_id) ? $request->product_id : false;
			$product_qty = isset($request->product_qty) ? $request->product_qty : false;
			$include_exchange = isset($request->include_exchange) ? $request->include_exchange : false;
			$include_seal = isset($request->include_seal) ? $request->include_seal : false;
					
			$mode = isset($request->mode) ? $request->mode : 'add';
					
			if (
				$product_id === false || 
				$product_qty === false || 
				$include_exchange === false || 
				$include_seal === false
			) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				
				));exit;
			}
			
			if( !is_numeric($product_qty) || $product_qty < 1 || $product_qty > 20)  {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				
				));exit;
			}
			
			$product = Product::find($product_id);
			
			if(count((array)$product) == 0) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				
				));exit;
			}
					
			$price = $product->group->price;
						
			$prod_ref = Product_group_item::where('group_id',$product->group_id)->first();
			$ref_item = $prod_ref->name;
			
			if(!isset($_COOKIE['cart'])) {
				$token = md5(uniqid (rand (),true));
				setcookie("cart", $token, time()+3600*24*30,'/'); 
				
			} else {
				$token = $_COOKIE['cart'];
			}
			
			$cart_row = Cart::where('token',$token)->first();
			
			if(count((array)$cart_row) == 0) {
				$cart_row = new Cart;
				$cart_row->token = $token;
				$cart_row->save();
			}
			
			$needed_product_count_in_cart = Cart_product::where('cart_id',$cart_row->id)->
										where('product_id',$product_id)->sum('quantity') + 1;
			
			$ref_items = Product_group_item::where('group_id',$product->group_id)->pluck('name')->toArray();
			$available_ref_items_count = Facture_item::whereIn('reference',$ref_items)->where('available_quantity','>',0)->sum('available_quantity');
						
			if($available_ref_items_count < $needed_product_count_in_cart) {
				
				if($needed_product_count_in_cart == 1) {
					$message2 = 'Pour commander ce produit veuillez contacter l’équipe de auto-turbo.fr par courrier électronique ou téléphone afin de pouvoir effectuer les démarches ensemble .Notre équipe est à votre disposition';
				} else {
					$message2 = 'Pour raison de stock insuffisant, veuillez contacter l’équipe  de auto-turbo.fr afin de pouvoir commander le quantité nécessaire . Notre équipe est à votre disposition .';
				}
				
				echo json_encode(array(
					'complete' => false,
					'message' => 'No enough available in stock',
					'availability_problem' => 1,
					'message2' => $message2,
					'available_ref_items' => $available_ref_items_count,
					'needed_product_count_in_cart' => $needed_product_count_in_cart
				));exit;
			}

			$available_ref_items = Facture_item::whereIn('reference',$ref_items)->where('available_quantity','>',0)->orderBy('available_quantity','desc')->get();
			
			Cart_product_ref_item::where('cart_id',$cart_row->id)->where('product_id',$product_id)->delete();
			$t = $needed_product_count_in_cart;
			
			foreach($available_ref_items as $available_item) {
				$available_quantity = $available_item->available_quantity;
				$facture_item_id = $available_item->id;
							
				if($t > 0 && $t <= $available_quantity) {
					$cpri = new Cart_product_ref_item;
					$cpri->cart_id = $cart_row->id;
					$cpri->product_id = $product_id;
					$cpri->ref_item = $available_item->reference;
					$cpri->qty = $t;
					$cpri->facture_item_id = $facture_item_id;
					$cpri->save();
					$t = 0;
				} else if($t > 0 && $t > $available_quantity) {
					$cpri = new Cart_product_ref_item;
					$cpri->cart_id = $cart_row->id;
					$cpri->product_id = $product_id;
					$cpri->ref_item = $available_item->reference;
					$cpri->qty = $available_quantity;
					$cpri->facture_item_id = $facture_item_id;
					$cpri->save();
					$t = $t - $available_quantity;
				}
			}
			
			$cart_product = Cart_product::where('cart_id',$cart_row->id)->
										where('product_id',$product_id)->
										where('include_seal',$include_seal)->
										where('include_exchange',$include_exchange)->first();
										
			if (count((array)$cart_product) > 0) {
				$new_quantity = $cart_product->quantity + $product_qty;
				$new_total_price = $new_quantity * $cart_product->unit_price;
				$cart_product->quantity = $new_quantity;
				$cart_product->total_price = $new_total_price;
				$cart_product->ref_item = $ref_item;
				$cart_product->save();
			} else {
				$product_price = $price;
				$include_exchange_price = 0.00;
				$include_seal_price = 0.00;
				
				if ($include_exchange == 1) {
					$include_exchange_price = $product->group->price2;
				}
				
				if($include_seal) {
					$include_seal_price = 15.00;
				}
				
				$main_image = Product_group_images::where('group_id',$product->group_id)->where('is_main',1)->first();
				$image_url = '';
								
				if(count((array)$main_image) > 0) {
					$image_url = $main_image->image_url;
				}
								
				$unit_price   = $product_price + $include_exchange_price + $include_seal_price;
				$total_price  = $unit_price * $product_qty;
				$cart_product = new Cart_product;
				$cart_product->cart_id = $cart_row->id;
				$cart_product->product_id = $product_id;
				$cart_product->product_title = $product->title;
				$cart_product->product_group_id = $product->group_id;
				$cart_product->product_image_url = $image_url;
				$cart_product->product_price = $product_price;
				$cart_product->include_seal = $include_seal;
				$cart_product->include_exchange = $include_exchange;
				$cart_product->include_seal_price = $include_seal_price;
				$cart_product->include_exchange_price = $include_exchange_price;
				$cart_product->quantity = $product_qty;
				$cart_product->total_price = $total_price;
				$cart_product->unit_price = $unit_price;
				$cart_product->ref_item = $ref_item;
				$cart_product->save();
			}
			
			$cart_count = Cart_product::where('cart_id',$cart_row->id)->count();
			$cart_subtotal = Cart_product::where('cart_id',$cart_row->id)->sum('total_price');
			$cart_row->subtotal = $cart_subtotal;
			
			$coupon_price = (float)$cart_row->coupon_price;
			$cart_row->order_total_price = (trim($cart_row->shipping_price) == '' ? 0 : $cart_row->shipping_price) + $cart_row->subtotal - $coupon_price;
			$cart_row->products_count = $cart_count;
			$cart_row->save();
			
			echo json_encode(array(
				'complete' => true,
				'cart_count' => $cart_count,
				'token' => $token
			));
		}
	}
	
	public function dynamic_mark_model_motorization_power(Request $request) {
		if ($request->ajax()) {
			$dependence = $request->dependence;
			$data_id      = $request->data_id;
			
			if ($dependence == 'mark') {
				$options = Mark_model::where('mark_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'model_id';
			} else if($dependence == 'model') {
				$options = Mark_model_motorization::where('model_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'motorization_id';
			} else if($dependence == 'motorization') {
				$options = Mark_model_motorization_power::where('motorization_id',$data_id)->orderBy('name','ASC')->get();
				$id_field = 'power_id';
			}
			$options_html = '';
			
			foreach($options as $option) {
				$options_html.= '<option value="'.$option->id.'">'.$option->name.'</option>';
			}
			
			echo json_encode(array(
				'complete' => true,
				'options_html' => $options_html,
				'options' => $options
			));
		}
	}
	public function delete_account(Request $request){
		// $user_id = Auth::guard('user')->user()->id;		
		// $user = User::find($user_id)->delete();
		$user_id = Auth::guard('user')->user()->id;
		$user = User::find($user_id);
		$user->is_deleted = 1; 
		$user->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'Your account has been deleted',
		));
	}

	public function hide_account(Request $request){		
		$user_id = Auth::guard('user')->user()->id;
		$user = User::find($user_id);
		if($user->is_hidden == 1 ){
			$user->is_hidden = 0; 
			$str = "activated";
		}else {
			$user->is_hidden = 1; 
			$str = "hidden";
		}
		

		$user->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'Your account has been '.$str,
		));
	}
	public function activeNotificationEmail(Request $request){		
		$user_id = Auth::guard('user')->user()->id;
		$user = User::find($user_id);
		if($user->unsubscribe == 1 ){
			$user->unsubscribe = 0; 
			$str = "activated";
		}else {
			$user->unsubscribe = 1; 
			$str = "hidden";
		}
		

		//$user->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'Email Notification has been '.$str,
		));
	}
	public function hide_opentowork(Request $request){		
		$data_id  = $request->id;
		$opentowork = Opentowork_card::find($data_id);
		if($opentowork->refer == 1 ){
			$opentowork->refer = 0; 
			$str = "activated";
		}else {
			$opentowork->refer = 1; 
			$str = "hidden";
		}
		

		$opentowork->save();
		echo json_encode(array(
			'complete' => true,
			'messages_html' => 'The Professional card has been '.$str,
		));
	}
	public function endorse_opentowork(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			$received_user =  isset($request->received_user) ? $request->received_user : 0;
			$skillparam =  isset($request->skill) ? $request->skill : "";
			$optid =  isset($request->optid) ? $request->optid : 0;
			if($user_id == $received_user){
				echo json_encode(array(
					'complete' => false,
					'message' => 'Can\'t endorse own value',
				));exit;
			}

			$opSkill = Opportunity_card_field::where('name',$skillparam)->first();
			$itemList = Endorse_list::where('received_user_id',$received_user)->where('given_user_id',$user_id)->where('skill_id',$opSkill->id)->first();

			if($itemList && $itemList->id){
				Endorse_list::where('id',$itemList->id)->delete();
			}else{
				$endorse_item = new Endorse_list;
				$endorse_item->received_user_id = $received_user;
				$endorse_item->given_user_id = $user_id;
				$endorse_item->skill_id = $opSkill->id;
				$endorse_item->save();

				$logo_url = URL::to('/').'/assets/images/SmallLogo.png';			
				$link = URL::to('/').'/opentowork/'.$optid;
				$email_html = (String)view('email_templates.endorce',[
					'link' => $link,
					'logo_url' => $logo_url
				]);
	
				// $u = User::where('id',$received_user)->first();
				// $data = [
				// 	'to' => $u->email,
				// 	'subject' => 'Someone endorsed your skills',
				// 	'body' => $email_html,
				// 	'from' => 'no_reply@growyspace.com'
				// ];

				// $is_sent = Helpers::send_ses_email($data);

			}



			echo json_encode(array(
				'complete' => true,
				'message' => 'Success',
			));
		}
	}
	public function findmatchResult(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}

			$user_id = Auth::guard('user')->user()->id;
			$type =  isset($request->type) ? $request->type : '';
			$card_id =  isset($request->id) ? $request->id : 0;
		
			if($type == 'opw'){
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
						$score = $score + ($count * 1);						
						$endorceList  = Endorse_list::where('received_user_id',$opc->user_id)->get();
						$endorceNoList = array();
						if($endorceList){
							foreach($endorceList as $ekey => $evalue){
								$tmp = Opportunity_card_field::where('id',$evalue->skill_id)->first();							array_push($endorceNoList,$tmp->name);
							}

						}
						if(count($endorceNoList) > 0) $score = $score + (count($endorceNoList) * 2);
					}
					
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
					
					if($score > 5){
						array_push($final,['score' => $score,'index' => $key]);
					}
					

				}
				
				usort($final, function ($item1, $item2) {
					return $item2['score'] > $item1['score'];
				});

				$rlt = array();
				foreach($final as $k => $v){
					array_push($rlt, $targetopc[$v['index']]);
				}

				echo json_encode(array(
					'complete' => true,
					'result' => $rlt,
					'type' => 'opw'
				));
				
			}else if($type == 'opt'){
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
						$score = $score + ($count * 1);						
						$endorceList  = Endorse_list::where('received_user_id',$opc->user_id)->get();
						$endorceNoList = array();
						if($endorceList){
							foreach($endorceList as $ekey => $evalue){
								$tmp = Opportunity_card_field::where('id',$evalue->skill_id)->first();							array_push($endorceNoList,$tmp->name);
							}

						}
						if(count($endorceNoList) > 0) $score = $score + (count($endorceNoList) * 2);
					}
					
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
					
					if($score > 5){
						array_push($final,['score' => $score,'index' => $key]);
					}
					

				}
				
				usort($final, function ($item1, $item2) {
					return $item2['score'] > $item1['score'];
				});

				$rlt = array();
				foreach($final as $k => $v){
					array_push($rlt, $targetopc[$v['index']]);
				}

				echo json_encode(array(
					'complete' => true,
					'result' => $rlt,
					'type' => 'opt'
				));
			}
		}
	}

	public function Send_to_all_matches(Request $request) {
		if ($request->ajax()) {
			$opc_id = $request->id;
			$type =  isset($request->type) ? $request->type : '';
			$matching_users = isset($request->checked) ? $request->checked : [];
			if(count($matching_users) == 0){
				echo json_encode(array(
					'complete' => false,
				));	
			}
			if($type == 'opw'){
			

				$opc = Opentowork_card::find($opc_id);


				if(count($matching_users) > 0){
					$user_id = $opc->user_id;
					$message = "{OPENTOWORK".$opc->id."}";
					foreach($matching_users as $key => $to_id){
						$to_id = (int)$to_id;
						if($to_id != 0) {
							$u = User::find($to_id);
							
							if($u === null) {
								// echo json_encode(array(
								// 	'complete' => false,
								// 	'message' => 'Wrong Request',
								// ));exit;
							}else{
								
								if($to_id == $user_id) {
									// echo json_encode(array(
									// 	'complete' => false,
									// 	'message' => 'Wrong Request',
									// ));exit;
								}else{
									$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
									$umc = User_message_conversation::where('conversation_key',$conversation_key)->first();
									
									if($umc === null) {
										$umc = new User_message_conversation;
										$umc->conversation_key = $conversation_key;
									}
									
									$umc->last_message = $message;
									$umc->last_from_id = $user_id;
									$umc->last_to_id = $to_id;
									$umc->is_read = 0;
									$umc->sent_remind_email = 0;
									$umc->updated_at = date("Y-m-d H:i:s");
									$umc->save();
												
									$conversation_id = $umc->id;
									$um = new User_message;
									$um->conversation_id = $conversation_id;
									$um->from_id = $user_id;
									$um->to_id = $to_id;
									$um->is_read = 0;
									$um->message = $message;;
									$um->save();
								}								
							}

						}
					}
				}

				echo json_encode(array(
					'complete' => true,
				));				
				
			}else if($type == 'opt'){
			

				$opc = Opportunity_card::find($opc_id);
				
				if(count($matching_users) > 0){
					$user_id = $opc->user_id;
					$message = "{CARD".$opc->id."}";
					foreach($matching_users as $key => $to_id){
						$to_id = (int)$to_id;
						$conversation_key = $to_id > $user_id ? md5($user_id.'_'.$to_id) : md5($to_id.'_'.$user_id);
						$umc = User_message_conversation::where('conversation_key',$conversation_key)->first();
						
						if($umc === null) {
							$umc = new User_message_conversation;
							$umc->conversation_key = $conversation_key;
						}
						
						$umc->last_message = $message;
						$umc->last_from_id = $user_id;
						$umc->last_to_id = $to_id;
						$umc->is_read = 0;
						$umc->sent_remind_email = 0;
						$umc->updated_at = date("Y-m-d H:i:s");
						$umc->save();
									
						$conversation_id = $umc->id;
						$um = new User_message;
						$um->conversation_id = $conversation_id;
						$um->from_id = $user_id;
						$um->to_id = $to_id;
						$um->is_read = 0;
						$um->message = $message;;
						$um->save();
					}
				}
				echo json_encode(array(
					'complete' => true,
				));				
			}
			

			
		}
	}
	public function export_PDF(Request $request) {
		if ($request->ajax()) {
			$card_id = $request->id;
			$type =  isset($request->type) ? $request->type : '';
			if($type == 'opw'){
				$opc  = Opentowork_card::find($card_id);
				if($opc === null) {
					abort(404);
				}
				$third_person = true;
				$logged_in_user_id = 0;
				if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
					$logged_in_user_id = Auth::guard('user')->user()->id;
					if($logged_in_user_id == $opc->user_id) $third_person = false;
		
				}
			
				$countries = Config::get('countries');
		
				$opc_fields_json = $opc->fields;
				$opc_fields = [];
				
				if (trim($opc_fields_json) != '') {
					$opc_fields = json_decode($opc_fields_json,true);
				}
		
				$opc_roles_json = $opc->roles;
				$opc_roles = [];
				
				if (trim($opc_roles_json) != '') {
					$opc_roles = json_decode($opc_roles_json,true);
				}
				$meta_title = $opc->title;
		
				//skill vs endorse
				$endorsed_users = [];
				foreach($opc_fields as $skill){
					$opSkill = Opportunity_card_field::where('name',$skill)->first();
					$itemList = Endorse_list::where('received_user_id', $opc->user_id)->where('skill_id', $opSkill->id)->pluck('given_user_id')->toArray();
					$endorsed_users[$skill] = $itemList;
				}
		
				//getting my opportunity list
				
				$opportunityList = Opportunity_card::where('user_id',$logged_in_user_id)->get();
				$user_educations = User_education::where('user_id',$opc->user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();
				$user_experiences = User_experience::where('user_id',$opc->user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
				
				//SEO
				$og_url = URL::to('/')."/opentowork"."/".$opc->id;
				$og_title = $opc->company.' '.$opc->title;
				$og_description = $opc->description;
				$og_image = URL::to('/')."/assets/images/external-icon open-to-work.png";
		
				$pdf_html = (String)view('PDF.opentowork',[
					'countries' => $countries,
					'opc_fields' => $opc_fields,
					'opc_roles' => $opc_roles,
					'opc_endorse' => $endorsed_users,
					'meta_title' => $meta_title,
					'opc' => $opc,
					'logged_in_user_id'=> $logged_in_user_id,
					'third_person'=> $third_person,
					'opc_list' => $opportunityList,
					'user_id' => $logged_in_user_id,
					'opportunity_card_page' => true,
					'user_educations' => $user_educations,
					'user_experiences' => $user_experiences,
					'og_url'=>$og_url,
					'og_title'=>$og_title,
					'og_description'=>$og_description,
					'og_image'=>$og_image,
				]);
				$order_images_path = base_path() . '/public/uploads/PDF/'.$type.'/'.$card_id;
				if (!is_dir($order_images_path)) {
					mkdir($order_images_path, 0777,true);
				}
				$pdf = PDF::loadHTML($pdf_html);
				$pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($order_images_path.'/opentowork.pdf');
                
				return $pdf->download('opentowork.pdf');
					
				
			}else if($type == 'opt'){
			
			}
			

			
		}
	}
	public function upload_attachment(Request $request) {
		if ($request->ajax()) {
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			
			$user_id = Auth::guard('user')->user()->id;
			
			if($request->file('attachment_files') !== null ) { 
				$ext =  $request->file('attachment_files')->getClientOriginalExtension();
				$original_name = $request->file('attachment_files')->getClientOriginalName();
				$contentType = $request->file('attachment_files')->getClientMimeType();
							
				//$filename      = $request->file('profile_image')->hashName();
				$filename = 'attachement-'.$user_id.'-'.date('YmdHis').'.'.$ext;
				// $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			
				// if(! in_array($contentType, $allowedMimeTypes) ){
				// 	echo json_encode(array('complete' => false, 'message' => 'You can only upload image file.'));exit;
				// }
				
				// $is_ok = $request->file('attachment_files')->move(
				// 	base_path() . '/public/uploads/attachment_files/', $filename
				// );
				
				//$profile_image_src = '';
				
				//if($is_ok) {
					// $u = User::find($user_id);
					// $u->profile_image = $filename;
					// $u->profile_image_cropped = $filename;
					// $u->save();
					
					//$profile_image_src = URL::to('/').'/uploads/attachments/'.$user_id.'/'.$filename;
				//}

				$path = $request->file('attachment_files')->storeAs('attachment_files', $filename); //storage/app/attachment_files

				echo json_encode(array(
					'filename' => $filename,
					'complete' => true
				));
			}
		}
	}
	public function download_attachment(Request $request) {
	
		
			if(!Auth::guard('user')->check()) {
				echo json_encode(array(
					'complete' => false,
					'message' => 'Wrong Request',
				));exit;
			}
			$file = $request->file;
			// $path = base_path() . '/public/uploads/attachment_files/attachement-61-20210402182017.pdf';
			// return response()->download($path,$file);

			return Storage::download('attachment_files/'.$file);
		
	}
	public function exportOPW(Request $request) {

			$card_id = $request->id;
			$type = 'OPW';
				$opc  = Opentowork_card::find($card_id);
				if($opc === null) {
					abort(404);
				}
				$third_person = true;
				$logged_in_user_id = 0;
				if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
					$logged_in_user_id = Auth::guard('user')->user()->id;
					if($logged_in_user_id == $opc->user_id) $third_person = false;
		
				}
			
				$countries = Config::get('countries');
		
				$opc_fields_json = $opc->fields;
				$opc_fields = [];
				
				if (trim($opc_fields_json) != '') {
					$opc_fields = json_decode($opc_fields_json,true);
				}
		
				$opc_roles_json = $opc->roles;
				$opc_roles = [];
				
				if (trim($opc_roles_json) != '') {
					$opc_roles = json_decode($opc_roles_json,true);
				}
				$meta_title = $opc->title;
		
				//skill vs endorse
				$endorsed_users = [];
				foreach($opc_fields as $skill){
					$opSkill = Opportunity_card_field::where('name',$skill)->first();
					$itemList = Endorse_list::where('received_user_id', $opc->user_id)->where('skill_id', $opSkill->id)->pluck('given_user_id')->toArray();
					$endorsed_users[$skill] = $itemList;
				}
		
				//getting my opportunity list
				
				$opportunityList = Opportunity_card::where('user_id',$logged_in_user_id)->get();
				$user_educations = User_education::where('user_id',$opc->user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();
				$user_experiences = User_experience::where('user_id',$opc->user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
				
				//SEO
				$og_url = URL::to('/')."/opentowork"."/".$opc->id;
				$og_title = $opc->company.' '.$opc->title;
				$og_description = $opc->description;
				$og_image = URL::to('/')."/assets/images/external-icon open-to-work.png";
		
				// $pdf_html = (String)view('PDF.opentowork',[
				// 	'countries' => $countries,
				// 	'opc_fields' => $opc_fields,
				// 	'opc_roles' => $opc_roles,
				// 	'opc_endorse' => $endorsed_users,
				// 	'meta_title' => $meta_title,
				// 	'opc' => $opc,
				// 	'logged_in_user_id'=> $logged_in_user_id,
				// 	'third_person'=> $third_person,
				// 	'opc_list' => $opportunityList,
				// 	'user_id' => $logged_in_user_id,
				// 	'opportunity_card_page' => true,
				// 	'user_educations' => $user_educations,
				// 	'user_experiences' => $user_experiences,
				// 	'og_url'=>$og_url,
				// 	'og_title'=>$og_title,
				// 	'og_description'=>$og_description,
				// 	'og_image'=>$og_image,
				// ]);
				// $order_images_path = base_path() . '/public/uploads/PDF/'.$type.'/'.$card_id;
				// if (!is_dir($order_images_path)) {
				// 	mkdir($order_images_path, 0777,true);
				// }
				// $pdf = PDF::loadHTML($pdf_html);
				// $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($order_images_path.'/opentowork.pdf');
                
				// return $pdf->download('opentowork.pdf');
				$data = 
					[
						'countries' => $countries,
						'opc_fields' => $opc_fields,
						'opc_roles' => $opc_roles,
						'opc_endorse' => $endorsed_users,
						'meta_title' => $meta_title,
						'opc' => $opc,
						'logged_in_user_id'=> $logged_in_user_id,
						'third_person'=> $third_person,
						'opc_list' => $opportunityList,
						'user_id' => $logged_in_user_id,
						'opportunity_card_page' => true,
						'user_educations' => $user_educations,
						'user_experiences' => $user_experiences,
						'og_url'=>$og_url,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'og_image'=>$og_image,
					];
				  
				  $pdf = PDF::loadView('PDF.opentowork', $data);  
				  return $pdf->download('professional card-'.$card_id.'.pdf');

				// return view('PDF.opentowork',$data);
	}
	public function exportOPP(Request $request) {

			$card_id = $request->id;
			$type = 'OPW'; 
				$opc  = Opportunity_card::find($card_id);
				if($opc === null) {
					abort(404);
				}
				$third_person = true;
				$logged_in_user_id = 0;
				if(Auth::guard('user')->user() && Auth::guard('user')->user()->id){
					$logged_in_user_id = Auth::guard('user')->user()->id;
					if($logged_in_user_id == $opc->user_id) $third_person = false;
		
				}
			
				$countries = Config::get('countries');
		
				$opc_fields_json = $opc->fields;
				$opc_fields = [];
				
				if (trim($opc_fields_json) != '') {
					$opc_fields = json_decode($opc_fields_json,true);
				}
		
				$opc_roles_json = $opc->roles;
				$opc_roles = [];
				
				if (trim($opc_roles_json) != '') {
					$opc_roles = json_decode($opc_roles_json,true);
				}
				$meta_title = $opc->title;
		
				
		
				//getting my opportunity list
				
				$opentoworkList = Opentowork_card::where('user_id',$logged_in_user_id)->get();
				$user_educations = User_education::where('user_id',$opc->user_id)->orderByRaw('-to_year','desc')->orderBy('from_year', 'Desc')->get();
				$user_experiences = User_experience::where('user_id',$opc->user_id)->orderByRaw('-to_date','desc')->orderBy('from_date', 'Desc')->get();
				
				//SEO
				$og_url = URL::to('/')."/opentowork"."/".$opc->id;
				$og_title = $opc->company.' '.$opc->title;
				$og_description = $opc->description;
				$og_image = URL::to('/')."/assets/images/external-icon open-to-work.png";
				$remote = '';
				if($opc && $opc->remote){
					if($opc->remote == 1) $remote = 'This is a remote position';
					else if($opc->remote == 2) $remote = 'This is an onsite position';
					else if($opc->remote == 3) $remote = 'This is a flexible position';
				}
				$data = 
					[
						'countries' => $countries,
						'opc_fields' => $opc_fields,
						'opc_roles' => $opc_roles,
						'meta_title' => $meta_title,
						'opc' => $opc,
						'remote' => $remote,
						'logged_in_user_id'=> $logged_in_user_id,
						'third_person'=> $third_person,
						'opc_list' => $opentoworkList,
						'user_id' => $logged_in_user_id,
						'opportunity_card_page' => true,
						'user_educations' => $user_educations,
						'user_experiences' => $user_experiences,
						'og_url'=>$og_url,
						'og_title'=>$og_title,
						'og_description'=>$og_description,
						'og_image'=>$og_image,
					];
				  
				  $pdf = PDF::loadView('PDF.opportunity', $data);  
				  return $pdf->download('Opportunity card-'.$card_id.'.pdf');

				// return view('PDF.opportunity',$data);
	}
}
