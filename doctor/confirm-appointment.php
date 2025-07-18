<?php
session_start();
include("../connection.php");

if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email'])) {
    $appoid = $_GET['id'];
    $patientName = $_GET['name'];
    $patientEmail = $_GET['email'];

    // Update the appointment status in the database
    $sql = "UPDATE appointment SET status='confirmed' WHERE appoid='$appoid'";
    if ($database->query($sql) === TRUE) {
        // Send email notification
        $subject = "Appointment Confirmation";
        $message = "Dear $patientName,\n\nYour appointment has been confirmed.\n\nThank you!";
        $headers = "From: mingalarnsp@gmail.com";

        if (mail($patientEmail, $subject, $message, $headers)) {
            // Redirect back to appointment page with success message
            header("Location: appointment.php?message=Appointment confirmed and email sent.");
        } else {
            // Redirect back with error message
            header("Location: appointment.php?error=Email could not be sent.");
        }
    } else {
        // Redirect back with error message
        header("Location: appointment.php?error=Could not confirm appointment.");
    }
} else {
    header("Location: appointment.php");
}
?>
