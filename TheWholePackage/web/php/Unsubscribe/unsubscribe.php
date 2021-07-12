<?php include_once("../Classes/Database.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../../css/unsubscribe.css">
    <link rel="icon" href="../../assets/favicon.ico">
    <title> Unsubscribe </title>
</head>
<body>
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div id="unsubscribe-container" class="container">
        <form method="post">
            <h4>Provide your username in order to unsubscribe</h4>
            <input title="Username" name="username" type=text id="username" class="username" placeholder="Username">
            <button type="submit" id="unsubscribe-button" name="unsubscribe-button">Unsubscribe</button>
            <button type="submit" name="cancel" id="unsubscribe-cancel">Go Back</button>
        </form>
        <?php
        if(isset($_POST['cancel'])){
            if (strcmp($_SESSION['role'], "Subscriber") == 0) {
                header("Location: ../Landing/subscriber");
            } elseif (strcmp($_SESSION['role'], "Staff") == 0) {
                header("Location: ../Landing/staff");
            } elseif (strcmp($_SESSION['role'], "Manager") == 0) {
                header("Location: ../Landing/manager");
            }
        }
        if(isset($_POST['unsubscribe-button'])){
            if(empty($_POST['username'])){
                echo "<label style=\"width: 100%; height: 35px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 5px auto; text-align: center;\">Field cannot be empty</label>";
            }
            elseif(strcasecmp($_SESSION['username'], $_POST['username']) == 0){
                $delete = Database::deleteAccount($_POST['username']);
                if($delete) {
                    header("Location: unsubscribeSuccess");
                }
                else{
                    echo "<label style=\"width: 100%; height: 35px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: green; margin: 5px auto; text-align: center;\">Something went wrong. Try again</label>";
                }
            }else{
                echo "<label style=\"width: 100%; height: 35px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 5px auto; text-align: center;\">Username is incorrect</label>";
            }
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
</body>
</html>
