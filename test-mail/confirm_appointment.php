<?php
require_once 'includes/db_functions.php';

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$booking = getBookingDetails($booking_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Appointment</title>
    <script>
    function confirmBooking(bookingId) {
        if(confirm('Are you sure you want to confirm this appointment?')) {
            fetch('confirm_booking.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'booking_id=' + bookingId
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert(data.message);
                    document.getElementById('booking-status').innerHTML = 
                        'Confirmed' + (data.email_sent ? ' (Email Sent)' : ' (Email Failed)');
                    document.getElementById('confirm-btn').disabled = true;
                } else {
                    alert('Error: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    </script>
</head>
<body>
    <h1>Appointment Details</h1>
    <?php if($booking): ?>
        <p><strong>Patient:</strong> <?= htmlspecialchars($booking['patient_name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($booking['appointment_date']) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($booking['appointment_time']) ?></p>
        <p><strong>Status:</strong> <span id="booking-status"><?= htmlspecialchars($booking['status']) ?></span></p>
        
        <button id="confirm-btn" 
                onclick="confirmBooking(<?= $booking['id'] ?>)" 
                <?= ($booking['status'] === 'confirmed') ? 'disabled' : '' ?>>
            Confirm Appointment
        </button>
    <?php else: ?>
        <p>Appointment not found.</p>
    <?php endif; ?>
</body>
</html>
