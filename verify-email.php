<?php
$name= $_POST['name'];
$email= $_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

$mail= new PHPMailer(true);

function sendmail_verify($name,$email,$verify_token){
    mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;  

    $mail-> setFrom($email,$name);
    $mail-> addAddress("sakibur276@gmail.com", "sakib");

    $mail->Subject =$subject;
    $mail->Body= $message;

    $mail-> send();

}

?>