<?php
include_once "../Classes/Database.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../../assets/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../../css/landing.css">
    <title> Template </title>
</head>
<body>
<div class="wrapper">
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div class="template-container">
        <form method="post">
            <h1>Create a Template</h1>
            <input title="Name" name="name" type=text id="name" placeholder="Template name" class="name" required>

            <input title="Subject" name="subject" type=text id="subject" placeholder="Template subject" class="subject" required>

            <textarea title="Template body" id="template" name="template" placeholder="Template body..." style="height:200px" required></textarea>
            <button type="submit" name="save" id="save">Create</button>
        </form>
        <a href="../Landing/manager"><button id="save">Go Back</button></a>
        <?php
        if(isset($_POST['save']))
        {
            $template = Database::createTemplate($_SESSION['userid'], $_POST['name'], $_POST['subject'], $_POST['template']);
            if($template){
                echo "<label style=\"width: 100%; height: 35px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: green; margin: 75px auto; text-align: center;\">Template created successfully</label>";
            }
            else{
                echo "<label style=\"width: 100%; height: 35px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 75px auto; text-align: center;\">Something went wrong, try again</label>";
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
</div>
</body>
</html>