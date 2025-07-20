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
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
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
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Appointments (<?php echo $list110->num_rows; ?>)</p>
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
                                <th class="table-headin">Events</th>
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
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn\'t find anything related to your keywords!</p>
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
                                    $status = $row["status"]; // Get the status of the appointment

                                    echo '<tr>
                                        <td style="font-weight:600;">&nbsp;' . substr($pname, 0, 25) . '</td>
                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">' . $apponum . '</td>
                                        <td>' . substr($title, 0, 15) . '</td>
                                        <td style="text-align:center;">' . substr($scheduledate, 0, 10) . ' @' . substr($scheduletime, 0, 5) . '</td>
                                        <td style="text-align:center;">' . $appodate . '</td>
                                        <td>
                <div style="display:flex;justify-content: center;">';

                                    // Check if the appointment is already confirmed
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
            $appointmentQuery = $database->query("SELECT * FROM appointment INNER JOIN patient ON appointment.pid = patient.pid WHERE appoid = $id");
            $appointment = $appointmentQuery->fetch_assoc();
            
            if ($appointment) {
                // Update appointment status
                $database->query("UPDATE appointment SET status='confirmed' WHERE appoid=$id");
                
                // Send email to patient
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.mailtrap.io'; // Set the SMTP server to send through
                    $mail->SMTPAuth = true;
                    $mail->Username = '0568168822fc5f'; // SMTP username
                    $mail->Password = '828df875c824d4'; // SMTP password
                    $mail->SMTPSecure = 'tls';   //PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 2525;

                    //Recipients
                    $mail->setFrom('from@example.com', 'CBMS');
                    $mail->addAddress($appointment['pemail'], $appointment['pname']); // Add a recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Appointment Confirmation';
                    $mail->Body    = 'Dear ' . $appointment['pname'] . ',<br>Your appointment has been confirmed for ' . $appointment['appodate'] . '.<br>Thank you!';
                    $mail->AltBody = 'Dear ' . $appointment['pname'] . ', Your appointment has been confirmed for ' . $appointment['appodate'] . '. Thank you!';

                    $mail->send();
                    echo 'Email has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
                            You want to delete this record<br><br>
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
    </div>
</body>
</html>
