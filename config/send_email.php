<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendEmail($to, $name, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // CHANGE THESE
        $mail->Username = 'your-email@gmail.com';
$mail->Password = 'YOUR_APP_PASSWORD_HERE';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Sofa Customizer');

        $mail->addAddress($to, $name);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;

    }
}