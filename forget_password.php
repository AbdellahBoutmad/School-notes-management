<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hasnaadouwabi05@gmail.com'; // Your SMTP username
    $mail->Password   = 'zfls tjhq wrwm osyo'; // Your SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS also accepted
    $mail->Port       = 587; // TCP port to connect to                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    // Recipients
    $mail->setFrom('boutabd6@gmail.com', 'Sender Name');
    $mail->addAddress('hasnaadouwabi05@gmail.com', 'Recipient Name');  // Add a recipient

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Test Email';
    $mail->Body    = 'hi yo can rest paaword using code 342738.';

    $mail->send();
    echo "<script>alert('Email has been sent')</script>";
    header('Location: login_stg.php');
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
