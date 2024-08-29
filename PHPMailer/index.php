<?php
require "PHPMailer/src/PHPMailer.php";  
require "PHPMailer/src/SMTP.php"; 
require 'PHPMailer/src/Exception.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function sendMail($title, $content, $addressMail) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
            $mail->isSMTP();
            $mail->CharSet = "utf-8";
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true; 
            $mail->Username = 'vantran181295@gmail.com'; // Sửa lỗi ở đây
            $mail->Password = 'dnnowkfpnclxexjy'; // Sửa lỗi ở đây
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // encryption TLS/SSL 
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('vantran181295@gmail.com', 'NKstore');
            $mail->addAddress($addressMail); // Mail và tên người nhận  

            // Content
            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = $content;

            $mail->send();
            return true; // Trả về true nếu email được gửi thành công

        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
