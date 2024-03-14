<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Save email to subscribers.txt
    $file = 'subscribers.txt';
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND);

    // Email the owner
    $to = "deepak@vinayaksolution.com"; // Replace with your email address
    $subject = "New Newsletter Subscription";
    $message = "A new user subscribed to your newsletter.\nEmail: $email";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_gmail_address@gmail.com'; // Your Gmail address
        $mail->Password   = 'your_gmail_password'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('your_gmail_address@gmail.com', 'Your Website'); // Your Gmail address
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo "Thank you for subscribing!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
