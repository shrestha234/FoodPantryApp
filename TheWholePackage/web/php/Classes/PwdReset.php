<?php include_once "Database.php";
/**
 * Class PwdReset
 * This class will handle everything related to password reset
 * It extends to the Database class to be able to connect to the database
 */
class PwdReset extends Database
{
    /**
     * constants to use for prepared statements
     */
    const DELETE_TOKEN = "DELETE FROM PasswordReset WHERE ResetEmail = ?";
    const NEW_RESET = "INSERT INTO PasswordReset (ResetEmail, ResetSelector, ResetToken, ResetExpiration) VALUES (?, ?, ?, ?)";
    const VERIFY_EMAIL = "SELECT Email FROM Users WHERE Email = ?";
    const FETCH_SELECTOR = "SELECT * FROM PasswordReset WHERE ResetSelector = ? AND ResetExpiration >= ?";
    const FETCH_USER = "SELECT * FROM Users WHERE Email = ?";
    const UPDATE_PASSWORD = "UPDATE Users SET Password = ? WHERE Email = ?";

    /**
     * This method will verify the email the user enters
     * to make sure it's in the database
     * @param $email
     * @return mixed
     */
    public static function verifyEmail($email){
        Database::connect();
        $stmt = Database::$db->prepare(PwdReset::VERIFY_EMAIL);
        $stmt->execute(array($email));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This is a handler function
     * It will handle the first part of the password reset
     * by generating the selector, token and sending the email
     * @param $email
     */
    public static function resetObjectHandler($email){
        try {
            //Generate 8 cryptographically secure pseudo-random bytes
            //and convert it to hexadecimal
            $selector = bin2hex(random_bytes(8));
            //Generate 32 cryptographically secure pseudo-random bytes
            $token = random_bytes(32);
            //Embed the selector and the token in the URL to send to the  user
            $url = "localhost/Sprint2/php/Pwd/newPassword?selector=" . $selector . "&validator=" .bin2hex($token);
            //Generate 30 minutes expiration date
            $expiration = date("U") + 1800;
            self::deleteToken($email);
            $insert = self::newReset($email, $selector, $token, $expiration);
            if($insert) {
                self::sendEmail($email, $url);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * This method will delete any existing tokens related
     * to the user from the PasswordReset table
     * @param $email
     * @return mixed
     */
    public static function deleteToken($email){
        Database::connect();
        $stmt = Database::$db->prepare(PwdReset::DELETE_TOKEN);
        return $stmt->execute(array($email));
    }

    /**
     * This method will insert a new instance of the below variables
     * related to the user that needed a password reset
     * @param $email
     * @param $selector
     * @param $token
     * @param $expiration
     * @return mixed
     */
    public static function newReset($email, $selector, $token, $expiration){
        Database::connect();
        $tokenHash = password_hash($token, PASSWORD_BCRYPT, array('cost'=>11));
        $stmt = Database::$db->prepare(PwdReset::NEW_RESET);
        return $stmt->execute(array($email, $selector, $tokenHash, $expiration));
    }

    /**
     * This method will generate an email, include the link
     * then send it to the user's email they provided
     * @param $email
     * @param $url
     */
    public static function sendEmail($email, $url){
        $subject = 'Password Recovery';
        $message = "<div style=\"font-size: 15px; border: 2px solid #35475A; color: #35475A; background-color: #eeeeee; text-align: center; width: 75%; margin: 0 auto; padding: 10px 20px 30px\">
                    <p style=\"padding-bottom: 10px\">We received a request to reset your password for the PCC Food Pantry.</p>
                    <p>Press the button below to reset your password.</p>
                    <p>If you did not request to reset your password, ignore this email and the link wil expire on its own.</p>";
        $message .= '<a href="' .$url .'" style="
                    border-radius: 5px;
                    border: 1px solid #c74e29;
                    background: #c74e29;
                    color: #fff;
                    font-size: 12px;
                    font-weight: bold;
                    padding: 10px;
                    text-transform: uppercase;
                    text-decoration: none;
                    width: 150px;
                    margin: 10px auto;
                    cursor: pointer;"
                    >Reset My Password</a>';
        $headers = "From: Password Reset | PCC Food Pantry <webmaster@example.com>\r\n";
        $headers .= "Content-type: text/html\r\n";
        mail($email, $subject, $message, $headers);
        header("Location: resetPassword.php?link=sent");
    }

    /**
     * This is also a handler function
     * It handles the second part of the password reset
     * after the user clicks on the link we sent them
     * @param $selector
     * @param $validator
     * @param $password
     * @return bool
     */
    public static function passwordObjectHandler($selector, $validator, $password){
        $returnedSelector = self::fetchSelector($selector);
        if($returnedSelector) {
            $valid = self::verifyValidator($returnedSelector['ResetToken'], $validator);
            if ($valid) {
                $returnedUser = self::fetchUser($returnedSelector['ResetEmail']);
                $reset = self::updatePassword($password, $returnedUser['Email']);
                if ($reset) {
                    $delete = self::deleteToken($returnedUser['Email']);
                    if ($delete) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * This method will fetch the selector associated with the user
     * after they click the link and enter their new password
     * @param $selector
     * @return mixed
     */
    public static function fetchSelector($selector){
        Database::connect();
        $currentDate = date("U");
        $stmt = Database::$db->prepare(PwdReset::FETCH_SELECTOR);
        $stmt->execute(array($selector, $currentDate));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This method will verify the token from the url
     * and compare it to the token in the database
     * @param $resetToken
     * @param $validator
     * @return bool
     */
    public static function verifyValidator($resetToken, $validator){
        $binaryToken = hex2bin($validator);
        return $verifyValidator = password_verify($binaryToken, $resetToken);
    }

    /**
     * This method will fetch the user associated with
     * after verifying the token
     * @param $email
     * @return mixed
     */
    public static function fetchUser($email){
        Database::connect();
        $stmt = Database::$db->prepare(PwdReset::FETCH_USER);
        $stmt->execute(array($email));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This method will update the password of the user in the Users table
     * @param $password
     * @param $email
     * @return mixed
     */
    public static function updatePassword($password, $email){
        Database::connect();
        $hash = password_hash($password, PASSWORD_BCRYPT, array('cost'=>11));
        $stmt = Database::$db->prepare(PwdReset::UPDATE_PASSWORD);
        return $stmt->execute(array($hash, $email));
    }
}
