<?php
		require_once($_SERVER["DOCUMENT_ROOT"].'/login/config/config.php');
		require_once($_SERVER["DOCUMENT_ROOT"].'/logbook/recording.php');
		require_once($_SERVER["DOCUMENT_ROOT"].'/login/libraries/PHPMailer.php');

        require_once ($_SERVER["DOCUMENT_ROOT"].'/google-api-php-client-master/src/Google/autoload.php');
        require_once ($_SERVER["DOCUMENT_ROOT"].'/google-api-php-client-master/src/Google/Client.php');
        require_once ($_SERVER["DOCUMENT_ROOT"].'/google-api-php-client-master/src/Google/Service/Calendar.php');

        $client_id = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2.apps.googleusercontent.com'; //change this
        $Email_address = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2@developer.gserviceaccount.com'; //change this
        $key_file_location = ($_SERVER["DOCUMENT_ROOT"].'/API Project-a55017a58c8d.p12');
		$client = new Google_Client();
        $client->setApplicationName("Clientexample");
		$key = file_get_contents($key_file_location);
		$Cal_current =  "7dvkbuhnr54cedkthg029aluek@group.calendar.google.com";
		$Cal_id2 = 'ilko7fb4uft6nplibc0j1dr0ec@group.calendar.google.com';
		$scopes = "https://www.googleapis.com/auth/calendar";
		$cred = new Google_Auth_AssertionCredentials($Email_address, array($scopes), $key);
        $client->setAssertionCredentials($cred);
		if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        	} 
		$service = new Google_Service_Calendar($client);
		date_default_timezone_set("Europe/London");
		//echo '<p>'.date('l jS \of F Y h:i A').'</p>';
		$now=date(DATE_ATOM);
		
		deletemain() ;
		deletecurrent();
 	


function deletemain() {
	
		
	global $client_id, $Email_address, $key_file_location, $client, $key, $Cal_current, $Cal_id2, $scopes,
			$cred, $service, $now;
   		
		$email = $name = $dtpstart =  $dtpend = "";
		$nameErr = $emailErr = $locationErr = "";
	
 
		// delete event in the past--------------------------------------
		
		$events = $service->events->listEvents($Cal_id2);
		
		while(true)
			{
		 	foreach($events->getItems() as $event)
		 		{
		  		//$startevent = $event->getStart()->getDateTime();
				$endevent = $event->getEnd()->getDateTime();
				$IDevent = $event->getid();
				if  ($endevent < $now){
					$event =  $service->events->delete($Cal_id2, $IDevent);
					}
			  
		 	} //End of foreach 
		 
		 	$pageToken = $events->getNextPageToken();
			if($pageToken)
		 		{
		  		$optParametrers = array(‘pageToken’=>$pageToken);
		  		$events = $service->events->listEvents($Cal_id2, $optParameters);
		 		}
		 		else
		  			break;
			}  //End of while-------------------------------


return true;


			
}



//
//  
//


function deletecurrent(){
	global $client_id, $Email_address, $key_file_location, $client, $key, $Cal_current, $Cal_id2, $scopes,
			$cred, $service, $now;
	
	// $now, $service, $Cal_ori, $Cal_current;
	$eventsC = $service->events->listEvents($Cal_current);
$enregistre = new enregistre();
while(true)
{
 foreach($eventsC->getItems() as $eventcurrent)
 {
//  $startcurrent = $eventcurrent->getStart()->getDateTime();
  $endcurrent = $eventcurrent->getEnd()->getDateTime();
 $IDcurrent = $eventcurrent->getid();
//  $location = $eventcurrent->getdescription();
 $attendcurrent_arr = $eventcurrent->getattendees();
  $emailcurrent= $attendcurrent_arr[0]->email;
//  $buddynamecurrent= $eventcurrent->getSummary();
 // if  (($endcurrent > $now) && ($_SESSION['user_email']==$emailcurrent)){
//     $arraycurrent[]=(array($startcurrent,  $endcurrent,  $buddynamecurrent, $emailcurrent, $location, //$IDcurrent));
	// }
	 // sendCheckOutEmail($emailcurrent);
	 //delete events in the past
	 if ($endcurrent < $now) {
		  	
	 $enregistre->checkout($emailcurrent,false, $endcurrent );
	 sendCheckOutEmail($emailcurrent);
	 $eventcurrent =  $service->events->delete($Cal_current, $IDcurrent); 
	 }
	  
 } //End of foreach 
 
 $pageToken = $eventsC->getNextPageToken();
 
 
 if($pageToken)
 {
  $optParametrers = array(‘pageToken’=>$pageToken);
  $eventsC = $service->events->listEvents($Cal_current, $optParameters);
 }
 else
  break;
}  //End of while-------------------------------

return true;
}

 function sendCheckOutEmail($user_email)
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

        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($user_email);
        $mail->Subject = 'Check out verification';

        $link = 'https://bristolbuddy.x10host.com/confirmout.php'.'?confuser='.urlencode($user_email);
		
		

        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = 'You have been checked out automatically. Please confirm you are out of the building by clicking on the following link:'.' '.$link; 
	//	$mail->Body = 'Please activate the account of the following user: '.EMAIL_ACTIVATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($user_approval_hash);
		

       if (!$mail->Send()) {
		   return false;
	   }
		   else
			
			
			
            return true;
       
    }
	
	
				
			?>