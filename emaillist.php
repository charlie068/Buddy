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
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
  if (($_SESSION['user_logged_in']==true) and ($_SESSION['isadmin']==true)) 
  
  { 

?>


<table  CLASS="tablewhite">
  <tr class="bd1">
    <td colspan="2" ><?php	include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/topmenu.php'); ?>

  </td></tr>

	 <tr class="bd1">
      <td   colspan="2" >
	<?
       include ($_SERVER["DOCUMENT_ROOT"].'/phpfiles/menu.php'); 
      ?>    
      

</td></tr>

		<tr class="bd1">
		<td colspan="2">

<?php
$servername = "localhost"; // Most likely 'localhost', so you don't need to change this in most of cases
$username = "bristolb_admin"; // Your MySQL username
$password = "bristolbuddydbpass?"; // Your MySQL password
$dbname = "bristolb_buddydb"; // Your MySQL database name




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT first_name, last_name, user_email, user_is_approved, user_active, group_name, office,	labnum  FROM users ORDER BY last_name ASC";
$result = $conn->query($sql);
$emaillist='';
if ($result->num_rows > 0) {
	echo "Total subscribed: ".$result->num_rows. " <br><br>";
    // output data of each row
	?>
	
	 	<table CLASS='tablelogbook'>
        
		<tr>
             <th>Last <br>Name</th>
             <th>First <br> Name</th>
             <th>User <br>email</th>
             <th>Group <br>Name</th>
             <th>Office<br> Number</th>
             <th>Lab<br> Number</th>
             <th>User<br> active</th>
             
        </tr>
        <?
    while($row = $result->fetch_assoc()) {
		
			
		echo "<tr>\n";
		echo ("<td>".$row["last_name"]."</td>\n");
		echo ("<td>".$row["first_name"]."</td>\n");
		echo ("<td>".$row["user_email"]."</td>\n");
		echo ("<td>".$row["group_name"]."</td>\n");
		echo ("<td>".$row["office"]."</td>\n");
		echo ("<td>".$row["labnum"]."</td>\n");
		if (($row["user_is_approved"]==true) and( $row["user_active"])==true)
		{
			echo ("<td>Yes</td>\n");}
			else
			echo ("<td>No</td>\n");
		echo "</tr>";
	 
		$emaillist .=$row["user_email"].',';
    } 
	?>
	
    </table>
    </td>
</tr>
<tr>
<td>
<?
	$emaillist = rtrim($emaillist, ',');
	
	echo '<br><a href="mailto:no-reply@bristolbuddy.x10host.com?bcc='.$emaillist.'">Send email to all</a>';
	
} 

else {
    echo "0 results";
}
$conn->close();
echo'	</td>
	  
	  </tr>
	</table>';
}

Else {
	 ?>
	
	<span class="style2"> Please Login </span>  
	</td></tr>
	<tr  class="bd">
     <td  >
     <?php
	include($_SERVER["DOCUMENT_ROOT"].'/login/views/not_logged_in.php');
	echo '
	</td>
	  
	  </tr>
	</table>';
	
	}
?>


</body>
</html>