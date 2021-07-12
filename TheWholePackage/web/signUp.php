<?php include_once "php/Classes/Database.php";
//Pass the extra variable to prevent conflict between
//the AJAX POST and the form POST
if(isset($_POST['extra']) && isset($_POST['username'])){
    $count = Database::checkUsernameAvailability($_POST['username']);
    if($count > 0){
        $response = "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Username already taken</label>";
    }
    else{
        $response = "";
    }
    echo $response;
    exit;
}
if(isset($_POST['extra']) && isset($_POST['email'])){
    $count = Database::checkEmailAvailability($_POST['email']);
    if($count > 0){
        $response = "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Email already taken</label>";
    }
    else{
        $response = "";
    }
    echo $response;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="js/validate.js" type="text/javascript"></script>
    <script src="js/availability.js" type="text/javascript"></script>
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
    <div id="sign-up-container" class="sign-up-container">
        <form method="post">
            <h4>Sign Up</h4>
                <input type="text" placeholder="First name" name="firstName" title="First name" required>
                <input type="text" placeholder="Last Name" name="lastName" title="Last name" required>
                <input type="email" placeholder="Email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must be a valid email address" required>
                <input type="text" placeholder="Username" id="username" name="username" pattern=".{6,}" title="Must be at least 6 characters" required>
                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,}" title="Follow the requirements" placeholder="Password" id="password" name="password" required>
                <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{9,}" title="Follow the requirements" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required>
            <div class="pass-req-container" id="pass-req-container">
                <h4>Password Criteria</h4>
                <ul>
                    <li id="length" class="invalid">Must have at least 9 characters</li>
                    <li id="letter" class="invalid">Must have at least one Lowercase letter</li>
                    <li id="capital" class="invalid">Must have at least one Uppercase letter</li>
                    <li id="number" class="invalid">Must have at least one number</li>
                    <li id="match" class="invalid">Passwords must match</li>
                </ul>
            </div>
            <div class="campuses">
                <h4>Select Campus</h4>
                <select id="campus" name="campus" title="Please select a campus from the list" required>
                    <option value="" selected disabled>Select Campus</option>
                    <option value="Cascade">Cascade</option>
                    <option value="Rock Creek">Rock Creek</option>
                    <option value="Southeast">Southeast</option>
                    <option value="Sylvania">Sylvania</option>
                </select>
            </div>
            <button type="submit" name="Sign_Up_Submit" class="sub-button">Sign Up</button>
        </form>
        <div class="do-not-have-account-container">
            <a class="switch-container" href="index">Sign In</a>
            <a class="forgot" href="php/Pwd/resetPassword">Forgot Password?</a>
            <div id="availability"></div>
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
        <?php
        if(isset($_POST['Sign_Up_Submit'])) {
            if(strcmp($_POST['confirm_password'], $_POST['password'] == 0)){
                $results = Database::signUPFindDuplicates($_POST['username'], $_POST['email']);
                if ($results) {
                    if(strcmp($results['Username'], $_POST['username']) == 0){
                        echo "<label style=\"width100%; color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Username already taken</label>";
                    }
                    elseif(strcmp($results['Email'], $_POST['email']) == 0){
                        echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Email already taken</label>";
                    }
                }
                else{
                    $success = Database::signUp($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['campus']);
                    if($success){
                        header("Location: php/success");
                    }
                    else{
                        echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Registration failed. Please try again!</label>";
                    }
                }
            }
            else {
                echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 15px\">Passwords do not match</label>";
            }
        }
        ?>
    </div>

</div>
</body>
</html>
