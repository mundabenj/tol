<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail {
    public function Send_Mail($conf, $mailCnt) {
        //Load Composer's autoloader (created by composer, not included with PHPMailer)
        require 'Plugins/PHPMailer/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $conf['smtp_host'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $conf['smtp_user'];                     //SMTP username
    $mail->Password   = $conf['smtp_pass'];                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $conf['smtp_port'];                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom($mailCnt['mail_from'], $mailCnt['name_from']);
    $mail->addAddress($mailCnt['mail_to'], $mailCnt['name_to']);     //Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = $mailCnt['subject']; // Set the subject
    $mail->Body    = $mailCnt['body']; // Set the body
    $mail->AltBody = strip_tags($mailCnt['body']); // Set the plain text body

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    // Handle errors here
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    }
}
