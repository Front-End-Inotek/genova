<?php

$to = "dave_u@outlook.com";
$subject = "Subject ";
$message = "Hello there";

$headers = 'From: dave_ultra@outlook.com' . "\r\n" .
    'Reply-To: dave_ultra@outlook.com' . "\r\n" .
    'X-Mailer: PHP/' .phpversion();

$mail_sent = mail($to, $subject, $message , $headers);

if($mail_sent) {
    echo 'These email has been sent successfully';
    
} else {
    echo 'These was an error sending the email.';
}

?>
