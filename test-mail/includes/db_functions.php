<?php
function getBookingDetails($booking_id) {
    // Replace with your actual DB connection
    $conn = new mysqli('localhost:3307', 'root', '', 'cbms_db');
    
    $query = $conn->prepare("SELECT b.*, p.name as patient_name, p.email, d.name as doctor_name 
                            FROM bookings b
                            JOIN patients p ON b.patient_id = p.id
                            JOIN doctors d ON b.doctor_id = d.id
                            WHERE b.id = ?");
    $query->bind_param("i", $booking_id);
    $query->execute();
    $result = $query->get_result();
    
    return $result->fetch_assoc();
}

function getAllPatientEmails($booking_id) {
    // Replace with your actual DB connection
    $conn = new mysqli('localhost:3307', 'root', '', 'cbms_db');
    
    $query = $conn->prepare("SELECT p.email FROM bookings b
                            JOIN patients p ON b.patient_id = p.id
                            WHERE b.id = ?");
    $query->bind_param("i", $booking_id);
    $query->execute();
    $result = $query->get_result();
    
    $emails = [];
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
    }
    
    return $emails;
}
?>
