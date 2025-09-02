<?php
require 'vendor/autoload.php'; // Composer Autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($recipientEmail, $subject, $messageText) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'akfreelancer786@gmail.com';
        $mail->Password = 'gmfb hlfh edim ghxd'; // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('akfreelancer786@gmail.com', 'AlfazKhokhar');
        $mail->addAddress($recipientEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($messageText));

        $mail->send();
        return true;
    } catch (Exception $e) {
        //return false;
        error_log("Email error: " . $mail->ErrorInfo);
    }
}
