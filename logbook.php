<?php require_once($_SERVER["DOCUMENT_ROOT"].'/login/config/config.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/logbook/recording.php');
   include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');  
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="css/default.css" media="all" rel="stylesheet" type="text/css" >

<LINK REL="shortcut icon" HREF="buddy_icon.ico">
 
    
    
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
   </head>

<body>
<table CLASS="tablewhite" >
  <tr class="bd1">
    <td  >
	
	<?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>

  </td>
 </tr>
<tr class="bd1" >
     <td   >
  
<? include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php');

?>

</td>
</tr>

    
      <tr>
    
  <td> 
  
   <?php

 
  // print_r($_SESSION);
   if ($_SESSION['user_logged_in']=='1') {
      //  session_start();
	  
		//echo $emailbuddy;
	  header("Cache-Control: no-cache, must-revalidate");
	  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");



$enregistre = new enregistre();
 $enregistre->booklist();
//$booklist->booklist();
// show potential errors / feedback (from login object)

if (isset($enregistre)) {
	
     
	?>
  		<div style="overflow-x:auto;">
	 	<table CLASS='tablelogbook'>
		<tr>
		 <th>First <br> Name</th>
		 <th>Last <br>Name</th>
		 <th>Group <br>Name</th>
		<th>Office<br> Number</th>
		 <th>Lab<br> Number</th>
		 <th>Start <br>time</th>
		 <th>End <br>time</th>
         <th>OUT <br>Confirmed</th>
		</tr>
		<?
        foreach ($enregistre->book_list as $ligne) {
        echo "<tr>\n";
		echo ("<td>".$ligne->entry_firstname."</td>\n");
		echo ("<td>".$ligne->entry_surname."</td>\n");
		echo ("<td>".$ligne->entry_group."</td>\n");
		echo ("<td>".$ligne->entry_office."</td>\n");
		echo ("<td>".$ligne->entry_lab."</td>\n");
		if ($ligne->entry_start!=null) {
			$start=(date('d-m-Y H:i', strtotime($ligne->entry_start)));
		}
		else $start=null;
		if ($ligne->entry_end!=null) {
		$end=(date('d-m-Y H:i', strtotime($ligne->entry_end)));}
		else $end=null;
		echo ("<td>".$start."</td>\n");
		echo ("<td>".$end."</td>\n");
		if ($ligne->entry_endconfirmed) {
			$conf="YES";}
			else 
			{
			$conf="NO";
			}
			echo ("<td>".$conf."</td>\n");
		echo "</tr>";
	
        }
			echo '</table>';
		
    }
   

?>
</div>
</td>


  </tr>
   </table> 
<?php	

}

else {
	header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
	}
?>	

</body>
</html>