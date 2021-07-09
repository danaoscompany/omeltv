<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

class Util extends CI_Controller {
	
	public static function generateUUIDv4() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0x0fff ) | 0x4000,
	        mt_rand( 0, 0x3fff ) | 0x8000,
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}
	
	public static function send_email($email, $subject, $body) {
		$mail = new PHPMailer(true);
		try {
    		//Server settings
    		$mail->SMTPDebug = 2;                      //Enable verbose debug output
    		$mail->isSMTP();                                            //Send using SMTP
    		$mail->Host       = 'mail.danaos.xyz';                     //Set the SMTP server to send through
    		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    		$mail->Username   = 'admin@danaos.xyz';                     //SMTP username
    		$mail->Password   = 'HaloDunia123';                               //SMTP password
    		$mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = 			PHPMailer::ENCRYPTION_STARTTLS`
    		//Recipients
    		$mail->setFrom('admin@danaos.xyz', 'Sender');
    		$mail->addAddress($email, 'Recepient');     //Add a recipient
    		$mail->addReplyTo('admin@danaos.xyz', 'Sender');
		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;
		    $mail->send();
    		echo 'Message has been sent';
		} catch (Exception $e) {
    		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	
	public static function send_email_2($email, $subject, $body) {
		$to = $email;
		$headers = "From: admin@omeltv.com\r\n";
		$headers .= "Reply-To: admin@omeltv.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$message = $body;
		mail($to, $subject, $message, $headers);
	}
}
