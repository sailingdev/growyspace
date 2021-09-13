<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Config;

class User_message extends Model
{
    protected $table = 'user_messages';
	
	public function from_user_profile_image() {
		return User::find($this->from_id)->profile_image();
	}
	
	public function to_user_profile_image() {
		return User::find($this->to_id)->profile_image();
	}
	
	public function get_messages_html($messages,$user_id) {
		$countries = Config::get('countries');
		$messages_html = '<div class="chat-care">';
		$messages_html .= ' <ul class="chat">';
		foreach($messages as $message) {
			$msg = $message->message;
			$msg_state = 'sent';
			if($message->to_id == $user_id) {
				$msg_state = 'inbox';
			}
			// opportunity
			preg_match('/{CARD\s*(\d+)/', $msg, $matches);
			$card_Prehtml = false;
			$card_html = false;
			if(isset($matches[1])) {
				$card_id = $matches[1];
				$split = explode('{CARD'.$card_id.'}', $msg);
				$card_Prehtml = $split[0];
				$msg = $split[1];
				
				
				$opc = Opportunity_card::find($card_id);
				
				if($opc !== null) {
					
					$card_html = (String) view('opp_card_item',[
						'opc' => $opc,
						'user_id' => $user_id,
						'name' => 'Opportunity',
						'url' =>'cards',
						'msg_state' => $msg_state,
						'countries' => $countries
					]);
					
					// $msg = str_replace("{CARD".$card_id."}","",$msg);
					
				}
			}
			//opentowork
			preg_match('/{OPENTOWORK\s*(\d+)/', $msg, $matches);
				$opentowork_html = false;
				$opentowork_Prehtml = false;
				if(isset($matches[1])) {
					$opentowork_id = $matches[1];
					$split = explode('{OPENTOWORK'.$opentowork_id.'}', $msg);
					$opentowork_Prehtml = $split[0];
					$msg = $split[1];

					$opc = Opentowork_card::find($opentowork_id);
					
					if($opc !== null) {
						
						$opentowork_html = (String) view('opp_card_item',[
							'opc' => $opc,
							'user_id' => $user_id,
							'name' => 'Professional card',
							'url' => 'opentowork',
							'msg_state' => $msg_state,
							'countries' => $countries
						]);
						
						// $msg = str_replace("{OPENTOWORK".$opentowork_id."}","",$msg);
					}
			}	
			//interest
			preg_match('/{INTEREST\s*(\d+)/', $msg, $matches);
				$interest_html = false;
				$interest_Prehtml = false;
				if(isset($matches[1])) {
					$interest_id = $matches[1];
					$split = explode('{INTEREST'.$interest_id.'}', $msg);
					$interest_Prehtml = $split[0];
					$msg = $split[1];

					$opc = Opportunity_card::find($interest_id);
					
					if($opc !== null) {
						
						$interest_html = (String) view('opp_card_item',[
							'opc' => $opc,
							'user_id' => $user_id,
							'name' => 'Interest',
							'url' => 'cards',
							'msg_state' => $msg_state,
							'countries' => $countries
						]);
						
			
					}
			}	
			// user
			preg_match('/{USER\s*(\d+)/', $msg, $matches);
				$user_html = false;
				$user_Prehtml = false;
				if(isset($matches[1])) {
					$msguser_id = $matches[1];
					$split = explode('{USER'.$msguser_id.'}', $msg);
					$user_Prehtml = $split[0];
					$msg = $split[1];
					$opc = User::find($msguser_id);
					
					if($opc !== null) {
						
						$user_html = (String) view('opp_card_item',[
							'opc' => $opc,
							'user_id' => $user_id,
							'name' => 'User',
							'url' => 'user',
							'msg_state' => $msg_state,
							'countries' => $countries
						]);
						
						// $msg = str_replace("{USER".$msguser_id."}","",$msg);
					}
			}	
			// collections
			preg_match('/{COLLECTIONS\s*(\d+)/', $msg, $matches);
				$collection_html = false;
				$collection_Prehtml = false;
				if(isset($matches[1])) {
					$collection_id = $matches[1];
					$split = explode('{COLLECTIONS'.$collection_id.'}', $msg);
					$collection_Prehtml = $split[0];
					$msg = $split[1];

					$opc = User_collection::find($collection_id);
					
					if($opc !== null) {
						$collection_user = User::find($opc->user_id);
						$collection_html = (String) view('opp_card_item',[
							'opc' => $opc,
							'user_id' => $user_id,
							'name' => $opc->name,
							'url' => 'collections',
							'user' => $collection_user->full_name,
							'msg_state' => $msg_state,
							'countries' => $countries
						]);
						
						// $msg = str_replace("{COLLECTIONS".$collection_id."}","",$msg);
					}
			}	
			//News
			preg_match('/{NEWS\s*(\d+)/', $msg, $matches);
				$news_html = false;
				$news_Prehtml = false;
				if(isset($matches[1])) {
					$news_id = $matches[1];
					$split = explode('{NEWS'.$news_id.'}', $msg);
					$news_Prehtml = $split[0];
					$msg = $split[1];

					$opc = News_card::find($news_id);
					
					if($opc !== null) {
						$news_html = (String) view('opp_card_item',[
							'opc' => $opc,
							'name' => 'News',
							'url' => 'news',
						]);
						
						// $msg = str_replace("{NEWS".$news_id."}","",$msg);
					}
			}	
			//attachment
			$attach_html = false;
			if (strpos($msg, '{ATACHMENT}') !== false) {
				$msg = str_replace("{ATACHMENT}", "", $msg);
				$spilt = explode('#',$msg);
				$news_id = 1;
				$opc = News_card::find($news_id);
				$attach_html = (String) view('opp_card_item',[
					'opc' => $opc,
					'original_name' => $spilt[0],
					'real_name' => $spilt[1],
					'user_id' => $user_id,
					'name' => 'Attachment',
					'url' => 'download',
					'msg_state' => $msg_state,
					'countries' => $countries
				]);	
				$msg = '';	
			}
						
			$am_pm_time = date('h:i A  |  F d', strtotime($message->created_at));
			if($message->to_id == $user_id) { //receive
				
				if($card_html !== false) {
					if($card_Prehtml !== false && nl2br($card_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($card_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$card_html.'</li>';
				}
				if($opentowork_html !== false) {
					if($opentowork_Prehtml !== false && nl2br($opentowork_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($opentowork_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';		
					}
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$opentowork_html.'</li>';
				}
				if($interest_html !== false) {
					if($interest_Prehtml !== false && nl2br($interest_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($interest_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';		
					}
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$interest_html.'</li>';
				}
				if($user_html !== false) {
					if($user_Prehtml !== false && nl2br($user_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($user_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';	
					}
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$user_html.'</li>';
				}
				if($collection_html !== false) {
					if($collection_Prehtml !== false  && nl2br($collection_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($collection_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}	
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$collection_html.'</li>';
				}
				if($news_html !== false) {
					if($news_Prehtml !== false  && nl2br($news_Prehtml) !="") {
						$messages_html .= '<li class="agent clearfix">';
						$messages_html .= '<span class="chat-img left clearfix mx-2">';
							$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
						$messages_html .= '</span>';
							$messages_html .= '<div class="chat-body clearfix">';
							$messages_html .= '<p>'.nl2br($news_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';	
					}
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$news_html.'</li>';
				}
				if($attach_html !== false) {
					
					$messages_html .= '<li class="agent incoming_opp_card clearfix">'.$attach_html.'</li>';
				}
				
				if($msg){

					$messages_html .= '<li class="agent clearfix">';
					$messages_html .= '<span class="chat-img left clearfix mx-2">';
						$messages_html .= '<img src="'.$message->from_user_profile_image().'" alt="" class="img-circle" style="width:50px;">';
					$messages_html .= '</span>';
						$messages_html .= '<div class="chat-body clearfix">';
						$messages_html .= '<p>'.nl2br($msg).'</p>';
						$messages_html .= '</div>';
					$messages_html .= '</li>';

				}

			} else { //sender
				if($card_html !== false) {
					if($card_Prehtml !== false && nl2br($card_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($card_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$card_html.'</li>';
				}
				
				if($opentowork_html !== false) {
					if($opentowork_Prehtml !== false && nl2br($opentowork_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($opentowork_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$opentowork_html.'</li>';

				}
				if($interest_html !== false) {
					if($interest_Prehtml !== false && nl2br($interest_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($interest_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$interest_html.'</li>';

				}
				if($user_html !== false) {
					if($user_Prehtml !== false  && nl2br($user_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($user_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$user_html.'</li>';
				}
				if($collection_html !== false) {
					if($collection_Prehtml !== false && nl2br($collection_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($collection_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$collection_html.'</li>';
				}
				if($news_html !== false) {
					if($news_Prehtml !== false  && nl2br($news_Prehtml) !="") {
						$messages_html .= '<li class="admin clearfix">';
							$messages_html .= '<div class="chat-body color-experience clearfix">';
							$messages_html .= '<p>'.nl2br($news_Prehtml).'</p>';
							$messages_html .= '</div>';
						$messages_html .= '</li>';
					}
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$news_html.'</li>';
				}
				if($attach_html !== false) {
					
					$messages_html .= '<li class="admin outgoing_opp_card clearfix">'.$attach_html.'</li>';
				}
				
				if($msg){

					$messages_html .= '<li class="admin clearfix">';
						$messages_html .= '<div class="chat-body color-experience clearfix">';
						$messages_html .= '<p>'.nl2br($msg).'</p>';
						$messages_html .= '</div>';
					$messages_html .= '</li>';
				}
			}
		}
		$messages_html .= '</ul>';
		$messages_html .= '</div>';
		return $messages_html;
	}
	
	public function get_conversations_html($user_id,$messages = NULL,$to_user = NULL,$conversation_messages_count=0) {
		$conversations = DB::table('user_message_conversations')
			->leftJoin('user_messages', 'user_messages.conversation_id', '=', 'user_message_conversations.id')
			->leftJoin('users AS from_user', 'user_messages.from_id', '=', 'from_user.id')
			->leftJoin('users AS to_user', 'user_messages.to_id', '=', 'to_user.id')
			->select(
				'user_message_conversations.*',
				'user_messages.from_id',
				'user_messages.to_id',
				'from_user.full_name AS from_user_name',
				'to_user.full_name AS to_user_name',
				'from_user.profile_image_cropped AS from_user_profile_image_cropped',
				'to_user.profile_image_cropped AS to_user_profile_image_cropped'
			)
			->whereRaw ("(user_messages.from_id ='$user_id' OR user_messages.to_id ='$user_id')")
			->groupBy('user_message_conversations.id')
			->orderBy('user_message_conversations.updated_at','desc')
			->get();
			
		$con_html = '';
		$not_read_class = '';
		$active_conversation_class = '';
		if($to_user !== NULL && $messages !== NULL && $conversation_messages_count == 0 ) {
			$u = User::where('id',$to_user)->first();
			if($u && $u->is_deleted == 0){
				$con_html .= '<div data-user-id = "'.$user_id.'" class="msg_left_item collection_item_block active" style="margin: 0;z-index:999">';
					$con_html .= '<img class="msg_left_img" src="'.$to_user->profile_image().'" />';
					$con_html .= '<p class="msg_left_name">'.$to_user->full_name.'<a href="#" class=" edit_collection_link">';
					if($not_read_class) $con_html .= '<img src="/assets/images/Icon-message-new-message.svg" style="width:30px" alt="Edit">';
					else $con_html .= '<img src="/assets/images/Icon-message-read-message.svg" style="width:30px" alt="Edit">';
					
					$con_html .= '</a></p>';
					$con_html .= '<p class="msg_left_profession">'.$to_user->profession.'</p>';
				$con_html .= '</div>';
			}
				
				
		}
		$z_index = 100;
		foreach($conversations as $con) {
			if($con->from_id == $user_id) {
				$name = $con->to_user_name;
				$id = $con->to_id;
			} else {
				$name = $con->from_user_name;
				$id = $con->from_id;
			}
			// $u = User::find($id);
			$u = User::where('id',$id)->first();
			$active_conversation = false;
			$active_conversation_class = '';
			
			if($to_user !== NULL) {
				$to_user_id  = $to_user->id;
				
				if($to_user_id == $id) {
					$active_conversation = true;
					$active_conversation_class = ' active';
				}
			}
			
			$not_read_class = '';
			
			if($con->is_read == 0 && $con->last_to_id == $user_id) {
				$not_read_class = ' not_read_conversation ';
			}
			
			if($u && $u->is_deleted == 0){

				$con_html .= '<div data-user-id = "'.$id.'" class="msg_left_item ' . $not_read_class . $active_conversation_class .'" style="margin: 0;z-index:'.$z_index.'">';
				$con_html .= '<img class="msg_left_img" src="'.$u->profile_image().'" />';
				$con_html .= '<p class="msg_left_name">'.$name.'<a href="#" class="edit_collection_link">';
				if($not_read_class) $con_html .= '<img src="/assets/images/Icon-message-new-message.svg" style="width:30px" alt="Edit">';
				else $con_html .= '<img src="/assets/images/Icon-message-read-message.svg" style="width:30px" alt="Edit">';
				$con_html .= '</a></p>';
				$con_html .= '<p class="msg_left_profession">'.$u->profession.'</p>';
				$con_html .= '<span class="mgs_date">'.(date('M d', strtotime($con->updated_at))).'</span>';
				$con_html .= '</div>';
				$z_index--;
			}
		}
		
		return $con_html;
	}
	
}
