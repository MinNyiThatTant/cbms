<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Doctors</title>
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
        if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'p') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    // Import database
    include("../connection.php");
    $userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["pid"];
    $username = $userfetch["pname"];
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
                                    <p class="profile-title"><?php echo substr($username, 0, 13) ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22) ?></p>
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
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">မူလစာမျက်နှာ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">ဆရာဝန်များ</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">ဆေးခန်းအချိန်များ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">ကျွန်ုပ်၏ Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="doctors.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px; padding-bottom:11px; margin-left:20px; width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="‌ဒေါက်တာအမည်/email/ကျွမ်းကျင်မှု ဖြင့်ရှာဖွေနိုင်ပါသည်။" list="doctors">&nbsp;&nbsp;

                            <?php
                            echo '<datalist id="doctors">';
                            $list11 = $database->query("SELECT docname, docemail FROM doctor;");
                            $list12 = $database->query("SELECT * FROM specialties;");

                            // Populate doctor names and emails
                            while ($row00 = $list11->fetch_assoc()) {
                                $d = $row00["docname"];
                                $c = $row00["docemail"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            }

                            // Populate specialties
                            while ($row00 = $list12->fetch_assoc()) {
                                $sname = $row00["sname"];
                                echo "<option value='$sname'><br/>";
                            }

                            echo '</datalist>';
                            ?>

                            <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0; text-align: right;">
                            ယနေ့ ရက်စွဲ 
                        </p>
                        <p class="heading-sub12" style="padding: 0; margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Yangon');
                            $date = date('Y-m-d');
                            echo $date;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex; justify-content: center; align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)">All Doctors (<?php echo $list11->num_rows; ?>)</p>
                    </td>
                </tr>

                <?php
                if ($_POST) {
                    $keyword = $_POST["search"];
                    $sqlmain = "SELECT doctor.*, specialties.sname 
                                FROM doctor 
                                LEFT JOIN specialties ON doctor.specialties = specialties.id 
                                WHERE docemail='$keyword' 
                                OR docname='$keyword' 
                                OR docname LIKE '$keyword%' 
                                OR docname LIKE '%$keyword' 
                                OR docname LIKE '%$keyword%' 
                                OR specialties.sname = '$keyword' 
                                OR specialties.sname LIKE '$keyword%' 
                                OR specialties.sname LIKE '%$keyword'";
                } else {
                    $sqlmain = "SELECT doctor.*, specialties.sname 
                                FROM doctor 
                                LEFT JOIN specialties ON doctor.specialties = specialties.id 
                                ORDER BY docid DESC";
                }
                ?>

                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Doctor Name/ ဒေါက်တာအမည်</th>
                                            <th class="table-headin">Email/ အီးမေးလ်</th>
                                            <th class="table-headin">Specialties/ကျွမ်းကျင်မှု</th>
                                            <th class="table-headin">Action / လုပ်ဆောင်ချက်များ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $database->query($sqlmain);

                                        if ($result->num_rows == 0) {
                                            echo '<tr>
                                                <td colspan="4">
                                                <br><br><br><br>
                                                <center>
                                                <img src="../img/notfound.svg" width="25%">
                                                <br>
                                                <p class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)">We couldn\'t find anything related to your keywords!</p>
                                                <a class="non-style-link" href="doctors.php"><button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left:20px;">&nbsp; Show all Doctors &nbsp;</button></a>
                                                </center>
                                                <br><br><br><br>
                                                </td>
                                            </tr>';
                                        } else {
                                            while ($row = $result->fetch_assoc()) {
                                                $docid = $row["docid"];
                                                $name = $row["docname"];
                                                $email = $row["docemail"];
                                                $spe = $row["specialties"];
                                                $spcil_name = $row["sname"] ?? "N/A"; // Default to "N/A" if no specialty

                                                echo '<tr>
                                                    <td>&nbsp;' . substr($name, 0, 30) . '</td>
                                                    <td>' . substr($email, 0, 20) . '</td>
                                                    <td>' . substr($spcil_name, 0, 20) . '</td>
                                                    <td>
                                                        <div style="display:flex; justify-content: center;">
                                                            <a href="?action=view&id=' . $docid . '" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a href="?action=session&id=' . $docid . '&name=' . $name . '" class="non-style-link"><button class="btn-primary-soft btn button-icon menu-icon-session-active" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;"><font class="tn-in-text">Sessions</font></button></a>
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
    // Handle actions for viewing, deleting, and session redirection
    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        if ($action == 'drop') {
            $nameget = $_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                        </div>
                        <div style="display: flex; justify-content: center;">
                            <a href="delete-doctor.php?id=' . $id . '" class="non-style-link"><button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin:10px; padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="doctors.php" class="non-style-link"><button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin:10px; padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
                </div>
            </div>
            ';
        } elseif ($action == 'view') {
            $sqlmain = "SELECT * FROM doctor WHERE docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $name = $row["docname"];
            $email = $row["docemail"];
            $spe = $row["specialties"];
            
            $stmt = $database->prepare("SELECT sname FROM specialties WHERE id=?");
            $stmt->bind_param("s", $spe);
            $stmt->execute();
            $spcil_res = $stmt->get_result();
            $spcil_array = $spcil_res->fetch_assoc();
            $spcil_name = $spcil_array["sname"];
            $nic = $row['docnic'];
            $tele = $row['doctel'];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            CBMS Web App<br>
                        </div>
                        <div style="display: flex; justify-content: center;">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td>
                                        <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">View Details.</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Name: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $name . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Email: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $email . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">NIC: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $nic . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Telephone: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $tele . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Specialties: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        ' . $spcil_name . '<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="doctors.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn"></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </center>
                    <br><br>
                </div>
            </div>
            ';
        } elseif ($action == 'session') {
            $name = $_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>Redirect to Doctors sessions?</h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">
                            You want to view All sessions by <br>(' . substr($name, 0, 40) . ').
                        </div>
                        <form action="schedule.php" method="post" style="display: flex">
                            <input type="hidden" name="search" value="' . $name . '">
                            <div style="display: flex; justify-content:center; margin-left:45%; margin-top:6%; margin-bottom:6%;">
                                <input type="submit" value="Yes" class="btn-primary btn">
                            </div>
                        </form>
                    </center>
                </div>
            </div>
            ';
        }
    }
    ?>
</div>
</body>
</html>
