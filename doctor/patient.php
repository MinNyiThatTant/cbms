<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Patients</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .patient-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .grid-item {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'd') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    // Import database
    include("../connection.php");
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
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">မူလစာမျက်နှာ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">ကျွန်ုပ်၏ Appointments</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">ကျွန်ုပ်၏ Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">ကျွန်ုပ်၏ လူနာများ</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        $selecttype = "My";
        $current = "My patients Only";
        if ($_POST) {
            if (isset($_POST["search"])) {
                $keyword = $_POST["search12"];
                $sqlmain = "SELECT * FROM patient WHERE pemail='$keyword' OR pname='$keyword' OR pname LIKE '$keyword%' OR pname LIKE '%$keyword' OR pname LIKE '%$keyword%'";
                $selecttype = "my";
            }

            if (isset($_POST["filter"])) {
                if ($_POST["showonly"] == 'all') {
                    $sqlmain = "SELECT * FROM patient";
                    $selecttype = "All";
                    $current = "All patients";
                } else {
                    $sqlmain = "SELECT * FROM appointment INNER JOIN patient ON patient.pid=appointment.pid INNER JOIN schedule ON schedule.scheduleid=appointment.scheduleid WHERE schedule.docid=$userid;";
                    $selecttype = "My";
                    $current = "My patients Only";
                }
            }
        } else {
            $sqlmain = "SELECT * FROM appointment INNER JOIN patient ON patient.pid=appointment.pid INNER JOIN schedule ON schedule.scheduleid=appointment.scheduleid WHERE schedule.docid=$userid;";
            $selecttype = "My";
        }
        ?>
        
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
                <tr>
                    <td width="13%">
                        <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top: 11px; padding-bottom: 11px; margin-left: 20px; width: 125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="လူနာအမည်/email ဖြင့် ရှာနိုင်ပါသည်။" list="patient">&nbsp;&nbsp;
                            <?php
                            echo '<datalist id="patient">';
                            $list11 = $database->query($sqlmain);
                            for ($y = 0; $y < $list11->num_rows; $y++) {
                                $row00 = $list11->fetch_assoc();
                                $d = $row00["pname"];
                                $c = $row00["pemail"];
                                echo "<option value='$d'><br/>";
                                echo "<option value='$c'><br/>";
                            }
                            echo '</datalist>';
                            ?>
                            <input type="submit" value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
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
                    <td colspan="4" style="padding-top: 10px;">
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49)"><?php echo $selecttype . " Patients (" . $list11->num_rows . ")"; ?></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 0px; width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <form action="" method="post">
                                    <tr>
                                        <td style="text-align: right;">
                                            Show Details About: &nbsp;
                                        </td>
                                        <td width="30%">
                                            <select name="showonly" id="" class="box filter-container-items" style="width: 90%; height: 37px; margin: 0;">
                                                <option value="" disabled selected hidden><?php echo $current ?></option>
                                                <option value="my">My Patients Only</option>
                                                <option value="all">All Patients</option>
                                            </select>
                                        </td>
                                        <td width="12%">
                                            <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0; width: 100%">
                                        </td>
                                    </tr>
                                </form>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
        <thead>
            <tr>
                <th class="table-headin">Name</th>
                <th class="table-headin">Contact</th>
                <th class="table-headin">Details</th>
                <th class="table-headin">Symptoms</th>
                <th class="table-headin">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $database->query($sqlmain);
            if($result->num_rows==0){
                echo '<tr><td colspan="5"><center><img src="../img/notfound.svg" width="25%"><p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No Patients Found</p></center></td></tr>';
            } else {
                for ($x=0; $x<$result->num_rows;$x++){
                    $row=$result->fetch_assoc();
                    $pid=$row["pid"];
                    echo '<tr>
                        <td>'.substr($row["pname"],0,35).'</td>
                        <td>
                            <div class="patient-contact">
                            <div><small>Tel: </small>'.$row["ptel"].'</div>
                                <div><small>Email: </small>'.substr($row["pemail"],0,20).'</div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-details">
                                <div><small>NIC: </small>'.$row["pnic"].'</div>
                                <div><small>DOB: </small>'.substr($row["pdob"],0,10).'</div>
                            </div>
                        </td>
                        <td>
                            <div class="patient-symptoms">
                                <div><small>Feeling: </small>'.substr($row["feeling"],0,15).'</div>
                                <div><small>Headache: </small>'.substr($row["headache"],0,10).'</div>
                            </div>
                        </td>
                        <td><a href="?action=view&id='.$pid.'" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view"><font class="tn-in-text">View</font></button></a></td>
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
    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];
        $sqlmain = "SELECT * FROM patient WHERE pid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["pname"];
        $email = $row["pemail"];
        $nic = $row["pnic"];
        $dob = $row["pdob"];
        $tele = $row["ptel"];
        $address = $row["paddress"];
        $feeling = $row["feeling"];
        $headache = $row["headache"];
        $fever = $row["fever"];
        $other_symptoms = $row["other_symptoms"];
                echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="patient.php">&times;</a>
                    <p style="padding: 0;margin: 0;font-size: 25px;font-weight: 500;">Patient Details</p><br><br><br>
                    <div class="patient-grid">
                        <!-- Column 1: Basic Info -->
                        <div class="grid-item">
                            <div class="label">Patient ID</div>
                            <div>P-'.$id.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Name</div>
                            <div>'.$name.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Date of Birth</div>
                            <div>'.$dob.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">NIC</div>
                            <div>'.$nic.'</div>
                        </div>
                        <!-- Column 2: Contact -->
                        <div class="grid-item">
                            <div class="label">Email</div>
                            <div>'.$email.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Telephone</div>
                            <div>'.$tele.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Address</div>
                            <div>'.$address.'</div>
                        </div>
                        
                        <!-- Column 3: Primary Symptoms -->
                        <div class="grid-item">
                            <div class="label">Feeling / ခံစားရသောဝေဒနာ</div>
                            <div>'.$feeling.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Headache / ခေါင်းကိုက်</div>
                            <div>'.$headache.'</div>
                        </div>
                        <!-- Column 4: Secondary Symptoms -->
                        <div class="grid-item">
                            <div class="label">Fever / ဖျားနေခြင်း</div>
                            <div>'.$fever.'</div>
                        </div>
                        <div class="grid-item">
                            <div class="label">Other Symptoms / အခြားဝေဒနာများ</div>
                            <div>'.$other_symptoms.'</div>
                        </div>
                    </div>
                    <a href="patient.php"><button class="login-btn btn-primary-soft btn" style="margin-top:20px">Close</button></a>
                </center>
            </div>
        </div>';
    }
    ?>



</div>
</body>
</html>
