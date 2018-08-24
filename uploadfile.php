<?php 
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
  if (($_SESSION['user_logged_in']==true) and ($_SESSION['isadmin']==true)) 
  
  { 
$target_dir = "uploads/";
$target_file = $target_dir . 'message.txt';

  
if (isset($_POST['field1']) && isset($_POST['field2'])) {
    $data = $_POST['field1'] . '-' . $_POST['field2'] . "\n";
    $ret = file_put_contents($target_file, $data, LOCK_EX);
    if($ret === false) {
        die('There was an error writing the file');
    }
    else {
        echo "$ret bytes written to file";
    }
}
else {
   die('no post data to process');
}
 
  }
  Echo "</br>You will be redirected in 5 seconds.";
  header( "refresh:5;url=http://bristolbuddy.x10host.com/adminpage.php");
?> 
 