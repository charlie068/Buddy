<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="./css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
 
</head>

<body>
<?php

	 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');

require_once('login/config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('login/translations/en.php');

// include the PHPMailer library
require_once('login/libraries/PHPMailer.php');

// load the login class
require_once('login/classes/Login.php');


//$login = new Login();

// ... ask if we are logged in here:
//if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   
 if ($_SESSION['user_logged_in']=='1') { 
	
 ?>
<table  CLASS="tablewhite">
  <tr class="bd1">
    <td colspan="2" > <?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>

  </td></tr>
<tr  class="bd1">
     <td   colspan="2" >
	 <?php
     //print_r($_SESSION);
     if ($_SESSION['user_logged_in']=='1') { 
	 
	  include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php');
?>
        </td>
        </tr> 
		
		<?php
       	include ("showimage.php");		
	
		 ?>       
   <tr class="bd"> 
        <td >
 <?php include("login/views/update.php");
  ?>
	  
    </td>
       <td  align="right">
   
       </td>
       </tr>
      
       
      
    </table> 
    
    <script>
    function Functionreload() {
        window.location.href = window.location.href;
    }
    </script> }
     <?php

}

else {
	 ?>
	
	<span class="style2"> Please Login </span>  
	</td></tr>
	<tr  class="bd">
     <td   colspan="2" >
     <?php
	include($_SERVER["DOCUMENT_ROOT"].'/login/views/not_logged_in.php');
	echo '
	</td>
	  
	  </tr>
	</table>';}}
	
	


?>
</body>

</html>