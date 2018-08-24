

<?php 
//include($_SERVER["DOCUMENT_ROOT"].'/logbook/_header.php'); 
require_once($_SERVER["DOCUMENT_ROOT"].'/login/config/config.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/logbook/recording.php');
include($_SERVER["DOCUMENT_ROOT"].'/deleteeventinpast.php') ;
   include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');  
?>

<!DOCTYPE html>

<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
    <link href="./css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">

</head>

<body>
<table CLASS="tablewhite" >
  <tr class="bd1">
    <td colspan=3 ><?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>
     

  </td></tr>
<tr class="bd1" >
     <td   colspan="3" >
  
<? include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php');

?>

</td></tr>

    <tr class="bd1">
    
    
  <td  colspan="2" ><p class="style2">Booking Status</p></td>
  <td  ><p class="style2">Checking In / Out</p></td>
  </tr>
    
      <tr  class="bd1">
    
    
  <td colspan="2" rowspan="2" width="600px"> 
  
   <?php

 
  // print_r($_SESSION);
   if ($_SESSION['user_logged_in']=='1') {
      //  session_start();
	  
		//echo $emailbuddy;
	  header("Cache-Control: no-cache, must-revalidate");
	  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        require_once 'google-api-php-client-master/src/Google/autoload.php';
        require_once 'google-api-php-client-master/src/Google/Client.php';
        require_once 'google-api-php-client-master/src/Google/Service/Calendar.php';

        $client_id = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2.apps.googleusercontent.com'; //change this
        $Email_address = '1067098611833-9rk0o1tjib7fas7e558dpgimv2oniou2@developer.gserviceaccount.com'; //change this
        $key_file_location = 'API Project-a55017a58c8d.p12'; //change this
        
		$client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        
		$key = file_get_contents($key_file_location);
		$Cal_ori = "ilko7fb4uft6nplibc0j1dr0ec@group.calendar.google.com"; 
		$Cal_current =  "7dvkbuhnr54cedkthg029aluek@group.calendar.google.com";
		
        $scopes = "https://www.googleapis.com/auth/calendar";
        $cred = new Google_Auth_AssertionCredentials(
                $Email_address, array($scopes), $key
        );
        $client->setAssertionCredentials($cred);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        } 
			
        $service = new Google_Service_Calendar($client);


		


//The authorization part of the code is the same
//as the one of the previous example: to keep things
//simple I won’t replicate it here too

// retrieve event from Cal_ori-------------------------------------------------------------------
date_default_timezone_set("Europe/London");
$now=date(DATE_ATOM);
// echo '<br><p>'. date('l jS \of F Y h:i A').'</p>';

 
//----------- end get id current

$arrayori=listori(checkeventori(),checkeventcurrent());

   $tableauori=checkeventori();
 //  echo '<br>   ori:';
 //  var_dump($tableauori);
   $tableaucurrent=checkeventcurrent();
 //  echo '<br>   current';
// var_dump($tableaucurrent);
   $narrayori=listori($tableauori,$tableaucurrent);
   // echo '<br>   new eventnori';
  // var_dump($narrayori);
  if (!empty($narrayori)) { $arrayori=array_values($narrayori);}
  $arraycurrent=$tableaucurrent;
  
  
// arrange array by starttimedate

//if (!empty($arrayori)) {usort($arrayori, "cmp");};
if (!empty($arrayori))

{
	
	
	usort($arrayori, function($a, $b) { return $a[0] < $b[0] ? -1 : 1 ;});

 

}
//var_dump($arrayori);


//--------------------------posting----------------------------------------------------------
if (($_SERVER["REQUEST_METHOD"] == "POST") or ($_SESSION['quickbook']==true)) {
	
	
	if ((!empty($_POST["bookingin_submit"])) or ($_SESSION['quickbook']==true)) {
	$_SESSION['quickbook']=false;
		
 	$name = $_SESSION['user_name'];
	$email = $_SESSION['user_email'];
	$enregistre = new enregistre();	
	$enregistre->checkin($email);		
				

//print_r($arrayori);
		// If button is in, event is inserted in current-----------------------------------------
	
	 
	 for ($i = 0, $iteration = count($arrayori); $i < $iteration; $i++) {
		// Echo '<br> array name '.$arrayori[$i][3];
		// Echo '<br> name '.$email. '<br>';
        if ($arrayori[$i][3] == $email ){
		//	Echo '<br> booking in true ';
		       
			
				$eventcurrent = new Google_Service_Calendar_Event();
				$eventcurrent->setSummary($name);
                $eventcurrent->setdescription($arrayori[$i][5]);
                $startcurrent = new Google_Service_Calendar_EventDateTime();
             	$startcurrent->setDateTime($now);
                $eventcurrent->setStart($startcurrent);
				$endcurrent = new Google_Service_Calendar_EventDateTime();
                $endcurrent->setDateTime($arrayori[$i][1]);
                $eventcurrent->setEnd($endcurrent);
                $attendee1curr = new Google_Service_Calendar_EventAttendee();
                $attendee1curr->setEmail($email);
				$attendee1curr->SetdisplayName($arrayori[$i][2]);
                $attendeescurr = array($attendee1curr);
                $eventcurrent->attendees = $attendeescurr;
			    $createdEvent = $service->events->insert($Cal_current, $eventcurrent);
			   //header('Location: buddyingtest.php');
             // $_SESSION['eventID'] = $createdEvent->getId(); ;
			 //header("Refresh:0");
			
				
	}	 header("Location: " . $_SERVER['REQUEST_URI']);
   exit();}}
			
	
	// If button is out, event is removed from current-------------------------------



	if (!empty($_POST["bookingout_submit"])) {



		$Cal_current =  "7dvkbuhnr54cedkthg029aluek@group.calendar.google.com";
  $arraycurrent=checkeventcurrent();
  //print_r( $arraycurrent);
		// If button is in, event is inserted in current-----------------------------------------
	 $name = $_SESSION['user_name'];
	 $email = $_SESSION['user_email'];
	 
	 $enregistre = new enregistre();	
	 $enregistre->checkout($email,true, $now );
	
	 
	 for ($i = 0, $iteration = count($arraycurrent); $i < $iteration; $i++) {
  
    if ($arraycurrent[$i][3] == $email ){
		//Echo 'unbooking';
		//Echo $i.'   ';
		//echo 'ID event  :'.$arraycurrent[$i][5];
	$eventcurrent =  $service->events->delete($Cal_current, $arraycurrent[$i][5]);

	}
	
	}
		header("Location: " . $_SERVER['REQUEST_URI']);
   exit();}}
		

   
   
   //end of PHP functions---------------------------------------------
   

   

$jour=(date("omd"));

 echo '
 
<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;dates='.$jour.'%2F'.$jour.'&amp;mode=DAY&amp;height=600&amp;bgcolor=%23FFFFFF&amp;src=7dvkbuhnr54cedkthg029aluek%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=Europe%2FLondon" style=" border-width:0 " width="540" height="600" frameborder="0" scrolling="no"></iframe>
  

 </td>
  <td class="bd1" valign="Top">';
			

	$Err=true;        
     if (!empty($arrayori)){
	   
	
					 $time2 = new datetime ($arrayori[0][0]);// (DateTime::createFromFormat('Y-m-d H:i:s', $dtpend);
					 $time1 = new datetime ($now); // DateTime::createFromFormat('Y-m-d H:i:s', $dtpstart);
					 $dateinterval =  ( (($time2->getTimestamp())- ($time1->getTimestamp() ))/3600 ); 
					 
					 if  ( (($time2>$time1) and (abs($dateinterval<2)) ) or ($time2<$time1)){
						 $Err=false;
						 $bookindisabled = 'a';
						 } 
						 
						  
	 }
	 else {$bookindisabled = 'disabled';}
						
		
		if (!empty($arraycurrent))  
		
		{ $Err=false;
		$bookoutdisabled = 'b';}
		else {$bookoutdisabled = 'disabled';}
	
	
	//	var_dump($time2<$time1);
	// var_dump($dateinterval);
	//   var_dump($Err);
	if    (!$Err)
	 { 
	   
	   
	    ?>
	
   <form method="POST" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" name="bookingin">
   <br><br><br>
<input type="submit" <?php echo $bookindisabled; ?> name="bookingin_submit" value="CHECK IN">
  
<br> 
   
<input type="submit" <?php echo $bookoutdisabled; ?> name="bookingout_submit" value="CHECK OUT">
</form>

<?php

 }
else echo ' <br><br><p>You first need to Pre-book (within 2 hours) before Checking In.</p> ';
?>
<br>  

<button onClick="Functionreload()">Refresh page</button>




  </td>
  </tr>
   <tr><td>
   
 <?php 

   
	}
 


else {
	header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
	}
	
	
	
function cmp($a, $b) {
        return $a[0] - $b[0];
}
	
	
	
function checkeventori() {
//---------------------------------------------------------------------

global $service, $Cal_ori, $Cal_current, $now;
//$vnow=date(DATE_ATOM);
$eventsO = $service->events->listEvents($Cal_ori);
//$eventsC = $service->events->listEvents($Cal_current);


unset($arrayori);
 date_default_timezone_set("Europe/London");
	

while(true)
{
 foreach($eventsO->getItems() as $eventori)
 {
  $startori = $eventori->getStart()->getDateTime();
  $endori = $eventori->getEnd()->getDateTime();
  $IDori = $eventori->getId();
  $attendori_arr = $eventori->getattendees();
  $location=$eventori->getdescription();
  
  $emailori= $attendori_arr[0]->email;
  $buddynameori= $eventori->getsummary(); 
 
 	//echo $startori;
	//echo $now;
	//echo $endori;
	//echo $emailori;
	 if (($endori > $now) && ($_SESSION['user_email']==$emailori)){   //(($startori < $now) && ($endori > $now)){

	//echo 'put array'.$startori;
   $arrayori[]=(array($startori,  $endori,  $buddynameori, $emailori, $IDori,$location));}
	  
 } //End of foreach 
 
 $pageToken = $eventsO->getNextPageToken();
 
 
 if($pageToken)
 {
  $optParametrers = array(‘pageToken’=>$pageToken);
  $eventsO = $service->events->listEvents($Cal_ori, $optParameters);
 }
 else
  break;
} 
//var_dump($arrayori); //End of while-------------------------------
return $arrayori;
}



// get ID of current---------------------------------------------------------------
function checkeventcurrent(){
	global $now, $service, $Cal_ori, $Cal_current;
$eventsC = $service->events->listEvents($Cal_current);


unset($arraycurrent);
while(true)
{
 foreach($eventsC->getItems() as $eventcurrent)
 {
  $startcurrent = $eventcurrent->getStart()->getDateTime();
  $endcurrent = $eventcurrent->getEnd()->getDateTime();
  $IDcurrent = $eventcurrent->getid();
  $location = $eventcurrent->getdescription();
  $attendcurrent_arr = $eventcurrent->getattendees();
  $emailcurrent= $attendcurrent_arr[0]->email;
  $buddynamecurrent= $eventcurrent->getSummary();
  if  (($endcurrent > $now) && ($_SESSION['user_email']==$emailcurrent)){
     $arraycurrent[]=(array($startcurrent,  $endcurrent,  $buddynamecurrent, $emailcurrent, $location, $IDcurrent));
	 }
	 
	 //delete events in the past
	// if ($endcurrent < $now) {
	//	$eventcurrent =  $service->events->delete($Cal_current, $IDcurrent); 
	// }
	  
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
return $arraycurrent;
}





//remove line in arrayori if present in current---------------------------
function listori($arrayori,$arraycurrent) {


 for ($i = 0, $iterationi = count($arrayori); $i < $iterationi; $i++) {
     for ($j = 0, $iterationj = count($arraycurrent); $j < $iterationj; $j++) {

          if   ($arraycurrent[$j][3]== $arrayori[$i][3]){
			//  echo 'delete';
		  unset($arrayori[$i]);
	  }
  }
 }
 return $arrayori;
}	

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;}
	
	?>
 </td>


  </tr>
   </table> 
         <script>
function Functionreload() {
    window.location.href = window.location.href;
}
</script>  
</body>
</html>