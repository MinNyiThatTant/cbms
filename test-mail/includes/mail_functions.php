<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendTestEmail($toEmails) {
    $mail = new PHPMailer(true);
    $results = [];

    try {
        // Mailtrap SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '0568168822fc5f'; // Your Mailtrap username
        $mail->Password = '828df875c824d4'; // Your Mailtrap password
        $mail->Port = 2525; // Mailtrap port
        $mail->SMTPSecure = 'tls';

        // Email Content
        $mail->setFrom('from@example.com', 'Magic Elves'); // Sender's email and name
        $mail->isHTML(true); // Set email format to HTML

        // Subject
        $mail->Subject = 'You are awesome!';

        // Body content
        $mail->Body = '
            <html>
            <head>
                <meta charset="UTF-8">
            </head>
            <body style="font-family: sans-serif;">
                <div style="display: block; margin: auto; max-width: 600px;" class="main">
                    <h1 style="font-size: 18px; font-weight: bold; margin-top: 20px">Congrats for sending test email with Mailtrap!</h1>
                    <p>If you are viewing this email in your sandbox – the integration works.</p>
                    <img alt="Inspect with Tabs" src="https://assets-examples.mailtrap.io/integration-examples/welcome.png" style="width: 100%;">
                    <p>Now send your email using our SMTP server and integration of your choice!</p>
                    <p>Good luck! Hope it works.</p>
                </div>
                <style>
                    .main { background-color: white; }
                    a:hover { border-left-width: 1em; min-height: 2em; }
                </style>
            </body>
            </html>
        ';

        // Plain text alternative
        $mail->AltBody = "Congrats for sending test email with Mailtrap!\n\nIf you are viewing this email in your sandbox – the integration works.\nNow send your email using our SMTP server and integration of your choice!\n\nGood luck! Hope it works.";

        // Loop through each email and send
        foreach ($toEmails as $toEmail) {
            $mail->addAddress($toEmail); // Add recipient email

            // Send the email
            if ($mail->send()) {
                $results[] = "Email sent successfully to $toEmail!<br>";
            } else {
                $results[] = "Email could not be sent to $toEmail. Mailer Error: " . $mail->ErrorInfo . "<br>";
            }

            // Clear all addresses for the next iteration
            $mail->clearAddresses();
        }

        return implode('', $results); // Return all results as a single string
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
    }
}
?>
