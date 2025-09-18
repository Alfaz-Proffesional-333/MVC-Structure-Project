<?php
require 'vendor/autoload.php'; // Composer Autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

function sendEmail($recipientEmail, $subject, $messageText) {
    try{
        $mailConfig = require __DIR__ . '/../config/Mail.php';
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = $mailConfig['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailConfig['username'];
        $mail->Password   = $mailConfig['password'];
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $mailConfig['port'];

        $mail->setFrom($mailConfig['from'], $mailConfig['from_name']);
        $mail->addAddress($recipientEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($messageText));

        // Debugging
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP Debug: $str");
        };

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("mail error: " . $e->getMessage());
        include __DIR__ . '/../views/errors/500.php';
    }
}