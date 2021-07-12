<?php include_once("Classes/Database.php");
session_start();
if(isset($_POST['cancel'])){
    Database::redirect($_SESSION['role']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../assets/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../css/landing.css">
    <title> Contact Us </title>
</head>
<body>
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div id="contact-us-container" class="container">
        <form method="post">
            <h1>Contact Us</h1>
            <label for="firstname" id="firstname-label" class="firstname-label">First Name</label>
            <input name="firstname" type=text id="firstname" class="firstname" value="<?php echo $_SESSION['firstname']?>">

            <label for="lastname" id="lastname-label" class="lastname-label">Last Name</label>
            <input name="lastname" type=text id="lastname" class="lastname" value="<?php echo $_SESSION['lastname']?>">

            <label id="email-label" class="email-label">Email</label>
            <input title="Email" name="email" type=text id="email" class="email" value="<?php echo $_SESSION['email']?>">

            <label for="contact-us-message" id="contact-us-message-label" class="contact-us-message-label">Message</label>
            <textarea id="contact-us-message" name="message" placeholder="Message" style="height:200px"></textarea>
            <button type="submit" name="save-submit" id="save">Send</button>
            <br>
            <button id="cancel" name ="cancel">Go Back</button>
        </form>
    </div>
</body>
</html>