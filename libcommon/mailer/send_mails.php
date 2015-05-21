<?php

// example on using PHPMailer with GMAIL 

include("../libcommon/mailer/class.phpmailer.php");
include("../libcommon/mailer/class.smtp.php");

$mail=new PHPMailer();


$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = $SMTPHost;      // sets GMAIL as the SMTP server
$mail->Port       = $SMTPPort;                   // set the SMTP port 

$mail->Username   = $mailID;  // GMAIL username
$mail->Password   = $mailpassword;            // GMAIL password

$mail->From       = $MailFromID;
$mail->FromName   = $MailFromName;
$mail->Subject    = $MailSubject;
$mail->Body       = $MailBody;                      //HTML Body
$mail->AltBody    = $MailBody; //Text Body

$mail->WordWrap   = 50; // set word wrap

$mail->AddAddress($mailToAddr,"First Last");
$mail->AddReplyTo($mailReplyTo,"SIMAT");
//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message has been sent";
}

?>
