<?php
/**
 * Created by PhpStorm.
 * User: A188656
 * Date: 2017/03/30
 * Time: 09:13 AM
 */

/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require_once (__DIR__.'/PHPMailerAutoload.php');//'../PHPMailerAutoload.php';

//convert it into a mail function

function TemplMail($SubjDef,$MsgDef)
{
//Create a new PHPMailer instance
    $mail = new PHPMailer();
//Tell PHPMailer to use SMTP
    $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
//Set the hostname of the mail server
    $mail->Host = "hostname";
//Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 25;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "username";
//Password to use for SMTP authentication
    $mail->Password = "password";
//Set who the message is to be sent from
    $mail->setFrom('sender-address');
//Set an alternative reply-to address
    //$mail->addReplyTo('');
//Set who the message is to be sent to
//improv array to hold many recepients
    $AddReps = array('default group recepient address');
//iterate array
    foreach ($AddReps as $NewAdd) {
        $mail->addAddress($NewAdd);
    }
    $AddCC = array('default group receipients');
//iterate array
    foreach ($AddCC as $NewAddC) {
        $mail->addCC($NewAddC);
    }
   // $mail->addCC('George.Wanjohi@standardbank.co.za','NgochochE@stanbic.com','OyendoG@stanbic.com');
//Set the subject line
	//$mail->addBCC("");
    $mail->Subject = $SubjDef;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
    $mail->Body = $MsgDef;


//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $RetStat = "Message sent!";
        return $RetStat;
    }
}

?>