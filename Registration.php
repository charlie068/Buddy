<?php

/**
 * Handles the user registration
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection            = null;
    /**
     * @var bool success state of registration
     */
    public  $registration_successful  = false;
    /**
     * @var bool success state of verification
     */
    public  $verification_successful  = false;
    /**
     * @var array collection of error messages
     */
    public  $errors                   = array();
    /**
     * @var array collection of success / neutral messages
     */
    public  $messages                 = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        session_start();

        // if we have such a POST request, call the registerNewUser() method
        if (isset($_POST["register"])) {
            $this->registerNewUser($_POST['user_name'], $_POST['first_name'], $_POST['last_name'], $_POST['group_name'],  $_POST['office'], $_POST['lab_num'], $_POST['user_email'], $_POST['user_password_new'], $_POST['user_password_repeat'], $_POST["captcha"], $_POST['rulescheckbox'] , $_POST['persocheckbox'])   ;
        // if we have such a GET request, call the verifyNewUser() method
        } else if (isset($_GET["id"]) && isset($_GET["verification_code"])) {
            $this->verifyNewUser($_GET["id"], $_GET["verification_code"]);
        }
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection()
    {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser($user_name, $first_name, $last_name, $group_name, $office, $lab_num, $user_email, $user_password, $user_password_repeat, $captcha, $rulescheckbox, $persocheckbox)
    {
        // we just remove extra space on username and email
        $user_name  = trim($user_name);
        $user_email = trim($user_email);
		$first_name  = trim($first_name);
        $last_name = trim($last_name);
		$group_name  = trim($group_name);
		$office= trim($office);
		$lab_num= trim($lab_num);
		
     

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (strtolower($captcha) != strtolower($_SESSION['captcha'])) {
            $this->errors[] = MESSAGE_CAPTCHA_WRONG;
        } elseif (empty($user_name)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } elseif (empty($user_password) || empty($user_password_repeat)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
			
	    } elseif (empty($first_name)) {
            $this->errors[] = 'First name field was empty';
		} elseif (empty($last_name)) {
            $this->errors[] = 'Last name field was empty';
		} elseif (empty($group_name)) {
            $this->errors[] = 'Group name field was empty';
			} elseif (empty($office)) {
            $this->errors[] = 'Group name field was empty';
			} elseif (empty($lab_num)) {
            $this->errors[] = 'Group name field was empty';
			} elseif (!preg_match('/[\d]{2,}$/', $user_name))
			
		 {
            $this->errors[] = 'User name does not contain 2 digits';	
		} elseif (strlen($first_name) > 64 || strlen($first_name) < 2) {
            $this->errors[] = 'First name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $first_name)) {
            $this->errors[] = 'First name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
		} elseif (strlen($last_name) > 64 || strlen($last_name) < 2) {
            $this->errors[] = 'Last name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $last_name)) {
            $this->errors[] = 'Last name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
		} elseif (strlen($group_name) > 64 || strlen($group_name) < 2) {
            $this->errors[] = 'Group name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
        } elseif (!preg_match('/^[a-z \d]{2,64}$/i', $group_name)) {
            $this->errors[] = 'Group name does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
		} elseif (strlen($office) > 64 || strlen($office) < 2) {
            $this->errors[] = 'Office number does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
        } elseif (!preg_match('/^[a-z \d]{2,64}$/i', $office)) {
            $this->errors[] = 'Office number does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
		} elseif (strlen($lab_num) > 64 || strlen($lab_num) < 2) {
            $this->errors[] = 'Lab number does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
        } elseif (!preg_match('/^[a-z \d]{2,64}$/i', $lab_num)) {
            $this->errors[] = 'Lab number does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters';
			
        } elseif ($user_password !== $user_password_repeat) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        } elseif (strlen($user_password) < 8) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        } elseif (strlen($user_name) > 64 || strlen($user_name) < 2) {
            $this->errors[] = MESSAGE_USERNAME_BAD_LENGTH;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {
            $this->errors[] = MESSAGE_USERNAME_INVALID;
        } elseif (empty($user_email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
		} elseif (strpos($user_email,'@bristol.ac.uk') === false) {
            $this->errors[] = 'Not a Bristol Email Address';
        } elseif (strlen($user_email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;
		} elseif ($rulescheckbox !== 'checked' ) {
            $this->errors[] = 'Please accept the buddy system rules';
		} elseif ($persocheckbox !== 'checked' ) {
            $this->errors[] = 'Please accept not to reveal personal information';
		//}  
		//	 elseif ( 
		
		  	
		//	(!preg_match('/([a-z]{1,})/', $user_password_new)) or
		//	(!preg_match('/([A-Z]{1,})/', $user_password_new)) or
			//(!preg_match('/([\d]{1,})/', $user_password_new)) )
  // 	{         
	//	 $this->errors[] = 'Password wrong format';
			

        // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            // check if username or email already exists
            $query_check_user_name = $this->db_connection->prepare('SELECT user_name, user_email FROM users WHERE user_name=:user_name OR user_email=:user_email');
            $query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_name->bindValue(':user_email', $user_email, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll();

            // if username or/and email find in the database
            // TODO: this is really awful!
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->errors[] = ($result[$i]['user_name'] == $user_name) ? MESSAGE_USERNAME_EXISTS : MESSAGE_EMAIL_ALREADY_EXISTS;
                }
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                $user_activation_hash = sha1(uniqid(mt_rand(), true));
				$user_approval_hash = sha1(uniqid(mt_rand(), true));

                // write new users data into database
                $query_new_user_insert = $this->db_connection->prepare('INSERT INTO users (user_name, first_name, last_name, group_name, office, labnum, user_password_hash, user_email, user_approval_hash, user_activation_hash, user_registration_ip, user_registration_datetime) VALUES(:user_name, :first_name, :last_name, :group_name, :office, :lab_num, :user_password_hash, :user_email, :user_approval_hash, :user_activation_hash, :user_registration_ip, now())');
                $query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':first_name', $first_name, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':last_name', $last_name, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':group_name', $group_name, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':office', $office, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':lab_num', $lab_num, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_email', $user_email, PDO::PARAM_STR);
				$query_new_user_insert->bindValue(':user_approval_hash', $user_approval_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                $query_new_user_insert->bindValue(':user_registration_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                $query_new_user_insert->execute();

                // id of new user
                $user_id = $this->db_connection->lastInsertId();

                if ($query_new_user_insert) {
                    // send a verification email
                    if ($this->sendVerificationEmail($user_id, $user_email,$user_activation_hash,$user_approval_hash)) {
                        // when mail has been send successfully
                        $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
                        $this->registration_successful = true;
                    } else {
                        // delete this users account immediately, as we could not send a verification email
                        $query_delete_user = $this->db_connection->prepare('DELETE FROM users WHERE user_id=:user_id');
                        $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                        $query_delete_user->execute();

                        $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                    }
                } else {
                    $this->errors[] = MESSAGE_REGISTRATION_FAILED;
                }
            }
        }
    }

    /*
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    public function sendVerificationEmail($user_id, $user_email,$user_activation_hash,$user_approval_hash)
    {
        $mail = new PHPMailer;
		$mail2 = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
			$mail2->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
			$mail2->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
				$mail2->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
			$mail2->Host = EMAIL_SMTP_HOST;
            $mail2->Username = EMAIL_SMTP_USERNAME;
            $mail2->Password = EMAIL_SMTP_PASSWORD;
            $mail2->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
			$mail2->IsMail();
        }

        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
		$mail2->From = EMAIL_VERIFICATION_FROM;
        $mail2->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail2->AddAddress('bzjcefi@bristol.ac.uk');
        $mail2->Subject = EMAIL_VERIFICATION_SUBJECT;

        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);
		
		

        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link; 
		$mail2->Body = 'Please activate the account of the following user: '.EMAIL_ACTIVATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_approval_hash);
		

        if(!$mail->Send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            return false;
        } else {
			$mail2->Send();
			
			
            return true;
        }
    }

    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_activation_hash)
    {
        // if database connection opened
        if ($this->databaseConnection()) {
            // try to update user with specified information
            $query_update_user = $this->db_connection->prepare('UPDATE users SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();

            if ($query_update_user->rowCount() > 0) {
                $this->verification_successful = true;
                $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
            } else {
                $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
    }
}
