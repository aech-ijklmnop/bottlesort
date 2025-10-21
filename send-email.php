<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars(trim($_POST["name"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $inquiry_type = htmlspecialchars(trim($_POST["inquiry_type"]));
  $other_inquiry = htmlspecialchars(trim($_POST["other_inquiry"] ?? ''));
  $message = htmlspecialchars(trim($_POST["message"]));

  if ($inquiry_type === "Other" && !empty($other_inquiry)) {
    $inquiry_type = "Other: " . $other_inquiry;
  }

  $subject = "New Contact Form Submission from $name";
  $body = "Name: $name\nEmail: $email\nInquiry Type: $inquiry_type\n\nMessage:\n$message";

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bottlesort.team@gmail.com'; // your Gmail
    $mail->Password   = 'YOUR_APP_PASSWORD';         // your Gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('bottlesort.team@gmail.com', 'BottleSort Contact Form');
    $mail->addAddress('bottlesort.team@gmail.com');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();

    echo "<script>
      alert('Message sent successfully! Thank you for contacting us.');
      window.location.href='contact.php';
    </script>";
  } catch (Exception $e) {
    echo "<script>
      alert('Failed to send your message. Please try again later.');
      window.location.href='contact.php';
    </script>";
  }
}
?>
