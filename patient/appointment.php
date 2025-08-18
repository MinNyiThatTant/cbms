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
    // Start the session at the very beginning to ensure session variables are available
    session_start();

    // Check if user is logged in properly - moved this check to only redirect if directly accessing the file
    if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'p') {
        // Store requested URL before redirecting to login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("location: ../login.php");
        exit();
    } 
    
    // If logged in, get user details
    $useremail = $_SESSION["user"];
    
    // Import database connection
    include("../connection.php");
    
    // Prepare SQL to get patient details
    $sqlmain = "SELECT * FROM patient WHERE pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];

    // Base SQL query to get appointments
    $sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, 
                patient.pname, schedule.scheduledate, schedule.scheduletime, 
                appointment.apponum, appointment.appodate, appointment.status 
                FROM schedule 
                INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
                INNER JOIN patient ON patient.pid=appointment.pid 
                INNER JOIN doctor ON schedule.docid=doctor.docid 
                WHERE patient.pid=$userid";

    // Add date filter if submitted via POST
    if ($_POST && !empty($_POST["sheduledate"])) {
        $sheduledate = $_POST["sheduledate"];
        $sqlmain .= " AND schedule.scheduledate='$sheduledate'";
    }

    // Order by appointment date and execute query
    $sqlmain .= " ORDER BY appointment.appodate ASC";
    $result = $database->query($sqlmain);
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
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">မူလစာမျက်နှာ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">ဆရာဝန်များ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">ဆေးခန်းအချိန်များ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">ကျွနိုပ်၏ Bookings</p></div></a>
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
            <table border="0" width="100%" style="border-spacing: 0;margin: 0;padding: 0;margin-top: 25px;">
                <tr>
                    <td width="13%">
                        <a href="appointment.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Bookings history</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">ယနေ့ ရက်စွဲ</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Yangon');
                            echo date('Y-m-d');
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings (<?php echo $result->num_rows; ?>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <tbody>
                                        <?php
                                        if ($result->num_rows == 0) {
                                            echo '<tr>
                                                <td colspan="7">
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
                                                $apponum = $row["apponum"];
                                                $appodate = $row["appodate"];
                                                $status = $row["status"];

                                                // URL encode parameters for the cancel link
                                                $cancel_link = htmlspecialchars("?action=drop&id=$appoid&title=".urlencode($title)."&doc=".urlencode($docname));
                                                
                                                echo '<tr>
                                                    <td style="width: 25%;">
                                                        <div class="dashboard-items search-items">
                                                            <div style="width:100%;">
                                                                <div class="h3-search">
                                                                    Booking ရက်စွဲ :  ' . substr($appodate, 0, 30) . '<br>
                                                                    Reference Number: CBMS-' . $appoid . '
                                                                </div>
                                                                <div class="h1-search">
                                                                    ' . substr($title, 0, 21) . '<br>
                                                                </div>
                                                                <div class="h3-search">
                                                                    Appointment Number/ တိုကင်နံပါတ် : <h2>0' . $apponum . '</h2>
                                                                </div>
                                                                <div class="h3-search">
                                                                    ဆရာဝန် အမည် ' . substr($docname, 0, 30) . '
                                                                </div><br>
                                                                <div class="h4-search">
                                                                    Scheduled Date/: ' . $scheduledate . '<br>Starts Time/စတင်ကုသချိန်: <b>@' . substr($scheduletime, 0, 5) . '</b> (24h)
                                                                </div>
                                                                <br>';
                                                
                                                // Show different button based on appointment status
                                                if ($status === 'confirmed') {
                                                    echo '<button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%" disabled>
                                                            <font class="tn-in-text">အတည်ပြုပြီးပါပြီ။ သင်၏ email ကိုစစ်ဆေးပါ။</font>
                                                          </button>';
                                                } else {
                                                    echo '<a href="' . $cancel_link . '">
                                                            <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%">
                                                                <font class="tn-in-text">Cancel Booking</font>
                                                            </button>
                                                          </a>';
                                                }

                                                echo '</div>
                                                        </div>
                                                    </td>';
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
    // Handle GET actions (like canceling appointments)
    if ($_GET && isset($_SESSION["user"])) {
        $id = $_GET["id"] ?? null;
        $action = $_GET["action"] ?? null;
        
        if ($action == 'booking-added' && $id) {
            // Show success message for new booking
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Booking Successfully.</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Your Appointment number is ' . htmlspecialchars($id) . '.<br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                            <br><br><br><br>
                        </div>
                    </center>
                </div>
            </div>';
        } 
        elseif ($action == 'drop' && $id) {
            // Show confirmation for canceling appointment
            $title = $_GET["title"] ?? '';
            $docname = $_GET["doc"] ?? '';
            
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to Cancel this Appointment?<br><br>
                            Session Name: &nbsp;<b>' . htmlspecialchars(substr($title, 0, 40)) . '</b><br>
                            Doctor name&nbsp; : <b>' . htmlspecialchars(substr($docname, 0, 40)) . '</b><br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                            <a href="delete-appointment.php?id=' . htmlspecialchars($id) . '" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
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
