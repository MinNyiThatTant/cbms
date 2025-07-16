<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/index.css">
        
    <title>Sign Up</title>

    <style>
        body, html {
            height: 100%; 
            margin: 10px; 
        }
        .container {
            width: 100%; 
            margin: 5px;
            max-width: 800px; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 10px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>
<body>
<?php
session_start(); // Start the session

// Unset all the server-side variables
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Asia/Yangon');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

if ($_POST) {
    // Store personal information in session
    $_SESSION["personal"] = array(
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'address' => $_POST['address'],
        'nic' => $_POST['nic'],
        'dob' => $_POST['dob']
    );

    // Debugging output (optional)
    // print_r($_SESSION["personal"]);

    // Redirect to the next step (create-account.php or login.php)
    header("Location: create-account.php"); // Change this to login.php if needed
    exit(); // Ensure no further code is executed
}
?>

<center>
    <div class="container">
        <table border="0" style="width: 70%;">
            <img src="img/favicon.png" alt="Icon" style="width:35px; height:35px; vertical-align: middle; margin-right: 8px;">
            <tr>
                <td colspan="2">
                    <p class="header-text">ဤနေရာတွင် Account ပြုလုပ်နိုင်သည်။</p>
                    <p class="sub-text">လူကြီးမင်း၏ အချက်လက်များကို မြန်မာ/English နှစ်သက်ရာဖြင့် ဖြည့်စွက်ပါ။</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST">
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">အမည်: </label>
                    </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="fname" class="input-text" placeholder="လူကြီးမင်း၏နာမည်ထည့်ပါ။" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="address" class="form-label">နေရပ်လိပ်စာ: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="address" class="input-text" placeholder="ဥပမာ- (၁)လမ်း၊ (၃)ရပ်ကွက်၊ တောင်ငူမြို့။" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="nic" class="form-label">မှတ်ပုံတင်နံပါတ်: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="nic" class="input-text" placeholder="ဥပမာ- (၁၀)/တငန(နိုင်)*******" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">မွေးသက္ကရာဇ်: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="dob" class="input-text" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">လူကြီးမင်းသည် Account ရှိပြီးသားဖြစ်လျှင် &#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">ဒီမှာ Login ဝင်ပါ။</a><br>
                    <a href="index.html" class="active hover-link1 non-style-link"><မူလ စာမျက်နှာသို့></a>
                </td>
            </tr>
                </form>
            </tr>
        </table>
    </div>
</center>

</body>
</html>
