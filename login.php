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
    session_start();
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";

    // Set the new timezone
    date_default_timezone_set('Asia/Yangon');
    $date = date('Y-m-d');
    $_SESSION["date"] = $date;

    // Import database connection
    include("connection.php");

    if ($_POST) {
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];

        // $error = '<label for="promter" class="form-label"></label>';

        $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
        if ($result->num_rows == 1) {
            $utype = $result->fetch_assoc()['usertype'];
            if ($utype == 'p') {
                // Check if the patient exists
                $checker = $database->query("SELECT * FROM patient WHERE pemail='$email' AND ppassword='$password'");
                if ($checker->num_rows == 1) {
                    $patientData = $checker->fetch_assoc();
                    
                    // Store patient ID in session
                    $_SESSION['patient_id'] = $patientData['pid']; // Assuming 'pid' is the patient ID
                    $_SESSION['usertype'] = 'p';
                    $_SESSION['user'] = $email;
                    
                    // DEBUG: Check what's being stored in session
                    echo "<pre>AFTER LOGIN - SESSION DATA:\n"; 
                    print_r($_SESSION); 
                    echo "</pre>";
                    // exit(); // Temporary - remove after debugging

                    // Redirect to the questionnaire page
                    header('location: patient/question.php'); // Redirect to the questionnaire page
                    exit();
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == 'a') {
                // Admin login
                $checker = $database->query("SELECT * FROM admin WHERE aemail='$email' AND apassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('location: admin/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == 'd') {
                // Doctor login
                $checker = $database->query("SELECT * FROM doctor WHERE docemail='$email' AND docpassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('location: doctor/index.php');
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
                            <?php echo $error ?>
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
