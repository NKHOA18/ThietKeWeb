<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 align="center">trang đăng kí
    </h1>   
<form " method="post" align="center">
        <label for="name">Họ tên:</label>
        <input type="text" name="name" id="name" required> <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required> <br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required> <br><br>

        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>
<script>require 'vendor/autoload.php';</script>
<?php   
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\phpMyAdmin\vendor\autoload.php';

$mail = new PHPMailer(true);
    
// Create a new PHPMailer instance
try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bqttmt@gmail.com';
    $mail->Password = 'quangtien2k2';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and recipient settings
    $mail->setFrom('bqttmt@gmail.com', 'BQT');
    $mail->addAddress('tien2002tmt@mgial.com', 'Recipient Name');
    $mail->addReplyTo('bqttmt@gmail.com', 'BQT');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = '<h1>This is a test email</h1>';
    $mail->AltBody = 'This is the text-only version of the email';

    // Send email
    $mail->send();
    echo 'hello nha';
} catch (Exception $e) {
    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
}

    
// xử lý các giá trị được nhập vào form ở đây
?>