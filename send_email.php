<?php
// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email
function sendConfirmationEmail($patientEmail) {
    $mail = new PHPMailer(true);
    
    try {
        // Mailtrap SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Mailtrap SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR_MAILTRAP_USERNAME'; // Your Mailtrap username
        $mail->Password = 'YOUR_MAILTRAP_PASSWORD'; // Your Mailtrap password
        $mail->Port = 2525; // Mailtrap port

        // Email Content
        $mail->setFrom('clinic@example.com', 'Your Clinic'); // Sender's email and name
        $mail->addAddress($patientEmail); // Recipient's email
        $mail->Subject = 'Appointment Confirmed'; // Email subject
        $mail->Body = 'Dear Patient, your appointment is booked.'; // Email body

        // Send Email
        if ($mail->send()) {
            return "Email sent!";
        } else {
            return "Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
