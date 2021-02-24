<?php

namespace App\Providers;
use App\Page; 
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

use Auth;
use App\User_message_conversation;
use App\User_message;
use App\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
		// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
		// 	$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// 	header('HTTP/1.1 301 Moved Permanently');
		// 	header('Location: ' . $location);
		// 	exit;
		// }
		
		// URL::forceScheme('https');
		
		view()->composer('*', function($settings) {
      $countries = Config::get('countries');
      config(['yourconfig.countries' => $countries]);

      if(Auth::guard('user')->check()) {
        $user_id = Auth::guard('user')->user()->id;
        $msg_list = User_message_conversation::where('last_to_id',$user_id)->where('is_read',0)->get();
        $not_read_messages_count = 0;
        if(count($msg_list) > 0){
          foreach($msg_list as $key => $val){
            $user = User::where('id',$val['last_from_id'])->first();
            if( $user && $user->is_deleted == 0){
              $not_read_messages_count = $not_read_messages_count + 1;
            }
          }
        }
       
				// $not_read_messages_count = User_message_conversation::where('last_to_id',$user_id)->where('is_read',0)->count();
          $settings->with('not_read_messages_count', $not_read_messages_count);
          
          // // Remind email per hour
          // $CheckUnreceived_list = User_message_conversation::where('last_from_id',$user_id)->where('is_read',0)->whereNotNull('sent_remind_date')->whereRaw("sent_remind_date <=  date('Y-m-d H:i:s')")->get();
          // if(count($CheckUnreceived_list) > 0){

          //     foreach($CheckUnreceived_list as $key => $value){
        
          //       $msg_con = User_message_conversation::find($value['id']);
          //       $msg_con->sent_remind_date = null;
          //       $msg_con->save(); 
          //       echo 123;
          //     }
          // }       
          // // Remind email   
          // $unreceived_list = User_message_conversation::where('last_from_id',$user_id)->where('is_read',0)->whereNull('sent_remind_date')->get();

          // if(count($unreceived_list) > 0){
          //   config(['yourconfig.reminderEmail' => 1]);
          // }

        }
		});
    }
}
