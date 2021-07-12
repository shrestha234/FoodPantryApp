<?php include_once("Classes/Database.php");
session_start();
if(isset($_SESSION['userid']) == ""){
    header("Location: ../index");
}

if(isset($_POST['back-to-landing'])){
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
    <title> Notification Log </title>
</head>
<body>
    <div class="wrapper">
        <div class="logo-container">
            <a href="https://www.pcc.edu/"><img src="../assets/logo.png" alt="Portland Community College"></a>
        </div>
        <div id="notification-log-tab" class="notification-log-tab">
            <h1>Notification Log</h1>
            <div class="notification-log-tools">
                <form method="post">
                    <label for="start-date">Start Date</label>
                    <input type="date" name="start-date" id="start-date">
                    <label for="end-date">End Date</label>
                    <input type="date" name="end-date" id="end-date">
                    <label>All logs will be shown if no date range is selected</label>
                    <button type="submit" id="submit-date-range" name="submit-date-range">View Logs</button>
                    <button id="my-preferences-button" name="back-to-landing">Go Back</button>
                </form>
            </div>
                <?php
                if(isset($_POST['submit-date-range'])){
                    ?>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Time Sent</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Campus</th>
                            <th>Recipient Total</th>
                        </tr>
                        </thead>
                    <?php
                    if(empty($_POST['start-date']) && empty($_POST['end-date'])){
                        $table = Database::displayNotificationLog();
                        //Loop the notification log database to display
                        //a static version of it.
                        foreach($table as $val){
                        $standardTime = date('m/d/Y h:i a', strtotime($val["TimeSent"]));
                        ?>
                            <tr>
                                <td data-label="ID"><?php echo $val["NotificationID"];?></td>
                                <td data-label="Time Sent"><?php echo $standardTime;?></td>
                                <td data-label="Subject"><?php echo $val['Subject'];?></td>
                                <td data-label="Message"><?php echo $val['Message'];?></td>
                                <td data-label="Campus"><?php echo $val['Campus'];?></td>
                                <td data-label="Recipient Total"><?php echo $val['RecipientTotal'];?></td>
                                <?php
                        }
                    }
                    elseif(empty($_POST['start-date']) || empty($_POST['end-date'])){
                        echo "<label style=\"color:white;font-size:15px;display:block; padding:15px 0 15px 0;background-color: red; margin-top: 25px\">Please select a proper date range</label>";
                    }
                    else{
                        $table = Database::displayNotificationLogDateRange($_POST['start-date'], $_POST['end-date']);
                        foreach($table as $val){
                            $convertedTime = date('m/d/Y h:i a', strtotime($val["TimeSent"]));
                            ?>
                            <tr>
                            <td data-label="ID"><?php echo $val["NotificationID"];?></td>
                            <td data-label="Time Sent"><?php echo $convertedTime;?></td>
                            <td data-label="Subject"><?php echo $val['Subject'];?></td>
                            <td data-label="Message"><?php echo $val['Message'];?></td>
                            <td data-label="Campus"><?php echo $val['Campus'];?></td>
                            <td data-label="Recipient Total"><?php echo $val['RecipientTotal'];?></td>
                            <?php
                        }
                    }
                }
                ?>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
