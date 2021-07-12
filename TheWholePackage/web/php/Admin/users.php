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
    <title> Edit Users </title>
</head>
<body>
<div class="wrapper">
    <div class="logo-container">
        <a href="https://www.pcc.edu/"><img src="../../assets/logo.png" alt="Portland Community College"></a>
    </div>
    <div id="admin-container" class="container">
        <h1>Search For Users</h1>
        <form method="POST">
            <input title="Username" type="text" id="search-input" placeholder="Username" name="username" required>
            <div id="search-cancel-buttons-div">
                <button type="submit" name="submit" id="search">Search</button>
                <a id="cancel" href="../Landing/manager">Go Back</a>
            </div>
        </form>
        <?php
        if(isset($_POST['submit'])){
            if(strcasecmp($_POST['username'], $_SESSION['username']) == 0){
                echo "<label style=\"width: 100%; height: 50px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">You can't edit your own information from here</label>";
            }else{
                $user = Database::searchUser($_POST['username']);
                if($user){
        ?>
            <div class="user-info">
                <form method="post">
                    <!--Hidden user id field so we use it to locate the user in the database-->
                    <input name="userid" type=hidden id="userid" class="userid" value="<?php echo $user['UserID']?>">
                    <label for="firstname">First Name</label>
                    <input id="firstname" name="firstname" value="<?php echo $user['FirstName'];?>" required>
                    <label for="lastname">Last Name</label>
                    <input id="lastname" name="lastname" value="<?php echo $user['LastName'];?>" required>
                    <label for="username">Username</label>
                    <input id="username" name="username" value="<?php echo $user['Username'];?>" required>
                    <label for="email">Email</label>
                    <input id="email" name="email" value="<?php echo $user['Email'];?>" required>
                    <label for="email">Campus</label>
                    <select title="Campus" name="campus" required>
                        <option value="Cascade" <?php if($user['Campus']=="Cascade"){echo 'selected="selected"';} ?>>Cascade</option>
                        <option value="Rock Creek" <?php if($user['Campus']=="Rock Creek"){echo 'selected="selected"';} ?>>Rock Creek</option>
                        <option value="Southeast" <?php if($user['Campus']=="Southeast"){echo 'selected="selected"';} ?>>Southeast</option>
                        <option value="Sylvania" <?php if($user['Campus']=="Sylvania"){echo 'selected="selected"';} ?>>Sylvania</option>
                    </select>
                    <label for="role">Role</label>
                    <select title="Role" name="role" required>
                        <option value="Subscriber" <?php if($user['Role']=="Subscriber"){echo 'selected="selected"';} ?>>Subscriber</option>
                        <option value="Staff" <?php if($user['Role']=="Staff"){echo 'selected="selected"';} ?>>Staff</option>
                        <option value="Manager" <?php if($user['Role']=="Manager"){echo 'selected="selected"';} ?>>Manager</option>
                    </select>
                    <label for="role">Receiving notifications</label>
                    <select title="Notification Preferences" name="pref" required>
                        <option value="Yes" <?php if($user['Receive']=="Yes"){echo 'selected="selected"';} ?>>Yes</option>
                        <option value="No" <?php if($user['Receive']=="No"){echo 'selected="selected"';} ?>>No</option>
                    </select>
                    <br>
                    <button type="submit" name="delete" id="delete">Delete User</button>
                    <button type="submit" name="save" id="save">Save</button>
                </form>
            </div>
    <?php
                }else{
                    echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">No Users Found</label>";
                }
            }
        }
        if(isset($_POST['save'])) {
            $dupUname = Database::saveProfileFindDuplicateUsername($_POST['userid'], $_POST['username']);
            if($dupUname){
                if($dupUname['Username'] == $_POST['username']) {
                echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Username already taken</label>";
                exit();
                }
            }
            else {
                $dupEmail = Database::saveProfileFindDuplicateEmail($_POST['userid'], $_POST['email']);
                if ($dupEmail) {
                    if ($dupEmail['Email'] == $_POST['email']) {
                        echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Email already taken</label>";
                        exit();
                    }
                }
            }
            $infoToSave = Database::saveProfile($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['campus'], $_POST['role'], $_POST['pref'], $_POST['userid']);
            if($infoToSave){
                echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: green; margin: 50px auto; text-align: center;\">Information Saved Successfully</label>";
            }
            elseif(!$infoToSave) {
                echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: red; margin: 50px auto; text-align: center;\">Something went wrong</label>";
                exit();
            }
        }
        if(isset($_POST['delete'])){
            $delete = Database::deleteAccount($_POST['username']);
            if($delete){
                echo "<label style=\"width: 100%; height: 30px; color:white;font-size:15px;display:block; padding:5px 0 5px 0;background-color: green; margin: 50px auto; text-align: center;\">User Deleted Successfully</label>";
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