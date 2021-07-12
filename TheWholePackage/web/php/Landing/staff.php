<?php include_once("../Classes/Database.php");
//Keep the session going
session_start();
if(isset($_SESSION['userid']) == ""){
    header("Location: ../../index");
}
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
    <script src="../../js/jquery-3.4.1.min.js"></script>
    <title> My Preferences </title>
</head>
<body>
    <div class="wrapper">
        <div class="logo-container">
            <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
        </div>
        <div class="nav">
            <input type="checkbox" id="nav-check">
            <div class="nav-btn">
                <label for="nav-check">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
            <div class="nav-links">
                <div class="dropdown">
                    <button class="dropbtn" id="admin-menu">Admin Console
                        <div class="dropdown-content">
                            <a href="../Admin/createTtemplate">Template</a>
                            <a href="../notificationLog">Notification Log</a>
                        </div>
                    </button>
                </div>
                <a href="../editProfile" class="edit-button">Edit Profile</a>
                <a href="../contactUS">Contact Us</a>
                <a href="../Unsubscribe/unsubscribe">Delete Account</a>
                <a href="../logout">Logout</a>
            </div>
        </div>
        <div class="container">
            <h1>My Preferences</h1>
            <div class="firstname-div">
                <label id="firstname-label" class="firstname-label">First Name</label>
                <input title="First Name" type=text id="firstname" class="firstname" value="<?php echo $_SESSION['firstname']?>" disabled>
            </div>
            <div class="lastname-div">
                <label id="lastname-label" class="lastname-label">Last Name</label>
                <input title="Last Name" type=text id="lastname" class="lastname" value="<?php echo $_SESSION['lastname']?>" disabled>
            </div>
            <div class="username-div">
                <label id="username-label" class="username-label">Username</label>
                <input title="Username" type=text id="username" class="username" value="<?php echo $_SESSION['username']?>" disabled>
            </div>
            <div class="email-div">
                <label id="email-label" class="email-label">Email</label>
                <input title="Email" type=text id="email" class="email" value="<?php echo $_SESSION['email']?>" disabled>
            </div>
            <div class="campus-div">
                <label id="campus-label" class="campus-label">Campus</label>
                <input title="Campus" type=text id="campus" class="campus" value="<?php echo $_SESSION['campus']?>" disabled>
            </div>
            <div class="role-div">
                <label id="role-label" class="role-label">Role</label>
                <input title="Role" type=text id="role" class="role" value="<?php echo $_SESSION['role']?>" disabled>
            </div>
            <div class="receive-div">
                <label id="receive-label" class="receive-label">Receiving Notifications</label>
                <input title="Receive Notifications" type=text id="receive" class="receive" value="<?php echo $_SESSION['receive']?>" disabled>
            </div>
        </div>
    </div>
</body>
</html>
