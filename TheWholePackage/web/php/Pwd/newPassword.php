<?php include_once "../Classes/PwdReset.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../../js/validate.js"></script>
    <link rel="icon" href="../../assets/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../../css/passwordReset.css">
    <title> Password Recovery </title>
</head>
<body>
<div class="wrapper">
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div id="pass-container" class="container">
        <?php
        if(empty($_GET['selector']) || empty($_GET['validator'])){
            echo "<label style=\"color:white;font-size:20px;display:block; padding:15px 0 15px 0;background-color: #35475A; margin-top: -50px; height: 550px\">Your request could not be validated. Please try again</label>";
        }else{
            if(ctype_xdigit($_GET['selector']) !== false && ctype_xdigit($_GET['validator']) !== false) {
        ?>
        <form name="form" method="post">
            <h1>Enter New Password</h1>
            <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,}" title="Follow the requirements" placeholder="New Password" id="password" name="password" onkeyup='check()' required>
            <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,}" title="Follwo the requirements" placeholder="Confirm New Password" id="confirm_password" name="confirm_password" onkeyup='check()' required><br>
            <div class="pass-req-container" id="pass-req-container">
                <h4>Password Criteria:</h4>
                <ul>
                    <li id="length" class="invalid">Must have at least 9 characters</li>
                    <li id="letter" class="invalid">Must have at least one Lowercase letter</li>
                    <li id="capital" class="invalid">Must have at least one Uppercase letter</li>
                    <li id="number" class="invalid">Must have at least one number</li>
                    <li id="match" class="invalid">Passwords must match</li>
                </ul>
            </div>
            <button type="submit" name="pass-submit">Reset My Password</button>
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
                }
            }
            if(isset($_POST['pass-submit'])) {
                $rs = PwdReset::passwordObjectHandler($_GET['selector'], $_GET['validator'], $_POST['password']);
                if ($rs == true) {
                    header("Location: ../../index?passreset=success");
                } elseif ($rs == false) {
                    echo "<label style=\"color:white;font-size:20px;display:block; padding:15px 0 15px 0;background-color: #35475A; margin-top: -50px; height: 550px\">Your request could not be validated. Please try again</label>";
                }
            }
            ?>
    </div>
</div>
</body>
</html>