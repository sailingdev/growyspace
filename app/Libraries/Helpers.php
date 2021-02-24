<?php

use PHPMailer\PHPMailer\PHPMailer; 
use Illuminate\Support\Facades\Mail;

class Helpers
{
	
    public static function mail_attachment($to, $subject, $body, $from, $file=false,$filename=false) {
	
		$from_name = "Auto-Turbo";
		if($file) {
			$file_size = filesize($file);
			$content_type = mime_content_type($file);
			$handle = fopen($file, "r");
			$content = fread($handle, $file_size);
			fclose($handle);
			$content = chunk_split(base64_encode($content));
		}
		
		$uid = md5(uniqid(time()));
		$eol = PHP_EOL;

		// Basic headers
		$header = "From: ".$from_name." <".$from.">".$eol;
		//$header .= "Reply-To: ".$replyto.$eol;
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
		
		if($file) {
			$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";
		}
		
		// Put everything else in $message
		$message = "--".$uid.$eol;
		$message .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
		
		if($file) {
			$message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		}
		
		$message .= $body.$eol;
		$message .= "--".$uid.$eol;
		
		if($file) {
			$message .= "Content-Type: ".$content_type."; name=\"".$filename."\"".$eol;
			$message .= "Content-Transfer-Encoding: base64".$eol;
			$message .= "Content-Disposition: attachment; filename=\"".$filename."\"".$eol;
			$message .= $content.$eol;
		}
		
		$message .= "--".$uid."--";

		if (@mail($to, $subject, $message, $header))
		{
			return "mail_success";
		}
		else
		{
			return "mail_error";
		}
	}
	
	public static function send_mail_html($to, $subject, $body, $from) {
	
		$eol = PHP_EOL;
		$from_name = "Growyspace";
		// Basic headers
		$headers = "From: ".$from_name." <".$from.">".$eol;
		//$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($to) . "\r\n";
		$headers .= "Organization: Growyspace\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		//$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
				
		if (@mail($to, $subject, $body, $headers))
		{
			return "mail_success";
		}
		else
		{
			return "mail_error";
		}
	}
	public static function base64url_encode($data) { 
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

	public static function base64url_decode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 
	
	public static function send_ses_email($data) {
			
		Mail::send([], [], function ($message) use ($data) {
			$from = isset($data['from']) ? $data['from'] : 'no_reply@growyspace.com';
			$to = $data['to'];
			$subject = $data['subject'];
			$body = $data['body'];
			$file_path = isset($data['file_path']) ? $data['file_path'] : false;
			//$mime = mime_content_type($file_path);
			$file_name = isset($data['file_name']) ? $data['file_name'] : false;
		    $message->to($to)
				->subject($subject)
				->from($from, 'Growyspace')
				->setBody($body, 'text/html');
			
			if ($file_path && is_file($file_path)) {
				if($file_name) {
					$message->attach($file_path,['as' => $file_name]);
				} else {
					$message->attach($file_path);
				}
			}
		});
		
		return true;
		
		/*	
		$mail = new PHPMailer;

		// Tell PHPMailer to use SMTP
		$mail->isSMTP();

		// Replace sender@example.com with your "From" address. 
		// This address must be verified with Amazon SES.
		$mail->setFrom($from, 'Companions');

		// Replace recipient@example.com with a "To" address. If your account 
		// is still in the sandbox, this address must be verified.
		// Also note that you can include several addAddress() lines to send
		// email to multiple recipients.
		$mail->addAddress($to, 'Recipient Name');

		// Replace smtp_username with your Amazon SES SMTP user name.
		$mail->Username = 'AKIAJCGCEI5LAWKZDK4Q';

		// Replace smtp_password with your Amazon SES SMTP password.
		$mail->Password = 'As+lCirTSs5ugNCtBNnidPeilNR/VLgfcqzPeCl6urBd';
			
		// Specify a configuration set. If you do not want to use a configuration
		// set, comment or remove the next line.
		//$mail->addCustomHeader('X-SES-CONFIGURATION-SET', 'ConfigSet');
		 
		// If you're using Amazon SES in a region other than US West (Oregon), 
		// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
		// endpoint in the appropriate region.
		$mail->Host = 'email-smtp.us-east-1.amazonaws.com';

		// The subject line of the email
		$mail->Subject = $subject;

		// The HTML-formatted body of the email
		$mail->Body = $body;

		// Tells PHPMailer to use SMTP authentication
		$mail->SMTPAuth = true;

		// Enable TLS encryption over port 587
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		//Attachments
		if ($file_path && is_file($file_path)) {
			if($file_name) {
				$mail->addAttachment($file_path, $file_name);    // Optional name
			} else {
				$mail->addAttachment($file_path);         // Add attachments
			}
		}
				
		// Tells PHPMailer to send HTML-formatted email
		$mail->isHTML(true);

		// The alternative email body; this is only displayed when a recipient
		// opens the email in a non-HTML email client. The \r\n represents a 
		// line break.
		$mail->AltBody = $body;

		if(!$mail->send()) {
			//echo "Email not sent. " , $mail->ErrorInfo , PHP_EOL;
			return false;
		} else {
			return true;
			//echo "Email sent!" , PHP_EOL;
		}*/
	}
}
?>