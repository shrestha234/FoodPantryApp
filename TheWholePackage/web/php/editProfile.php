<?php include_once("Classes/Database.php");
session_start();
//If the UserID is empty then redirect to the front page
if(isset($_SESSION['userid']) == ""){
    header("Location: ../index");
}
else{
    $userid = $_SESSION['userid'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $campus = $_SESSION['campus'];
    $role = $_SESSION['role'];
    $receive = $_SESSION['receive'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat">
    <link rel="stylesheet" href="../css/landing.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title> My Preferences </title>
</head>
<body>
    <div class="wrapper">
        <div class="logo-container">
            <a href="https://www.pcc.edu/"><img src="../assets/logo.png" alt="Portland Community College"></a>
        </div>
        <div id="edit-profile-container" class="container">
            <h2>Edit My Preferences</h2>
            <form method="post">
                <div class="firstname-div">
                    <!--Hidden userid and role fields, because the user can't  edit them-->
                    <input name="userid" type=hidden id="userid" class="userid" value="<?php echo $userid?>" required>
                    <input name="role" type="hidden" id="role" class="role" value="<?php echo $role?>" required>

                    <label id="firstname-label" class="firstname-label">First Name</label>
                    <input title="First Name" name="firstname" type=text id="firstname" class="firstname" value="<?php echo $firstname?>" required>
                </div>
                <div class="lastname-div">
                    <label id="lastname-label" class="lastname-label">Last Name</label>
                    <input title="Last Name" name="lastname" type=text id="lastname" class="lastname" value="<?php echo $lastname?>" required>
                </div>
                <div class="username-div">
                    <label id="username-label" class="username-label">Username</label>
                    <input title="Username" name="username" type=text id="username" class="username" value="<?php echo $username?>" required>
                </div>
                <div class="email-div">
                    <label id="email-label" class="email-label">Email</label>
                    <input title="Email" name="email" type=text id="email" class="email" value="<?php echo $email?>" required>
                </div>
                <div class="campuses">
                    <h4>Select Campus</h4>
                    <br>
                    <select title="Campus" id="campus" name="campus" required>
                        <option value="Cascade" <?php if($campus=="Cascade"){
                                echo 'selected="selected"';} ?>>Cascade</option>
                        <option value="Rock Creek" <?php if($campus=="Rock Creek"){echo 'selected="selected"';} ?>>Rock Creek</option>
                        <option value="Southeast" <?php if($campus=="Southeast"){echo 'selected="selected"';} ?>>Southeast</option>
                        <option value="Sylvania" <?php if($campus=="Sylvania"){echo 'selected="selected"';} ?>>Sylvania</option>
                    </select>
                </div>
                <div class="receiving-notifications">
                    <br>
                    <h4>Receiving notifications:</h4>
                    <br>
                    <select title="Notifications Preference" id="pref" name="pref" required>
                        <option value="Yes" <?php if($receive=="Yes"){echo 'selected="selected"';} ?>>Yes</option>
                        <option value="No" <?php if($receive=="No"){echo 'selected="selected"';} ?>>No</option>
                    </select>
                </div>
                <div id="save-cancel-buttons-div">
                    <br>
                    <button type="submit" name="save-submit" id="save">Save</button>
                    <button id="cancel" name ="cancel">Go Back</button>
                    <br>
                    <br>
                </div>
            </form>
            <?php
            if(isset($_POST['cancel'])){
                Database::redirect($_SESSION['role']);
            }
            if(isset($_POST['save-submit'])) {
                $dupUsername = Database::saveProfileFindDuplicateUsername($userid, $_POST['username']);
                if($dupUsername){
                    if($dupUsername['Username'] == $_POST['username']) {
                    echo "<label style=\"width: 100%; height: 50px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Username already taken</label>";
                    exit();
                    }
                }
                else {
                    $dupEmail = Database::saveProfileFindDuplicateEmail($userid, $_POST['email']);
                    if ($dupEmail) {
                        if ($dupEmail['Email'] == $_POST['email']) {
                            echo "<label style=\"width: 100%; height: 50px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Email already taken</label>";
                            exit();
                        }
                    }
                }
                $infoToSave = Database::saveProfile($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['campus'], $_POST['role'], $_POST['pref'], $userid);
                if($infoToSave){
                    $results = Database::retrieveLatest($userid);
                    Database::sessionStarter($results);
                    Database::redirect($_SESSION['role']);
                }
                elseif(!$infoToSave) {
                    echo "<label style=\"width: 100%; height: 50px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Something went wrong</label>";
                    exit();
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
