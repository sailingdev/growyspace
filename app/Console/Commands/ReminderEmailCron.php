<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User_message_conversation;
use App\User_message;
use App\User;
use Config;
use Helpers;

class ReminderEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        \Log::info("Cron is working fine!");
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        $CheckUnreceived_list = User_message_conversation::where('is_read',0)->where('sent_remind_email',0)->whereNotNull('sent_remind_date')->where('sent_remind_date', '<=',  date('Y-m-d H:i:s'))->get();
    
    
        if(count($CheckUnreceived_list) > 0){
            \Log::info('Previous one is exist');
            foreach($CheckUnreceived_list as $key => $value){
      
              $msg_con = User_message_conversation::find($value['id']);
              $msg_con->sent_remind_date = null;
              $msg_con->sent_remind_email = 1;
              $msg_con->save(); 
              
            }
        }

        
        $unreceived_list = User_message_conversation::where('is_read',0)->whereNull('sent_remind_date')->get();

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

                    $data = [
                        'to' => $receiver->email,
                        'subject' => $sender->full_name.' messaged you.',
                        'body' => $email_html
                    ];
                    
                    $is_sent = Helpers::send_ses_email($data);   
                    
                        
                    // Helpers::send_mail_html($receiver->email, $sender->full_name.' messaged you.', $email_html, 'no_reply@growyspace.com');	   
                    
                    \Log::info($email_html);
                    
                    $msg_con = User_message_conversation::find($val['id']);
                    $msg_con->sent_remind_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
                    $msg_con->save(); 

                   
                }else{
                    $msg_con = User_message_conversation::find($val['id']);
                    $msg_con->sent_remind_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
                    $msg_con->save(); 
						
                }
            }				
        }

        $this->info('reminder:cron Cummand Run successfully!');
    }
}
