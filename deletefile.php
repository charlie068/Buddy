<?php 
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
   if (($_SESSION['user_logged_in']==true) and ($_SESSION['isadmin']==true)) 
  
  { 
$files = glob('uploads/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
	
	Echo 'Files Deleted';
}
 Echo "</br>You will be redirected in 5 seconds.";
 header( "refresh:5;url=http://bristolbuddy.x10host.com/adminpage.php");}
 ?>