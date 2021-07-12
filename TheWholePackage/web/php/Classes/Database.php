<?php
/**
 * Class Database
 * Database class to connect to the database.
 * This class contains methods that need database connection to execute
 */
class Database
{
    /**
     * Database login information
     */
    const DB_SERVER = "cisdbss.pcc.edu";
    const DB_DATABASE = "234a_TheWholePackage";
    const DB_USER = "234a_TheWholePackage";
    const DB_PASSWORD = "Spring_2020_#}})_TheWholePackage";

    /**
     * constants to use for prepared statements
     */
    const DISPLAY_NOTIFICATION_LOG = "SELECT * FROM NotificationLog";
    const DISPLAY_NOTIFICATION_LOG_DATE_RANGE = "SELECT * FROM NotificationLog WHERE CAST(TimeSent as date) BETWEEN ? AND ?";
	const INSERT_NEW = "INSERT INTO Users (FirstName, LastName, Email, Username, Password, Campus) VALUES (?, ?, ?, ?, ?, ?)";
	const SIGN_UP_FIND_DUPLICATES = "SELECT * FROM Users WHERE Username = ? OR Email = ?";
	const SIGN_IN = "SELECT * FROM Users WHERE Username = ?";
	const DELETE_ACCOUNT = "DELETE FROM Users WHERE Username = ?";
	const SAVE_FIND_DUPLICATES_USERNAME = "SELECT * FROM Users WHERE UserID <> ? AND Username = ?";
	const SAVE_FIND_DUPLICATES_EMAIL = "SELECT * FROM Users WHERE UserID <> ? AND Email = ?";
	const RETRIEVE_LATEST = "SELECT * FROM Users WHERE UserID = ?";
	const SAVE_PROFILE = "UPDATE Users SET FirstName = :firstname ,
                 						   LastName = :lastname,
                 						   Email = :email,
                 						   Username = :username,
                 						   Campus = :campus,
                                           Role = :role,
                                           Receive = :receive
										   WHERE UserID = :userid";
	const CHECK_AVAILABILITY_USERNAME = "SELECT Username FROM Users WHERE Username = ?";
    const CHECK_AVAILABILITY_EMAIL = "SELECT Email FROM Users WHERE Email = ?";
    const SEARCH_USER = "SELECT * FROM Users WHERE Username = ? ";
    const CREATE_TEMPLATE = "INSERT INTO Template (UserID, Name, Subject, Message) VALUES (?, ?, ?, ?)";
    protected static $db = NULL;

    /**
     * connect method to initiate the database connection
     */
    protected static function connect() {
        if (empty(Database::$db)) {
            Database::$db = new PDO(
                "sqlsrv:Server=" . Database::DB_SERVER . ";Database=" . Database::DB_DATABASE,
                Database::DB_USER,
                Database::DB_PASSWORD
            );
        }
    }

    /**
     * This method will display all the notification logs
     * @return mixed will return everything in the NotificationLog table
     */
    public static function displayNotificationLog() {
        Database::connect();
        $stmt = Database::$db->prepare(Database::DISPLAY_NOTIFICATION_LOG);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This method will display notification logs within a date range
     * It takes a start and a end date to filter the logs
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function displayNotificationLogDateRange($start, $end){
        Database::connect();
        $stmt = Database::$db->prepare(Database::DISPLAY_NOTIFICATION_LOG_DATE_RANGE);
        $stmt->execute(array($start, $end));
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * This method will check for duplicate before registering a user
     * @param $username
     * @param $email
     * @return mixed
     */
    public static function signUPFindDuplicates($username, $email){
		Database::connect();
		$stmt = Database::$db->prepare(Database::SIGN_UP_FIND_DUPLICATES);
		$stmt->execute(array($username, $email));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * This method will dynamically check username availability as the user is typing in the username field
     * @param $username
     * @return mixed
     */
    public static function checkUsernameAvailability($username){
        Database::connect();
        $stmt = Database::$db->prepare(Database::CHECK_AVAILABILITY_USERNAME);
        $stmt->execute(array($username));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This method will dynamically check email availability as the user is typing in the email field
     * @param $email
     * @return mixed
     */
    public static function checkEmailAvailability($email){
        Database::connect();
        $stmt = Database::$db->prepare(Database::CHECK_AVAILABILITY_EMAIL);
        $stmt->execute(array($email));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This method will insert a new user in the database
     * It will also hash the entered password before insertion
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $username
     * @param $password
     * @param $campus
     * @return mixed
     */
	public static function signUp($firstname, $lastname, $email, $username, $password, $campus){
    	Database::connect();
        $firstname = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($firstname))));
        $lastname =str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($lastname))));
    	$hash = password_hash($password, PASSWORD_BCRYPT, array('cost'=>11));
    	$stmt = Database::$db->prepare(Database::INSERT_NEW);
    	return $stmt->execute(array($firstname, $lastname, $email, $username, $hash, $campus));
	}

    /**
     * This method will sign the user in
     * @param $username
     * @param $password
     * @return mixed
     */
	public static function signIn($username, $password){
		Database::connect();
		$stmt = Database::$db->prepare(Database::SIGN_IN);
		$stmt->execute(array($username, $password));
        return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * This method will start a session and assign
     * the user information to the current session
     * @param $results
     */
	public static function sessionStarter($results){
        session_start();
        $_SESSION['userid'] = $results['UserID'];
        $_SESSION['firstname'] = $results['FirstName'];
        $_SESSION['lastname'] = $results['LastName'];
        $_SESSION['username'] = $results['Username'];
        $_SESSION['email'] = $results['Email'];
        $_SESSION['campus'] = $results['Campus'];
        $_SESSION['role'] = $results['Role'];
        $_SESSION['receive'] = $results['Receive'];
    }

    /**
     * This method will redirect to the appropriate
     * pages based on the user's role
     * @param $role
     */
    public static function redirect($role){
        if (strcmp($role, "Subscriber") == 0) {
            header("Location: Landing/subscriber");
        } elseif (strcmp($role, "Staff") == 0) {
            header("Location: Landing/staff");
        } elseif (strcmp($role, "Manager") == 0) {
            header("Location: Landing/manager");
        }
    }

    /**
     * This method will check for duplicate username when the user is editing their profile
     * @param $id
     * @param $username
     * @return mixed
     */
	public static function saveProfileFindDuplicateUsername($id, $username){
		Database::connect();
		$stmt = Database::$db->prepare(Database::SAVE_FIND_DUPLICATES_USERNAME);
		$stmt->execute(array($id, $username));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * This method will check for duplicate email when the user is editing their profile
     * @param $id
     * @param $email
     * @return mixed
     */
	public static function saveProfileFindDuplicateEmail($id, $email){
		Database::connect();
		$stmt = Database::$db->prepare(Database::SAVE_FIND_DUPLICATES_EMAIL);
		$stmt->execute(array($id, $email));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * This method will save the new information after the user edits their profile
     * @param $firstname
     * @param $lastname
     * @param $username
     * @param $email
     * @param $campus
     * @param $receive
     * @param $id
     * @return mixed
     */
	public static function saveProfile($firstname, $lastname, $username, $email, $campus, $role, $receive, $id){
    	Database::connect();
        $firstname = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($firstname))));
        $lastname =str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($lastname))));
    	$stmt = Database::$db->prepare(Database::SAVE_PROFILE);
    	return ($stmt->execute(array(':firstname' => $firstname,
									':lastname' => $lastname,
									':username'=> $username,
									':email' => $email,
									':campus'=> $campus,
									':role'=> $role,
									':receive' => $receive,
									':userid' => $id)));
	}

    /**
     * This method will retrieve the latest information from the database
     * after saving the changes the user made
     * @param $id
     * @return mixed
     */
	public static function retrieveLatest($id){
    	Database::connect();
		$stmt = Database::$db->prepare(Database::RETRIEVE_LATEST);
		$stmt->execute(array($id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * This method will delete the user account
     * The user is only able to delete their account from inside their profile
     * so there is not need to check if they are in the database before deleting
     * @param $username
     */
	public static function deleteAccount($username){
    	Database::connect();
		$stmt = Database::$db->prepare(Database::DELETE_ACCOUNT);
		return $stmt->execute(array($username));
    }

    /**
     * This method will search for users in the database
     * based on the username entered by a manager
     * @param $username
     * @return mixed
     */
    public static function searchUser($username){
        Database::connect();
        $stmt = Database::$db->prepare(Database::SEARCH_USER);
        $stmt->execute(array($username));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * This method will insert a new template into the database
     * Only managers and staff can create templates
     * @param $userid
     * @param $subject
     * @param $template
     * @param $name
     * @return mixed
     */
    public static function createTemplate($userid, $name, $subject, $template){
        Database::connect();
        $stmt = Database::$db->prepare(Database::CREATE_TEMPLATE);
        return $stmt->execute(array($userid, $name, $subject, $template));
    }
}