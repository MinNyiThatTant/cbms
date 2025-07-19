<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
        exit();
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
    exit();
}

// Import database
include("../connection.php");

// Get user ID from session
$userid = $_SESSION["userid"]; // Assuming you have stored user ID in session

// Check if the form was submitted
if ($_POST) {
    // Get the schedule ID from the form submission
    $scheduleid = $_POST['scheduleid'];

    // Check if the patient has already booked this session
    $sqlCheckBooking = "SELECT * FROM appointment WHERE pid = ? AND scheduleid = ?";
    $stmtCheck = $database->prepare($sqlCheckBooking);
    $stmtCheck->bind_param("ii", $userid, $scheduleid);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Patient has already booked this appointment
        echo '<div class="alert alert-warning">You have already booked this appointment. You cannot book again.</div>';
        exit(); // Stop further execution
    }

    // Fetch user details
    $sqlmain = "SELECT * FROM patient WHERE pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];

    // Proceed with booking
    if (isset($_POST["booknow"])) {
        $apponum = $_POST["apponum"];
        $date = $_POST["date"];

        // Prepare the insert statement
        $sqlInsert = "INSERT INTO appointment (pid, apponum, scheduleid, appodate) VALUES (?, ?, ?, ?)";
        $stmtInsert = $database->prepare($sqlInsert);
        $stmtInsert->bind_param("iiis", $userid, $apponum, $scheduleid, $date);

        // Execute the insert statement
        if ($stmtInsert->execute()) {
            // Redirect to appointment page with success message
            header("location: appointment.php?action=booking-added&id=" . $apponum . "&titleget=none");
            exit();
        } else {
            // Handle error
            echo '<div class="alert alert-danger">There was an error booking your appointment. Please try again.</div>';
        }
    }
}

// Close the prepared statements
$stmtCheck->close();
$stmt->close();
$stmtInsert->close();
$database->close();
?>
