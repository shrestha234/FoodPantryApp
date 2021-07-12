<?php include_once "php/Classes/Database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="js/validate.js"></script>
    <link rel="icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="css/styles.css">
    <title> PCC Food Pantry | Sign in | Sign up </title>
</head>
<body>
    <div class="wrapper">
        <div class="logo-container">
            <a href="https://www.pcc.edu/"><img src="assets/logo.png" alt="Portland Community College"></a>
        </div>
        <div class="sign-in-container">
            <form  method="post">
                <h4 id="sign-in-h4">Sign In</h4>
                    <input type="text" placeholder="Username" id="username" name="username" title="Username" required>
                    <input type="password" placeholder="Password" id="password" name="password" title="Password" required>
                <button type="submit" name="Sign_In_Submit" id="sign-in-button">Sign in</button>
            </form>
            <div class="do-not-have-account-container">
                <a class="switch-container" href="signUp">Sign Up</i></a>
                <a class="forgot" href="php/Pwd/resetPassword">Forgot Password?</a>
            </div>
            <?php
            if(isset($_GET['passreset'])){
                if(strcmp($_GET['passreset'], "success") == 0){
                    echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: green; margin-top: 85px\">Your password has been reset successfully</label>";
                }
            }
            if(isset($_POST['Sign_In_Submit'])){
                $results = Database::signIn(strtolower($_POST['username']), $_POST['password']);
                if($results){
                    if(strcasecmp($results["Username"], $_POST['username']) == 0 && password_verify($_POST['password'], $results["Password"])){
                        Database::sessionStarter($results);
                        if (strcmp($_SESSION['role'], "Subscriber") == 0) {
                            header("Location: php/Landing/subscriber");
                        } elseif (strcmp($_SESSION['role'], "Staff") == 0) {
                            header("Location: php/Landing/staff");
                        } elseif (strcmp($_SESSION['role'], "Manager") == 0) {
                            header("Location: php/Landing/manager");
                        }
                    }
                }
                echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 190px\">Username or password is incorrect</label>";
            }
            ?>
        </div>
        <!--
        The script below will prevent resubmission
        when the window is reloaded or F5 is pressed
        -->
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        <script>
            $(function() {
                $('#username').on('keypress', function(e) {
                    if (e.which === 32){
                        return false;
                    }
                });
            });
        </script>
    </div>
</body>
</html>
