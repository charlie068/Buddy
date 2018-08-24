
<?php




$target_file = './uploads/message.txt';

if (file_exists($target_file)) {
	$data=file_get_contents($target_file);
	echo '<tr class="bd1"><td colspan=2 >   <span class="style9">'.  strstr($data,"-", true) .'</span>  ';
    echo '  <span class="style2">'.  substr(strstr($data,"-"),1) .'</span> ';
	
	$files1 = array_diff(scandir('./uploads/'), array('..', '.','message.txt'));
	$files1 = array_values(array_filter($files1));
	if (!empty($files1)){
	echo '<p> Please download the following file for more informations ';
	foreach ($files1 as $key => $filename) {
		
		echo '<a href=./uploads/'.$filename.' download='.$filename.'>   Download File '.($key+1).'  </a>';}
	echo '</p>';}
	
	 echo '</td></tr>';
} 

//else {
  //  echo " <tr  ><td colspan=2 > The file $filename does not exist</td></tr>>";
//}



