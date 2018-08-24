<?php
session_start();
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
$namebuddy = $_SESSION['user_name'];
$emailbuddy = $_SESSION['user_email'];
$_SESSION['quickbook']=false;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Bristol Buddy System</title>
<link href="./css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
    <link href="./css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    
    <!--    <link rel="stylesheet" href="./shoutbox/shoutbox.css" type="text/css">
     Copy the code between "Start Meta and links" and "End Meta and links",
paste it before the </head> closing tag on every page which includes the shoutbox
-->

<!-- 2. Start Meta and links -->

<style type="text/css">
/* for Mozilla only: create rounded corners */
#box {
-moz-border-radius: 10px 10px 10px 10px;
}
</style>
<link rel="stylesheet" type="text/css" href="./wtag/css/main.css" />
<link rel="stylesheet" type="text/css" href="./wtag/css/main-style.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="wtag/css/ie-style.css" />
<![endif]-->
<script type="text/javascript" src="wtag/js/dom-drag.js"></script>
<script type="text/javascript" src="wtag/js/scroll.js"></script>
<script type="text/javascript" src="wtag/js/conf.js"></script>
<script type="text/javascript" src="wtag/js/ajax.js"></script>
<script type="text/javascript" src="wtag/js/drop_down.js"></script>
<!-- 2. End Meta and links -->
    
    
    
    
</head>

<body>
<?php

include($_SERVER["DOCUMENT_ROOT"].'/deleteeventinpast.php') ;
 
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');


 
 ?>
<table  CLASS="tablewhite">
  <tr class="bd1">
  
    <td colspan="2" ><?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?> 

  </td></tr>
<tr  class="bd1">
     <td   colspan="2" >
	 <?php
     //print_r($_SESSION);
     if ($_SESSION['user_logged_in']=='1') { 
	   include ($_SERVER["DOCUMENT_ROOT"].'/log.php'); 
	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php'); 
?>
        </td>
        </tr> 
		
		<?php
       	include ("showimage.php"); ?>

  
  		
        <?php
        if ($_SESSION['bookinsucc']==true){
			$_SESSION['bookinsucc']=false;
			?>
           <tr class="bd1"> 
     		<td colspan="2">
           
            <span class="style9"> Don't forget to Check in when you are in the LSB buidling. Thanks </span>
            </td>
            </tr>
			
			
			
			<? }
     	?>
        <tr class="bd1"> 
     	    <td >
            <?
	  
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
       	// session_start();
        require_once 'google-api-php-client-master/src/Google/autoload.php';
        require_once 'google-api-php-client-master/src/Google/Client.php';
        require_once 'google-api-php-client-master/src/Google/Service/Calendar.php';


        $client_id = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2.apps.googleusercontent.com'; //change this
        $Email_address = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2@developer.gserviceaccount.com'; //change this
        $key_file_location = 'API Project-a55017a58c8d.p12'; //change this
        
		$client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        
		$key = file_get_contents($key_file_location);
		
		$Cal_id2 = 'ilko7fb4uft6nplibc0j1dr0ec@group.calendar.google.com';
		//$Cal_id2 = 'bristol.ac.uk_p4v6tdiit9a7ekb1e6k8vtfq7c@group.calendar.google.com';
		         //"bristol.ac.uk_p4v6tdiit9a7ekb1e6k8vtfq7c@group.calendar.google.com";  //week calendar
		$email = $name = $dtpstart =  $dtpend = "";
		$nameErr = $emailErr = $locationErr = "";
		$scopes = "https://www.googleapis.com/auth/calendar";
        $cred = new Google_Auth_AssertionCredentials($Email_address, array($scopes), $key);
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        	} 
		$service = new Google_Service_Calendar($client);
		

		// define variables and set to empty values
		$nameErr = $emailErr = $genderErr = $websiteErr = "";
		$gender = $comment = $website = $Errmessage= $dtstart = $dtpend ="";
		$name = $_SESSION['user_name'];
		$email = $_SESSION['user_email'];
		$loc='';
		$location=$location."Office: ".$_SESSION['office']."\n"."Lab number:".$_SESSION['lab_num']."\nGroup: ".$_SESSION['group']."\n";
			//	echo $location;
		$Err=False;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			 
			if (!empty($_POST["bookin"])){
				 //echo 'in   ';
				 if (empty($_POST["location"])) {
				 $location = "";
				 $locationErr =  "location is required"; 
				 $Errmessage="Please enter a location";
				 $Err=True;
		   		 } else {
			 			$location = test_input($_POST["location"]);
						$loc="Who: \n".$_SESSION['first_name']." ".$_SESSION['last_name']."\n";
						$loc.="Email : \n".$email."\n";
						$loc.="Where: \n".$location;
			 			}
				if (empty($_POST["comments"])) {
					$comments = '';
					}
					else {
						$comments = $_POST["comments"];
						$loc.="\n"."Comments: \n".$comments;
					}
				
				    
				if (empty($_POST["dtp_input2"])) {
					$dtpend = ""; 
					$Err=True;
					$Errmessage=$Errmessage.'\nPlease enter an end date and time';
					} else {
							$dtpend = test_input($_POST["dtp_input2"]);
						   }
				if (empty($_POST["dtp_input1"])) {
					$dtstart = ""; 
					$Err=True;
					$Errmessage=$Errmessage.'\nPlease enter a start date and time';
					} else {
							$dtpstart = test_input($_POST["dtp_input1"]);
							}
				 if ((!empty($_POST["dtp_input1"])) && (!empty($_POST["dtp_input2"]))) {
					 $time2 = new datetime ($dtpend);// (DateTime::createFromFormat('Y-m-d H:i:s', $dtpend);
					 $time1 = new datetime ($dtpstart); // DateTime::createFromFormat('Y-m-d H:i:s', $dtpstart);
					 $dateinterval =  ( (($time2->getTimestamp())- ($time1->getTimestamp() ))/3600 ); 
					 if ($dateinterval>12) {
						 $Err=True;
						 $Errmessage=$Errmessage.'\nMaximum booking duration is 12 hours';
						 }
					 if ($dtpend<$dtpstart) {
						 $Err=True;
						 $Errmessage=$Errmessage.'\nYou have chosen an end date before the start date';
						 }	
					 
					}
		
		
				if (!$Err) {
	$_SESSION['bookinsucc']=true;
					$event = new Google_Service_Calendar_Event();
					$event->setSummary($name);
					//$event->setLocation($location);
					$event->setdescription($loc);
					//$event->setColorId("11");
					//$googleServiceCEOrganizer = new Google_Service_Calendar_EventOrganizer();
        				//$googleServiceCEOrganizer->setDisplayName("buddy");
        				//$googleServiceCEOrganizer->setEmail('buddy@gmail.com');
					//$googleServiceCEO = new Google_Service_Calendar_EventCreator;
					//$googleServiceCEO->setDisplayName("buddy");
        			      	//$googleServiceCEO->setEmail('buddy@gmail.com');
					//$event->setOrganizer($googleServiceCEOrganizer);
					//$event->setCreator($googleServiceCEO);

					$creator = new Google_Service_Calendar_EventOrganizer();
					$creator->setdisplayname("Jean-Charles ISNER");
					$creator->setEmail('charlie068@gmail.com');
					$event->organizer=$creator;


					$start = new Google_Service_Calendar_EventDateTime();
					$datatimeI = geratime($dtpstart); 
					$start->setDateTime($datatimeI);
					$event->setStart($start);
					$end = new Google_Service_Calendar_EventDateTime();
					$datatimeF = geratime($dtpend); 
					$end->setDateTime($datatimeF);
					$event->setEnd($end);
					$attendee1 = new Google_Service_Calendar_EventAttendee();
					$attendee1->setEmail($email);
					$attendee1->SetdisplayName($_SESSION['first_name']." ".$_SESSION['last_name']);
					$attendees = array($attendee1);
					$event->attendees = $attendees;
					$createdEvent = $service->events->insert($Cal_id2, $event);
					header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
					
	
					}
					else 
						{
						echo "<script type='text/javascript'>alert('$Errmessage');</script>";
						$dtpend = $dtpstart = "";
						}
					 }
	 
	//book out-----------------------------------------------------------------


	if (!empty($_POST["bookout"])){
	$Err=false;		
	
		if  (!$Err) {
			$service = new Google_Service_Calendar($client);
			$events = $service->events->listEvents($Cal_id2);
			while(true)
				{
				 foreach($events->getItems() as $event)
				 	{
				  	$IDevent = $event->getid();
				  	$attend_arr = $event->getattendees();
				   	$emailbuddy= $attendcurrent_arr[0]->email;
				  	$nombuddy= $event->getSummary();
					if  (((!empty($name)) and ($nombuddy == $name)) or ((!empty($email)) and ($emailbuddy==$email))){
						$event =  $service->events->delete($Cal_id2, $IDevent);
						}
					} //End of foreach 
				 
				 	$pageToken = $events->getNextPageToken();
					if($pageToken)
						{
					  	$optParametrers = array(‘pageToken’=>$pageToken);
					  	$events = $service->events->listEvents($Cal_id2, $optParameters);
						header("Location: " . $_SERVER['REQUEST_URI']);
						exit();
					 	}
					 	else
					  		break;
					  header("Location: " . $_SERVER['REQUEST_URI']);
					  exit();
				}  //End of while-------------------------------
				
					//edn bookin

		}}
	

	/// fin delete events with name ------------------
	
		if (!empty($_POST["quickbookin"])){
			$Err=false;	
			$loc="";
			
		
			
			if (empty($_POST["location"])) {
				 $location = "";
				 $locationErr =  "location is required"; 
				 $Errmessage="Please enter a location";
				 $Err=True;
		   		 } else {
			 			$location = test_input($_POST["location"]);
						$loc="Who: \n".$_SESSION['first_name']." ".$_SESSION['last_name']."\n";
						$loc.="Email : \n".$email."\n";
						$loc.="Where: \n".$location;
			 			};
				
					
					if (empty($_POST["timelength"])) {
					$Err=True;
					$Errmessage=$Errmessage.'\nPlease select a duration time';
					}
					else {
					$duration = ($_POST["timelength"]);
					}//test if time selected to do
					//echo ' duration: '.($duration).'<br>';
			if  (!$Err) {
						$loc.=" \n"."Comments: \nQuick Booking";
						date_default_timezone_set("Europe/London");
						$now=date(DATE_ATOM);
						//if ($duration == '30')
						 {  $temps=$duration*3600;}
						//if ($duration == '1') {  $temps=3600;}
						//if ($duration == '2') { $temps=7200;}
						
				
					
						$temptime = strtotime(($now)) + $temps; // Add x hour
						//echo $temptime;
						$qtime2 = date('Y-m-d\TH:i:sP', $temptime); // Back to string
						//echo $now;
						//echo $qtime2;
						//$qtime2 = new datetime ($qtime2);
						
						
					
					
				
				///echo $name.'<br>';
				//echo $email.'<br>';
				//echo $now.'<br>';
				//var_dump($now);
				////echo 'time2';
				//echo ($time2);
				//var_dump(($qtime2));
				//echo $qtime1.'<br>';;
				//echo $qtime2.'<br>';; 
				
				
					$event = new Google_Service_Calendar_Event();
					$event->setSummary($name);
					//$event->setColorId("8");
					//$event->setLocation($location);
					$event->setdescription($loc);//('quick booking'));
					//$googleServiceCEOrganizer = new \Google_Service_Calendar_EventOrganizer();
        			//$googleServiceCEOrganizer->setDisplayName("buddy");
        			//$googleServiceCEOrganizer->setEmail('buddy@gmail.com');
					//$googleServiceCEO = new Google_Service_Calendar_EventCreator;
					//$googleServiceCEO->setDisplayName("buddy");
        			//$googleServiceCEO->setEmail('buddy@gmail.com');
					//$event->setOrganizer($googleServiceCEOrganizer);
					// $event->setCreator($googleServiceCEO);
					$start = new Google_Service_Calendar_EventDateTime();
					echo 'a';
					//$datatimeI = geratime($qtime1); 
					//echo $datatimeI;
					$start->setDateTime(($now));
					$event->setStart($start);
					$end = new Google_Service_Calendar_EventDateTime();
					echo 'b';
					//$datatimeF = geratime($time2); 
					$end->setDateTime(($qtime2));
					$event->setEnd($end);
					$attendee1 = new Google_Service_Calendar_EventAttendee();
					$attendee1->setEmail($email);
					$attendee1->SetdisplayName(($_SESSION['first_name']." ".$_SESSION['last_name']));
					$attendees = array($attendee1);
					$event->attendees = $attendees;
				
					$createdEvent = $service->events->insert($Cal_id2, $event);
	
				sleep (1);
					$_SESSION['quickbook']=true;
					header("Location: buddying.php");
					exit();
				
			} //end if not err
			
			else 
						{
						echo "<script type='text/javascript'>alert('$Errmessage');</script>";
						$dtpend = $dtpstart = "";
						}
		} //enquickbookin
			
	 //end post
		
		 }
	
	//endofpost

?>

    <div class='container'>
   
    <?php include ($_SERVER["DOCUMENT_ROOT"].'/buddychatbox.php');  ?>
    
    
      	<br><br><legend>Booking</legend>
    <form name="normal" method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?> ">

   	
	 <?php echo '   <input type="hidden" name="location" value="'. $location.'">
  
	
	Comments (eg. might be a bit late): <input type="text" name="comments" style="width: 300px;" value="'.$comments.'"/>
	
	
	';?>
  	
 
    <fieldset>
         <div class="form-group">
         <label for="dtp_input1" class="col-md-2 control-label">START<span class="error">*</span></label><br>
               	<div class="input-group date form_datetime col-md-5"  data-date-format="dd MM yyyy - HH:ii p"  data-link-field="dtp_input1">
                <input class="form-control" size="12" type="text" value="<?php echo $dtpstart ?>" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
               	</div>
         </div>
		<input type="hidden" id="dtp_input1" name="dtp_input1" value="" /><br>
         <div class="form-group">
         <label for="dtp_input2" class="col-md-2 control-label">END<span class="error">*</span></label><br>
              	<div class="input-group date form_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p"  data-link-field="dtp_input2">
                <input class="form-control" size="12" type="text" value="<?php echo $dtpend ?>" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
         </div>
		<input type="hidden" id="dtp_input2" name="dtp_input2" value="" /><br>	
     </fieldset>
    <p><br>
      <input type="submit" name="bookin" value="BOOK IN">
      <input type="submit" name="bookout" value="BOOK OUT">
    </p>

    </form> 
           <legend>Quick Booking and Check In</legend>
   
    <form name="quick" method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?> ">


     
   
    <?php echo '   <input type="hidden" name="location" value="'.$location.'">';?>
    <p>Book now for : <br></p>
    <input type="radio" name="timelength" value="0.5">30 minutes
<br>
<input type="radio" name="timelength" value="1">One hour 
<br>
<input type="radio" name="timelength" value="2">Two hours 
<br>
<input type="radio" name="timelength" value="3">Three hours <br>
<input type="radio" name="timelength" value="4">Four hours <br>
<input type="radio" name="timelength" value="6">Six hours <br><br><br>
<input type="submit" name="quickbookin" value="BOOK IN/CHECK IN">
    </form> 
    <br> <br>
    <button onclick="Functionreload()">Refresh page</button>
   </div>
   
    </td>
       <td  align="right">
     <iframe src=    "https://www.google.com/calendar/embed?showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=ilko7fb4uft6nplibc0j1dr0ec%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=Europe%2FLondon" style=" border-width:0 " width="550" height="900" frameborder="0" scrolling="no"></iframe>
           <p>   You can add this calendar to your calendar list by clicking the "+" here  &uarr; </p>
           <p>  and get notifications if somebody book in. </p>
       </td>
       </tr>
      
       
      
    </table>
    
    <script>
    function Functionreload() {
        window.location.href = window.location.href;
    }
    </script> 
    <script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <?php
    $datestart = new DateTime(date('Y-m-d H:i'));
    $datestart->sub(new DateInterval('PT' . '14' . 'M'));
    
    $datestart = $datestart->format('Y-m-d H:i');


	?>

	<script type="text/javascript">

    $(".form_datetime").datetimepicker({
        language:  'uk',
		startDate:"<?php echo $datestart; ?>",
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1,
		minuteStep: 15,
		format: "dd MM yyyy - hh:ii",
		pickerPosition: "top-left"
    });

	
	</script> \' <?php

}

Else {
	 ?>
	
	<span class="style2"> Please Login or Register first </span>  
	</td></tr>
	<tr  class="bd">
     <td   colspan="2" >
     <?php
	include($_SERVER["DOCUMENT_ROOT"].'/login/views/not_logged_in.php');
	echo '
	</td>
	  
	  </tr>
	</table>';
	
	}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function DataIT2DB($datapega) {
            if ($datapega) {
                $data = explode('/', $datapega);
                if (count($data) > 1) {
                    $datacerta = $data[2] . '-' . $data[1] . '-' . $data[0];
                } else {
                    $datacerta = $datapega;
                }
            } else {
                $datacerta = $datapega;
            }
            return $datacerta;
        }

function geratime($datetime) {
    $dataHora = substr ($datetime,0,10). 'T' . substr ($datetime,11,5).':00.000+0'.date('I').':00'; 
    return $dataHora;
}


?>
</body>

</html>