<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Config;
use App\Category; 
use App\User_collection; 
use App\Product; 
use App\Email_message; 
use App\Skill; 
use App\User;  
use App\Opportunity_card_field; 
use Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Opportunity_card;
use App\User_message_conversation;
use Helpers;

class MessageController extends Controller
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
    public function index($user_id=null)
    {
		if(isset($_GET['test'])) {
			// $this->send_remind_new_message_emails();
		}
		if(!Auth::guard('user')->check()) {
			session(['redirect_back' => url()->full()]);
			return redirect('user/login');
		}
		
		$user = NULL;
		
		if($user_id !== NULL) {
			$user = User::find($user_id);
			$logged_in_user_id = Auth::guard('user')->user()->id;
			
			if($user === null || $logged_in_user_id == $user_id) {
				return redirect('/messages');
			}
			
			if($user->is_deleted == 1) {
				return redirect('/messages')->withInput()->withErrors(['Not allowing to send message to a cancelled user']);
			}
			
			$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
			 
			if(trim($msg) != '') { 
				setcookie("default_msg", $msg, time() + 30, "/messages/".$user_id);
				return redirect('/messages/'.$user_id); 
			}
			
			
		}
		
		$default_msg = isset($_COOKIE['default_msg']) ? base64_decode($_COOKIE['default_msg']) : '';
						
		return view('messages',[
			'default_msg' => $default_msg,
			'user' => $user
		]);
	}
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
	public function send_remind_new_message_emails() {
		
		$e = new Email_message;
		//$em->from = 'grosyspace';
		//$em->to = 'popok';
		//$em->subject = 'popok';
		//$em->text = 'popok';
		//$em->save();				
		$startTime = date("Y-m-d H:i:s");
		$cenvertedTime = date('Y-m-d H:i:s',strtotime('-5 minutes',strtotime($startTime)));
		
		$messages_to_remind = User_message_conversation::where('is_read',0)->where('sent_remind_email',0)->where('updated_at','<',$cenvertedTime)->get();
		//mail('artashespapikyan1984@gmail.com','testsub777777'.$messages_to_remind->count(),'testdesc7777');
			$email_html = (String)view('email_templates.new_message_reminder',[
				
			]);
		if($messages_to_remind->count() > 0) {
			
			foreach($messages_to_remind as $m) {
				$last_to_id = $m->last_to_id;
				$conversation_id = $m->id;
				
				$user = User::find($last_to_id);
				$email = $user->email;
				
				//if($last_to_id == 1) {
					//Helpers::send_mail_html($email, 'Growyspace new message reminder', $email_html, 'no_reply@growyspace.com');
					$c = User_message_conversation::find($conversation_id);
					$c->sent_remind_email = 1;
					$c->save();
					
					$em = new Email_message;
					$em->from = 'grosyspace';
					$em->to = $email;
					$em->subject = 'Growyspace new message reminder';
					$em->text = $email_html;
					$em->save();
					
					$e->send_external_email($email, 'Growyspace new message reminder',$email_html);
					
				//}
			}
		}
		 
		// $e->send_external_email('artashespapikyan1984@gmail.com', 'Growyspace new message reminder777',$email_html);
		
	}
}