<?php 
$target_dir = "log/";
$target_file = $target_dir . 'log.txt';

  date_default_timezone_set("Europe/London");
		
 
    $data = date('l jS \of F Y h:i A') . '  ----> ' . $_SESSION['user_email'] . "\n";
    $ret = file_put_contents($target_file, $data, LOCK_EX | FILE_APPEND);
  
 


?> 