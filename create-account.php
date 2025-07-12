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
        
    <title>Create Account</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
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

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Yangon');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("connection.php");





if($_POST){

    $result= $database->query("select * from webuser");

    $fname=$_SESSION['personal']['fname'];
    $lname=$_SESSION['personal']['lname'];
    $name=$fname." ".$lname;
    $address=$_SESSION['personal']['address'];
    $nic=$_SESSION['personal']['nic'];
    $dob=$_SESSION['personal']['dob'];
    $email=$_POST['newemail'];
    $tele=$_POST['tele'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];
    
    if ($newpassword==$cpassword){
        $sqlmain= "select * from webuser where email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows==1){
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        }else{
            //TODO
            $database->query("insert into patient(pemail,pname,ppassword, paddress, pnic,pdob,ptel) values('$email','$name','$newpassword','$address','$nic','$dob','$tele');");
            $database->query("insert into webuser values('$email','p')");

            //print_r("insert into patient values($pid,'$email','$fname','$lname','$newpassword','$address','$nic','$dob','$tele');");
            $_SESSION["user"]=$email;
            $_SESSION["usertype"]="p";
            $_SESSION["username"]=$fname;

            header('Location: patient/index.php');
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
        
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>';
    }



    
}else{
    //header('location: signup.php');
    $error='<label for="promter" class="form-label"></label>';
}

?>


    <center>
    <div class="container">
        <table border="0" style="width: 80%;">
            <img src="img/favicon.png" alt="Icon"
                                style="width:35px; height:35px; vertical-align: middle; margin-right: 8px;">
            <tr>
                <td colspan="3">
                    <p class="header-text">ဆက်လက် ဖြည့်စွက်ပါ။</p>
                    <p class="sub-text">လူကြီးမင်း၏ အချက်လက်များကို မြန်မာ/English နှစ်သက်ရာဖြင့် ဖြည့်စွက်ပါ။</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="3">
                    <label for="newemail" class="form-label">Email/အီးမေလ်း: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <input type="email" name="newemail" class="input-text" placeholder="Email/အီးမေလ်း ထည့်ပါ။" required>
                </td>
                
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <label for="tele" class="form-label">Phone/ဖုန်းနံပါတ်: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <input type="tel" name="tele" class="input-text"  maxlength="11" placeholder="ဥပမာ- 09********" pattern="[0]{1}[0-9]{9}" >
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <label for="newpassword" class="form-label">Password/လျို့ဝှက်နံပါတ်: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <input type="password" name="newpassword" class="input-text" placeholder="လျို့ဝှက်နံပါတ်ထည့်ပါ။" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <label for="cpassword" class="form-label">Confirm Password/လျို့ဝှက်နံပါတ်အတည်ပြုပါ: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="3">
                    <input type="password" name="cpassword" class="input-text" placeholder="လျို့ဝှက်နံပါတ်အတည်ပြုပါ။" required>
                </td>
            </tr>
     
            <tr>
                
                <td colspan="3">
                    <?php echo $error ?>

                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="button" onclick="window.history.back();" value="Back" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>

            </tr>
            <tr>
                <td colspan="3">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">လူကြီးမင်းသည် Account ရှိပြီးသားဖြစ်လျှင် &#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">ဒီမှာ Login ဝင်ပါ။</a><br>
                    <a href="index.html" class="active hover-link1 non-style-link"><မူလ စာမျက်နှာသို့></a><br>
                </td>
            </tr>

                    </form>
            </tr>
        </table>

    </div>
</center>

</body>
</html>