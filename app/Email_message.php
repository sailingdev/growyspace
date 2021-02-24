<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Email_message extends Model
{
    protected $table = 'email_messages';
	
	public function send_external_email($to, $subject,$message) {
		$email_api_url = 'http://spacelab.gitak.am/api/send_email_for_external_server';
		
		$post_fields = http_build_query([
			'to' => $to,
			'subject' => $subject,
			'message' => $message,
			'secret' => 'welcome2050$'
		]);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$email_api_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close ($ch);
		// Further proces
	}
}
