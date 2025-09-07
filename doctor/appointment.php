<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Appointments</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'd') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    // Import database
    include("../connection.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $userrow = $database->query("SELECT * FROM doctor WHERE docemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["docid"];
    $username = $userfetch["docname"];
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username, 0, 13); ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">မူလစာမျက်နှာ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">ကျွနိုပ်၏ Appointments</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">ကျွနိုပ်၏ Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">ကျွနိုပ်၏ လူနာများ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="appointment.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Appointment Manager</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">ယနေ့ ရက်စွဲ</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Yangon');
                            $today = date('Y-m-d');
                            echo $today;
                            $list110 = $database->query("SELECT * FROM schedule INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid INNER JOIN patient ON patient.pid=appointment.pid INNER JOIN doctor ON schedule.docid=doctor.docid WHERE doctor.docid=$userid");
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">ကျွန်ုပ်၏ Appointments (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <td width="10%"></td> 
                                    <td width="5%" style="text-align: center;">Date:</td>
                                    <td width="30%">
                                        <form action="" method="post">
                                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                    </td>
                                    <td width="12%">
                                        <input type="submit" name="filter" value=" Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin:0;width:100%">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                
                <?php
                $sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, 
                patient.pname, patient.pemail, schedule.scheduledate, schedule.scheduletime, 
                appointment.apponum, appointment.appodate, appointment.status 
                FROM schedule 
                INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
                INNER JOIN patient ON patient.pid=appointment.pid 
                INNER JOIN doctor ON schedule.docid=doctor.docid 
                WHERE doctor.docid=$userid";

                if ($_POST) {
                    if (!empty($_POST["sheduledate"])) {
                        $sheduledate = $_POST["sheduledate"];
                        $sqlmain .= " AND schedule.scheduledate='$sheduledate'";
                    }
                }
                ?>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                            <tr>
                                <th class="table-headin">Patient name</th>
                                <th class="table-headin">Appointment number</th>
                                <th class="table-headin">Session Title</th>
                                <th class="table-headin">Session Date & Time</th>
                                <th class="table-headin">Appointment Date</th>
                                <th class="table-headin">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $database->query($sqlmain);

                            if ($result->num_rows == 0) {
                                echo '<tr>
                                    <td colspan="6">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Appointment မရှိသေးပါ။!</p>
                                    <a class="non-style-link" href="appointment.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</button></a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                            } else {
                                while ($row = $result->fetch_assoc()) {
                                    $appoid = $row["appoid"];
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $docname = $row["docname"];
                                    $scheduledate = $row["scheduledate"];
                                    $scheduletime = $row["scheduletime"];
                                    $pname = $row["pname"];
                                    $email = $row["pemail"];
                                    $apponum = $row["apponum"];
                                    $appodate = $row["appodate"];
                                    $status = $row["status"];

                                    echo '<tr>
                                        <td style="font-weight:600;">&nbsp;' . substr($pname, 0, 25) . '</td>
                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">' . $apponum . '</td>
                                        <td>' . substr($title, 0, 15) . '</td>
                                        <td style="text-align:center;">' . substr($scheduledate, 0, 10) . ' @' . substr($scheduletime, 0, 5) . '</td>
                                        <td style="text-align:center;">' . $appodate . '</td>
                                        <td>
                <div style="display:flex;justify-content: center;">';

                                    if ($status === 'confirmed') {
                                        echo '<button class="btn-primary-soft btn button-icon btn-confirm" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;" disabled>
                                                <font class="tn-in-text">Confirmed</font>
                                              </button>';
                                    } else {
                                        echo '<a href="?action=confirm&id=' . $appoid . '&name=' . $pname . '&email=' . $email . '" class="non-style-link">
                                                <button class="btn-primary-soft btn button-icon btn-confirm" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                    <font class="tn-in-text">Confirm</font>
                                                </button>
                                              </a>';
                                    }

                                    echo '&nbsp;&nbsp;&nbsp;
                                        <a href="?action=drop&id=' . $appoid . '&name=' . $pname . '&session=' . $title . '&apponum=' . $apponum . '" class="non-style-link">
                                            <button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                <font class="tn-in-text">Cancel</font>
                                            </button>
                                        </a>
                                        </div>
                                    </td>
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
            </table>
        </div>
    </div>
    <?php
    // Handle actions
    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        
        if ($action == 'confirm') {
            // Fetch appointment details
            $appointmentQuery = $database->query("SELECT * FROM appointment 
                INNER JOIN patient ON appointment.pid = patient.pid 
                INNER JOIN schedule ON appointment.scheduleid = schedule.scheduleid
                WHERE appoid = $id");
            $appointment = $appointmentQuery->fetch_assoc();
            
            if ($appointment) {
                // Update appointment status
                $database->query("UPDATE appointment SET status='confirmed' WHERE appoid=$id");
                
                // Send email to patient using Gmail SMTP
                $mail = new PHPMailer(true);
                try {
                    // Server settings for Gmail
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'email'; // Your Gmail address
                    $mail->Password = 'yourpassword'; // Your Gmail app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
                    $mail->Port = 465; // TCP port to connect to
                    
                    // Set email content in both English and Burmese
                    $patientName = $appointment['pname'];
                    $appointmentDate = date('F j, Y', strtotime($appointment['scheduledate']));
                    $appointmentTime = date('h:i A', strtotime($appointment['scheduletime']));
                    $doctorName = $username;
                    $appointmentNumber = $appointment['apponum'];
                    
                    // Recipients
                    $mail->setFrom('royalmntt@gmail.com', 'Clinic Appointment System');
                    $mail->addAddress($appointment['pemail'], $patientName);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Appointment Confirmation';
                    
                    // Email body with both English and Burmese
                    $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; }
                            .header { color: #2c3e50; font-size: 24px; margin-bottom: 20px; }
                            .content { margin-bottom: 30px; }
                            .footer { margin-top: 30px; font-size: 14px; color: #7f8c8d; }
                            .burmese { font-family: 'Myanmar3', 'Padauk', sans-serif; }
                        </style>
                    </head>
                    <body>
                        <div class='header'>Appointment Confirmation</div>
                        
                        <div class='content'>
                            <p>Dear $patientName,</p>
                            <p>Your appointment has been confirmed with Dr. $doctorName.</p>
                            <p><strong>Appointment Details:</strong></p>
                            <ul>
                                <li>Date: $appointmentDate</li>
                                <li>Time: $appointmentTime</li>
                                <li>Appointment Number: $appointmentNumber</li>
                            </ul>
                        </div>
                        
                        <div class='content burmese'>
                            <p>မင်္ဂလာပါ $patientName </p>
                            <p>သင့်ရဲ့ ချိန်းဆိုမှုကို Dr. $doctorName နှင့် အတည်ပြုပြီးဖြစ်ပါသည်။</p>
                            <p><strong>ချိန်းဆိုမှုအချက်အလက်:</strong></p>
                            <ul>
                                <li>ရက်စွဲ: $appointmentDate</li>
                                <li>အချိန်: $appointmentTime</li>
                                <li>ချိန်းဆိုမှုနံပါတ်: $appointmentNumber</li>
                            </ul>
                        </div>
                        
                        <div class='footer'>
                            <p>Thank you for choosing our clinic. Please arrive 15 minutes before your scheduled time.</p>
                            <p class='burmese'>ကျွန်ုပ်တို့ဆေးခန်းကို ရွေးချယ်တဲ့အတွက် ကျေးဇူးတင်ပါတယ်။ ချိန်းဆိုထားသောအချိန်မတိုင်မီ ၁၅ မိနစ်စော၍ ရောက်ရှိပါရန်။</p>
                        </div>
                    </body>
                    </html>
                    ";
                    
                    // Plain text version for non-HTML email clients
                    $mail->AltBody = "Dear $patientName,\n\nYour appointment with Dr. $doctorName has been confirmed for $appointmentDate at $appointmentTime.\n\nAppointment Number: $appointmentNumber\n\nThank you!";
                    
                    $mail->send();
                    
                    // Show success message
                    echo '
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <center>
                                <h2>Success!</h2>
                                <a class="close" href="appointment.php">&times;</a>
                                <div class="content">
                                    Appointment confirmed and notification email sent to patient.
                                </div>
                                <div style="display: flex;justify-content: center;">
                                    <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;OK&nbsp;</font></button></a>
                                </div>
                            </center>
                        </div>
                    </div>';
                    
                } catch (Exception $e) {
                    echo '
                    <div id="popup1" class="overlay">
                        <div class="popup">
                            <center>
                                <h2>Error!</h2>
                                <a class="close" href="appointment.php">&times;</a>
                                <div class="content">
                                    Appointment was confirmed but email could not be sent.<br>
                                    Error: ' . $mail->ErrorInfo . '
                                </div>
                                <div style="display: flex;justify-content: center;">
                                    <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;OK&nbsp;</font></button></a>
                                </div>
                            </center>
                        </div>
                    </div>';
                }
            }
        } elseif ($action == 'drop') {
            $nameget = $_GET["name"];
            $session = $_GET["session"];
            $apponum = $_GET["apponum"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to cancel this appointment<br><br>
                            Patient Name: &nbsp;<b>' . substr($nameget, 0, 40) . '</b><br>
                            Appointment number &nbsp; : <b>' . substr($apponum, 0, 40) . '</b><br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-appointment.php?id=' . $id . '" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
                </div>
            </div>';
        }
    }
    ?>
</body>
</html>
