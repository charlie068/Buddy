<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="./css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">

</head>

<body>
<?php
 // include the config
require_once('login/config/config.php');
require_once('login/translations/en.php');
require_once('login/libraries/PHPMailer.php');
require_once('login/classes/Registration.php'); 
include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
	header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$db_connection = null;

		
function VerificationCodeIsValid($user_id, $verification_code)
    {
        //$user_id = trim($user_id);

        if (empty($user_id) || empty($verification_code)) {
            $errors[] = MESSAGE_LINK_PARAMETER_EMPTY;
        } else {
            // database query, getting all the info of the selected user
           $result_rowa = getuserinfo($user_id);
          // echo '<br>'.$user_id;
            // if this user exists and have the same hash in database
			//echo '<br>'.$result_rowa->user_id;
			//echo '<br>'.$result_rowa->user_approval_hash;
			//echo '<br>'.$verification_code;
            if ((isset($result_rowa->user_id)) && ($result_rowa->user_approval_hash == $verification_code)) {
					return true;              
            } else {
                echo MESSAGE_USER_DOES_NOT_EXIST;
				return false;
            }
        }
    }


function getuserinfo($id)
	{
		
	if ($db_connection == null) {
				try {
					// Generate a database connection, using the PDO connector
					// @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
					// Also important: We include the charset, as leaving it out seems to be a security issue:
					// @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
					// "Adding the charset to the DSN is very important for security reasons,
					// most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
					$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);		
					if (empty($id)) {
					echo '<br> No Buddy to activate';
					return false;
					}
					else { 
						$query_user = $db_connection->prepare('SELECT * FROM users WHERE user_id = :user_id');
						$query_user->bindValue(':user_id', $id, PDO::PARAM_STR);
						$query_user->execute();
						// get result row (as an object)
						return $query_user->fetchObject();	
						
						
						
										
					} }
					
					catch (PDOException $e) {
					echo 'error db: '.MESSAGE_DATABASE_ERROR . $e->getMessage();
						
					}
				}
	}
			// default return	
		
		
		
		
	
	
	
function ActivateUser($id,$hash_approval)
	  { //echo '<br>'.$id.' '.$hash_approval;
			// if connection already exists
			//.DB_HOST.DB_NAME;
		
			//	echo 'activating user....';
			if ((VerificationCodeIsValid($id,$hash_approval))) {
			
			//	echo '<br> hash aproval valid';
				if ($db_connection == null) {
					
				try {
					// Generate a database connection, using the PDO connector
					// @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
					// Also important: We include the charset, as leaving it out seems to be a security issue:
					// @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
					// "Adding the charset to the DSN is very important for security reasons,
					// most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
					$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
					
					
				 } catch (PDOException $e) {
					echo 'error db: '.MESSAGE_DATABASE_ERROR . $e->getMessage();}
				 
				}
				
				$stmt = $db_connection->prepare('UPDATE users SET user_is_approved = 1, user_approval_hash = NULL WHERE user_id = :user_id AND user_approval_hash = :user_approval_hash');
            $stmt->bindValue(':user_id', intval(trim($id)), PDO::PARAM_INT);
            $stmt->bindValue(':user_approval_hash', $hash_approval, PDO::PARAM_STR);
            $stmt->execute();
				
				
				  // write user's new data into database
					//$stmt = $db_connection->prepare("UPDATE users SET user_is_approved=? WHERE user_id=?");
					//$stmt->execute(array(1, $id));
					$affected_rows = $stmt->rowCount();
					if ($affected_rows>0) {
					  //  $messages[] = '<br>activated successfull';
						return true;
					} else {
						return false; // $errors[] = '<br>failed';
						
					}
				} }
					
					
											
//****					
function delete_user($id,$hash_approval)
//*****
{

if ((VerificationCodeIsValid($id,$hash_approval))) {
	
	if ($db_connection == null) {
					
				try {
					// Generate a database connection, using the PDO connector
			
					$db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
					} catch (PDOException $e) {
					echo 'error db: '.MESSAGE_DATABASE_ERROR . $e->getMessage();}
				 
				}
				
				$stmt = $db_connection->prepare('DELETE FROM users WHERE user_id = :user_id AND user_approval_hash = :user_approval_hash');
            $stmt->bindValue(':user_id', intval(trim($id)), PDO::PARAM_INT);
            $stmt->bindValue(':user_approval_hash', $hash_approval, PDO::PARAM_STR);
            $stmt->execute();
			
				
				  // write user's new data into database
					//$stmt = $db_connection->prepare("UPDATE users SET user_is_approved=? WHERE user_id=?");
					//$stmt->execute(array(1, $id));
					$affected_rows = $stmt->rowCount();
					if ($affected_rows>0) {
					  //  $messages[] = '<br>User deleted successfully';
						return true;
					} else {
						return false; // $errors[] = '<br>failed';
} }	
else
{echo 'problem with code';}}
	   
function sendconfemail($user_email,$body_message)
	{
			$mail = new PHPMailer;
	
			// please look into the config/config.php for much more info on how to use this!
			// use SMTP or use mail()
			if (EMAIL_USE_SMTP) {
				// Set mailer to use SMTP
				$mail->IsSMTP();
				//useful for debugging, shows full SMTP errors
				//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
				// Enable SMTP authentication
				$mail->SMTPAuth = EMAIL_SMTP_AUTH;
				// Enable encryption, usually SSL/TLS
				if (defined(EMAIL_SMTP_ENCRYPTION)) {
					$mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
				}
				// Specify host server
				$mail->Host = EMAIL_SMTP_HOST;
				$mail->Username = EMAIL_SMTP_USERNAME;
				$mail->Password = EMAIL_SMTP_PASSWORD;
				$mail->Port = EMAIL_SMTP_PORT;
			} else {
				$mail->IsMail();
			}
	
			$mail->From = EMAIL_PASSWORDRESET_FROM;
			$mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
			$mail->AddAddress($user_email);
			$mail->Subject = 'Buddy Website, account activated';
			$mail->Body = $body_message;
			
			if(!$mail->Send()) {
				$errors[] = 'MESSAGE_MAIL_FAILED' . $mail->ErrorInfo;
				return false;
			} else {
				$messages[] = 'MESSAGE_SUCCESSFULLY_SENT';
				return true;
	}}  	
			
	
  if (($_SESSION['user_logged_in']==true) and ($_SESSION['isadmin']==true)) 
  
   {
	?>
	<table CLASS="tablewhite">
	<tr class="bd1">
        <td> <?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>
        You are logged in as 'Administrator'
        </td>
    </tr>
	<tr class="bd1">
		<td   >
<?php include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php'); ?>
		</td>	
	</tr>	
	<tr class="bd">
    
    	<td>
	 <?
	 //****
	
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			  $user_id=trim(($_POST["user_id"]));
			  $verification_code=trim(($_POST["verification_code"]));
			  $body_message=trim(($_POST["body"]));
			  if (!empty($_POST["delete"])) {
				
				if (delete_user($user_id,$verification_code)){
					
				echo '<br>USER DELETED';
				
				if (!empty($_POST[user_email]))
				{ 
				$user_email=$_POST[user_email];
				if (sendconfemail($user_email,$body_message))
						{echo '<br> A confirmation email has been sent to :'. $user_email;}
						else 
						{echo '<br> email not sent';}
				}	
					}


			
				 
			}
			
			 elseif (!empty($_POST["activate"])){
									
				if ((ActivateUser($user_id,$verification_code)) and ($user_email=getuserinfo($user_id)->user_email))
					{
					echo '<br>USER ACTIVATED';
					
						if (sendconfemail($user_email,$body_message))
						{echo '<br> A confirmation email has been sent to :'. $user_email;}
						else 
						{echo '<br> email not sent';}
				}					
					else
					 echo '<br> A PROBLEM OCCURED, THE USER HAS NOT BEEN ACTIVATED';
			}
		} else
			{
		
		
		$user_id=$_GET["id"];
		$verification_code=$_GET["verification_code"];
		
		
		?>
	
		 
	 <span class="style2">Activation of a Buddy</span>
<? 
		
	If (getuserinfo($user_id)!=false) 
	{ $result_row = getuserinfo($user_id);	
		$user_email=$result_row->user_email;
		echo '<br>user name  :'.$result_row->user_name;
		echo '<br>user first name  :'. $result_row->first_name;
		echo '<br>user last name  :'.$result_row->last_name;
		echo '<br>user email  :'.$user_email;
		echo '<br>user office  :'. $result_row->office;
		echo '<br>user lab  :'.$result_row->labnum;
		echo '<br>user group  :'. $result_row->group_name;
		echo '<br> user id  :'.$result_row->user_id;
	
		$body_message = "Dear Buddy,\r\n". 
			"Your account has been activated and you can now log in at https://bristolbuddy.x10host.com. \r\n".
			"If you got any question (problem or how to use the website), please send us an email. \r\n". 
			"Best wishes, \r\n". 
			"The buddy website admins,\r\n". 
			"Sun Peng and Jean-Charles Isner.";	
	
    ?>    
        
		<form name="activate" method="POST" action=" <? echo htmlspecialchars($_SERVER["PHP_SELF"]) ?> ">
		
		
		<input type="hidden" name="user_id" value=" <? echo $user_id; ?>" />
		<input type="hidden" name="user_email" value=" <? echo $user_email; ?>" />
		
		<input type="hidden" name="verification_code" value=" <? echo $verification_code; ?>" />
		<br><br>
		<p> Do you want to activate this user?</p> <br>
      <p>Message in the email:</p>
      
      
        <textarea maxlength="400" rows="7" name="body" style="width:800px;"> <? echo $body_message; ?></textarea>
		
		<input type="submit" name="activate" value="Activate">
		<input type="submit" name="delete" value="Delete">
        </form>  
	   <?
       
	   }}}  
	
		  else 
		   {
			header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
			}
		 
			  ?>
		</td>
		  
		  </tr>
		  
	   
	  
		</table>
</body>

</html>