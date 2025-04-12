<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$config = include('mailerconfig.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


function sendCode($email,$code){
    global $mail;
    global $config;
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $config['mail_uname'];                     //SMTP username
    $mail->Password   = $config['mail_pwd'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($config['mail_uname'], 'MyCollegeConnect');
    $mail->addAddress($email);           
 
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verify your Email';
    $mail->Body    = 'Your Verification Code is : <b>'.$code.'</b>';
    $mail->send();
   
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
?>
  
