<!DOCTYPE html>
<html lang="en">
<!-- [Previous head section remains the same] -->
<body>

<?php
session_start();
include("connection.php");

// function hashAdminPasswords($database) {
//     $admins = $database->query("SELECT aid, apassword FROM admin");
//     while ($admin = $admins->fetch_assoc()) {
//         if (!password_verify($admin['apassword'], $admin['apassword'])) { // Check if already hashed
//             $hashedPassword = password_hash($admin['apassword'], PASSWORD_DEFAULT);
//             $database->query("UPDATE admin SET apassword='$hashedPassword' WHERE aid='{$admin['aid']}'");
//         }
//     }
// }

// Uncomment this line ONLY ONCE to hash existing admin passwords:
// hashAdminPasswords($database);

if ($_POST) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
    
    if ($result->num_rows == 1) {
        $utype = $result->fetch_assoc()['usertype'];
        
        if ($utype == 'a') {
            $admin = $database->query("SELECT * FROM admin WHERE aemail='$email'")->fetch_assoc();
            if ($admin && password_verify($password, $admin['apassword'])) {
                $_SESSION['user'] = $email;
                $_SESSION['usertype'] = 'a';
                header('location: admin/index.php');
                exit();
            } else {
                $error = "<label class='form-label error'>Invalid admin credentials</label>";
            }
        }
        // [Rest of your login logic for other user 
    }
}
?>


<?php
// Include your database connection
include("connection.php");

function hashAdminPasswords($database) {
    // Fetch all admin records
    $admins = $database->query("SELECT aemail, apassword FROM admin");
    
    while ($admin = $admins->fetch_assoc()) {
        // Check if the password is already hashed
        if (!password_verify($admin['apassword'], $admin['apassword'])) {
            // Hash the password
            $hashedPassword = password_hash($admin['apassword'], PASSWORD_DEFAULT);
            // Update the password in the database
            $database->query("UPDATE admin SET apassword='$hashedPassword' WHERE aemail='{$admin['aemail']}'");
            echo "Updated password for: " . $admin['aemail'] . "<br>";
        }
    }
}

// Call the function to hash passwords
hashAdminPasswords($database);
?>


//login
if ($utype == 'a') {
    $admin = $database->query("SELECT * FROM admin WHERE aemail='$email'")->fetch_assoc();
    if ($admin && password_verify($password, $admin['apassword'])) {
        $_SESSION['user'] = $email;
        $_SESSION['usertype'] = 'a';
        header('location: admin/index.php');
        exit();
    } else {
        $error = "<label class='form-label error'>Invalid admin credentials</label>";
    }
}


</body>
</html>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/index.css">

    <title>Login</title>

    <style>
        body, html {
            height: 90%; 
            margin: 10px; 
        }
        .container {
            width: 100%; 
            margin: 50px;
            max-width: 700px; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 5px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>

<body>

    <?php
    // Import database connection
    include("connection.php");

    function hashAdminPasswords($database) {
        // Fetch all admin records
        $admins = $database->query("SELECT aemail, apassword FROM admin");
        
        while ($admin = $admins->fetch_assoc()) {
            // Check if the password is already hashed
            if (!password_verify($admin['apassword'], $admin['apassword'])) {
                // Hash the password
                $hashedPassword = password_hash($admin['apassword'], PASSWORD_DEFAULT);
                // Update the password in the database
                $database->query("UPDATE admin SET apassword='$hashedPassword' WHERE aemail='{$admin['aemail']}'");
                echo "Updated password for: " . $admin['aemail'] . "<br>";
            }
        }
    }

    // Uncomment this line ONLY ONCE to hash existing admin passwords:
    // hashAdminPasswords($database);

    session_start();
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    // Set the new timezone
    date_default_timezone_set('Asia/Yangon');
    $date = date('Y-m-d');
    $_SESSION["date"] = $date;

    if ($_POST) {
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];

        // Check if the email exists
        $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
        if ($result->num_rows == 1) {
            $utype = $result->fetch_assoc()['usertype'];
            if ($utype == 'p') {
                // Check if the patient exists
                $checker = $database->query("SELECT * FROM patient WHERE pemail='$email'");
                if ($checker->num_rows == 1) {
                    $patientData = $checker->fetch_assoc();
                    
                    // Verify password
                    if (password_verify($password, $patientData['ppassword'])) { // Use 'ppassword' to match the hashed password
                        // Store patient ID in session
                        $_SESSION['patient_id'] = $patientData['pid']; // Assuming 'pid' is the patient ID
                        $_SESSION['usertype'] = 'p';
                        $_SESSION['user'] = $email;

                        // Redirect to the questionnaire page
                        header('location: patient/question.php'); // Redirect to the questionnaire page
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == 'a') {
                // Admin login
                $checker = $database->query("SELECT * FROM admin WHERE aemail='$email'");
                if ($checker->num_rows == 1) {
                    $adminData = $checker->fetch_assoc();
                    if (password_verify($password, $adminData['apassword'])) { // Use 'apassword' to match the hashed password
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'a';
                        header('location: admin/index.php');
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == 'd') {
                // Doctor login
                $checker = $database->query("SELECT * FROM doctor WHERE docemail='$email'");
                if ($checker->num_rows == 1) {
                    $doctorData = $checker->fetch_assoc();
                    if (password_verify($password, $doctorData['docpassword'])) { // Use 'docpassword' to match the hashed password
                        $_SESSION['user'] = $email;
                        $_SESSION['usertype'] = 'd';
                        header('location: doctor/index.php');
                        exit();
                    } else {
                        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                    }
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            }
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We can\'t find any account for this email.</label>';
        }
    } else {
        $error = '<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>

    <center>
        <div class="container" style="justify-content: center;">
            <table border="0" style="margin: 0;padding: 0;width: 80%;">
                <img src="img/favicon.png" alt="Icon" style="width:35px; height:35px; vertical-align: middle; margin-right: 8px;">
                <tr>
                    <td colspan="2">
                        <p class="header-text">CBMS မှကြိုဆိုပါ၏</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td colspan="2">
                            <p class="sub-text">မြန်မာ / English ကြိုက်နှစ်သက်ရာဖြင့် ဖြည့်စွက်ပါ။</p>
                        </td>
                    </tr>
                    <tr>
                        <form action="" method="POST">
                            <td class="label-td" colspan="2">
                                <label for="useremail" class="form-label">Email/အီးမေလ်း: </label>
                            </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="email" name="useremail" class="input-text" placeholder="လူကြီးမင်း၏ Email ထည့်ပါ။" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="userpassword" class="form-label">Password/လျို့ဝှက်နံပါတ်: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="password" name="userpassword" class="input-text" placeholder="Password/လျိ့ဝှက်နံပါတ်" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br>
                            <?php if (isset($error)) echo $error; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Login" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                </div>
                <tr>
                    <td colspan="2">
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">လူကြီးမင်းသည် Account မပြုလုပ်ထားလျှင် &#63; </label>
                        <a href="signup.php" class="active hover-link1 non-style-link">ဒီမှာ Sign Up ပြုလုပ်ပါ။</a><br>
                        <a href="index.html" class="active hover-link1 non-style-link"><မူလ စာမျက်နှာသို့></a>
                        <br><br><br>
                    </td>
                </tr>
                </form>
            </table>
        </div>
    </center>
    
</body>
</html>
