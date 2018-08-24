
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
//require_once('login/config/config.php');
//require_once('login/translations/en.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/login/config/config.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/logbook/recording.php');

	//header("Cache-Control: no-cache, must-revalidate");
	//	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");



	?>
	<table CLASS="tablewhite">
	<tr class="bd1">
        <td>
     
        </td>
    </tr>
		
	<tr class="bd">
    
    	<td>
	 
	<?
	$confuser=$_GET["confuser"];
	
	if (!empty($confuser)) { 
		 $enregistreb = new enregistre();
		 if ($enregistreb->confirmuserout($confuser)) {
			 
		 ?>
         	 <span class="style2">Thank you to have confirmed your check out. You will be redirected in 5 seconds</span>
	<?
//	header( "refresh:5;url=http://bristolbuddy.x10host.com/index.php");
			
			}
			else
			{?>
				<span class="style2">Problem with the confirmation.</span>
				<? 
				
				
				}}
				Echo "</br>You will be redirected in 5 seconds.";
		 header( "refresh:5;url=http://bristolbuddy.x10host.com/index.php");
			  ?>
		</td>
		  
		  </tr>
		  
	   
	  
		</table>
</body>

</html>