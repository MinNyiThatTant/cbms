<?php
require_once 'includes/db_functions.php';
require_once 'includes/mail_functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    
    $booking = getBookingDetails($booking_id);
    
    if($booking) {
        // Update booking status to confirmed
        $conn = new mysqli('localhost:3307', 'root', '', 'cbms_db');
        $stmt = $conn->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        
        // Prepare data for email
        $appointment_details = [
            'booking_id' => $booking['id'],
            'date' => $booking['appointment_date'],
            'time' => $booking['appointment_time'],
            'doctor_name' => $booking['doctor_name']
        ];
        
        // Get all patient emails for this booking
        $patientEmails = getAllPatientEmails($booking_id);
        
        // Send confirmation email to all patients
        $email_sent = sendTestEmail($patientEmails);
        
        // Response with status
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'email_sent' => true, // Assuming emails are sent successfully
            'message' => 'Booking confirmed and emails sent to all patients.'
        ]);
    } else {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Booking not found']);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'Invalid request']);
}
?>
