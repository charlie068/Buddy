<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Bristol Buddy System</title>
<link href="./css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">

</head>

<body>
<?php

 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');

 ?>
 
 
 
<table  CLASS="tablewhite">
  <tr class="bd1">
    <td > <?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>

  </td></tr><tr  class="bd1">
     <td>
   <?php
 if ($_SESSION['user_logged_in']=='1') {
	 
	 
	 include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php');
?></td>
    
  </tr>

  <tr class="bd"> 
  <td>
  

	
	<span class="style9"> How do buddies need to use these webpages: </span>
	
	
<p>In order to make aware others when you plan to be in LSB, you go to the booking page "booking", enters the location and time when you will be in the LSB and click the button book. Your name will appear on the week calendar on the right.</p> 
<p>When you want to notify others that you are inside the LSB building and act as a buddy, you go on the "current" page and click "Check in". Your name will appear from the day calendar shown on the left. </p>
<p>When the buddy wants to notify others that you left the LSB building, you go on the "current" page, and click "check out" button. You name will disappear from the day calendar shown on the left. If you are one of the last two, you have to tell the other last one that you are leaving the building before you click "check out".</p>
<p>Workers can see who is in and look at the buddies information (location and email) if required (click the name on the calendar>more details>email guest).</p>

<p class="style3">Properties:</p>
 Once the booking is "in the past":</br>
  - your entries will be automatically deleted from the calendars.</br>
  - no booking information is retained on the server. </br>
 A maximum booking of 12 hours is currently allowed. </br>
 You can check in within 2 hours of the booking start time.
 <p class="style3">Feedbacks:</p>
 Your feedbacks will be useful to improve the tool. Email us: admin(at)bristolbuddy.x10host.com
 

 
 
 
 


<?php }
  
 else {
	header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
	
 }
 ?>
  </td>
  </tr>
  
   
  
</table>

</body>

</html>