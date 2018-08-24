<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">

</head>

<body>
<?php


 
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
//include($_SERVER["DOCUMENT_ROOT"].'/login/views/logged_in.php');
 
 ?>
 
 
 
<table  CLASS="tablewhite">
  <tr class="bd1">
    <td ><?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>

  </td></tr><tr  class="bd1">
     <td>
   <?php
 if ($_SESSION['user_logged_in']=='1') {
	
	 
	 
include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php');
?>

</td>
    
  </tr>

  <tr class="bd"> 
  
   <td align="center"><p>&nbsp;</p>
    <img src="Images/OOH access.jpg" width="840" height="495" alt="scheme access" />
    <br />
	<p><strong>Life sciences Building
Out of hours working policy </strong></p>

<p> Out of hours working is permitted for operational reasons provided users of the building comply with University and Life Sciences building Health & Safety guidelines. </p>
<p>All staff and students should  endeavour to limit their work in the Life Sciences building to  normal working hours or when there is a porter on duty between 7am and 7pm Monday to Friday as immediate help may not be available in the event of an accident.   </p>
<p>It is the duty of all Research Supervisors to be aware of the work being undertaken by their students/postdocs and to ensure that out of hours work is properly regulated.</p>
<p>Out of hours working is based on risk assessments of the work being carried out. Only low to medium risk activities are permitted outside normal working hours. A buddy system based on a local buddy or remote buddy is in place to provide assistance to users in the event of a problem or emergency.</p>
<p><strong>Office based work</strong>
<p>Risks associated with office based work outside normal working hours (7am - 7 pm Monday to Friday) has been assessed as low.</p>
<p> The following rules apply outside of normal hours-
<p>Staff and Postgraduate students can work in offices provided the line manager/supervisor considers the individual to be competent.</p>
<p>Outside of normal hours, you must ensure that a competent person is acting as a buddy to provide assistance in the event of an emergency.</p>
<p>The buddy can be local or remote i.e. a friend, relative or colleague who is aware you are working in the building and has been provided with contact details of the Security Office.</p>
<p>Undergraduates are forbidden in the building unless a member of the academic staff of the School is present with them.</p>

<p><strong>Laboratory based work </strong></p>
<p>There are special risks from working in a laboratory in the School outside normal working hours (7 a.m. - 7 p.m. Monday to Friday). </p>
<p>The following rules apply outside of normal hours:-</p>
<p>LONE WORKING IN A LABORATORY IS FORBIDDEN. Lone working is regarded as a serious breach of School health and safety policy and will not be tolerated.</p>
<p>Outside of normal hours, you must ensure that a competent person is within the laboratory or associated write up area and is able to assist in the event of a problem. Out of hours working must also be subject to a risk assessment.</p>
<p>	Undergraduates are forbidden to be in laboratories unless a member of the academic staff of the School is present with them.</p>
<p>Experiments that involve any measure of high risk must be carried out within normal working hours. </p>

	<br>
	<br>
	
	
 </td>

  
  </tr>
  
  <? }
  
 else {
	header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
	
 }
 ?>
  </td>
  </tr>
  
   
  
</table>

</body>

</html>