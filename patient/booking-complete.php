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

// Initialize statements
$stmt = null;
$stmtCheck = null;
$stmtInsert = null;

try {
    // Fetch user details
    $sqlmain = "SELECT * FROM patient WHERE pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];

    // Initialize alert message
    $alertMessage = '';

    // Check if the form was submitted
    if ($_POST) {
        // Get the schedule ID from the form submission
        $scheduleid = $_POST['scheduleid'];

        // Check the maximum number of patients allowed for this session
        $sqlMaxPatients = "SELECT nop FROM schedule WHERE scheduleid = ?";
        $stmtMax = $database->prepare($sqlMaxPatients);
        $stmtMax->bind_param("i", $scheduleid);
        $stmtMax->execute();
        $resultMax = $stmtMax->get_result();
        $maxPatients = $resultMax->fetch_assoc()['nop'];

        // Check how many patients have already booked this session
        $sqlCheckBooking = "SELECT COUNT(*) as currentBookings FROM appointment WHERE scheduleid = ?";
        $stmtCheck = $database->prepare($sqlCheckBooking);
        $stmtCheck->bind_param("i", $scheduleid);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $currentBookings = $resultCheck->fetch_assoc()['currentBookings'];

        // Check if the maximum number of bookings has been reached
        if ($currentBookings >= $maxPatients) {
            $alertMessage = '
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-3" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div>
                        <strong>Warning!</strong> This session is fully booked. You cannot make a booking.
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        } else {
            // Check if the patient has already booked this session
            $sqlCheckPatientBooking = "SELECT * FROM appointment WHERE pid = ? AND scheduleid = ?";
            $stmtCheckPatient = $database->prepare($sqlCheckPatientBooking);
            $stmtCheckPatient->bind_param("ii", $userid, $scheduleid);
            $stmtCheckPatient->execute();
            $resultCheckPatient = $stmtCheckPatient->get_result();

            if ($resultCheckPatient->num_rows > 0) {
                // Patient has already booked this appointment
                $alertMessage = '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-3" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        <div>
                            <strong>Warning!</strong> You have already booked this appointment for the selected time.
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
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
                        header("Location: appointment.php?action=booking-added&id=" . $apponum . "&titleget=none");
                        exit();
                    } else {
                        // Handle error
                        $alertMessage = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill mr-3" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                                <div>
                                    <strong>Error!</strong> There was a problem booking your appointment. Please try again.
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    $alertMessage = '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . htmlspecialchars($e->getMessage()) . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
} finally {
    // Close statements if they exist
    if ($stmt) $stmt->close();
    if ($stmtMax) $stmtMax->close();
    if ($stmtCheck) $stmtCheck->close();
    if ($stmtInsert) $stmtInsert->close();
    $database->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Complete</title>
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-image: url('../img/bg-big.jpg'); 
            background-size: cover; 
            /* background-position: center;  */
            background-repeat: no-repeat; 
        }
        .alert {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert svg {
            flex-shrink: 0;
            font-size: 1.5rem;
        }
        .card {
            max-width: 400px; 
            margin: auto; 
            margin-top: 100px; 
        }
    </style>
</head>

<body>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0" style="text-align: center;">Appointment Status</h4>
        </div>
        <div class="card-body">
            <div class="mt-4">
                <?php if ($currentBookings >= $maxPatients): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-3" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                            <div>
                                <strong>Warning! </strong> This session is fully booked. You cannot make a booking at this time. Please check for other available sessions.<br><br><br>
                                သတိပေးချက်။ လူပြည့်သွားပါပြီ၊ ဤအချိန်တွင် Appointment မရနိုင်ပါ။ အခြားသောအချိန်များကို စစ်ဆေးကြည့်ပါ။ 
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php elseif ($resultCheckPatient->num_rows > 0): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-3" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg>
                            <div>
                                <strong>Warning!</strong> You have already booked this appointment for the selected time. Please check your appointment details. <br><br><b></b>
                                သင်သည် ဤအချိန်အတွက် Appointment ရယူပြီးသားဖြစ်ပါသည်။ သင်၏ချိန်းဆိုမှု အချက်အလက်များကို စစ်ဆေးကြည့်ပါ။
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill mr-3" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 15a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm-.93-4.412a.5.5 0 0 1 .93 0l.001.001v.001l-.001.001a.5.5 0 0 1-.93 0v-.001l-.001-.001v-.001l.001-.001zm.93-8.588a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1 0-1h.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                            <div>
                                <strong>Info! </strong> You can proceed to book your appointment. Please fill in the required details. 
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <a href="schedule.php" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left me-2"></i>Go Back
                </a>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>