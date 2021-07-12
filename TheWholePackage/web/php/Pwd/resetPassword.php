<?php include_once "../Classes/PwdReset.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../../css/passwordReset.css">
    <link rel="icon" href="../../assets/favicon.ico">
    <title> Password Reset </title>
</head>
<body>
<div class="wrapper">
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div class="container">
        <form method="post">
            <h1>Password Reset</h1>
            <h4>Please Enter your email address and we will send you an email with a link to reset your password</h4>
            <input type="email" placeholder="Email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must be a valid email address" required>
            <button id="submit" name="submit-request">Recovery My Password</button>
            <a id="back-to-front" href="../../index">Cancel</a>
        </form>
            <!--
            The script below will prevent resubmission
            when the window is reloaded or F5 is pressed
            -->
            <script>
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>
            <?php
            if(isset($_POST["submit-request"])){
                $result = PwdReset::verifyEmail($_POST['email']);
                if($result){
                    PwdReset::resetObjectHandler($_POST['email']);
                }
                else{
                    echo "<label style=\"color:white;font-size:12px;display:block; padding:15px 0 15px 0;background-color: green; margin-top: 10px\">If that email address is associated with an account, an email has been sent to it with a link to reset the password.</label>";
                }
            }
            if(isset($_GET['link']))
            {
                if($_GET['link'] == 'sent'){
                    echo "<label style=\"color:white;font-size:12px;display:block; padding:15px 0 15px 0;background-color: green; margin-top: 10px\">If that email address is associated with an account, an email has been sent to it with a link to reset the password.</label>";
                }
            }
            ?>
    </div>
</div>
</body>
</html>
