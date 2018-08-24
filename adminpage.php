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
        </td>

</td></tr>

<tr class="bd"> <td colspan="2"  >
 
  
 <p><span class="style3">Enter a title and a short text</span></p>
 <p>They will be shown on the bristolbuddy webpage</p>
 <br>
 
<form action="uploadfile.php" method="POST">
  <input name="field1" type="text" Value="Title"  size="50" maxlength="45"/> <br>
    <TEXTAREA name="field2" type="text" ROWS="2" COLS="100" maxlength="200">
Please enter your special instructions (200 characters maximum) </TEXTAREA><br>
    <input type="submit" name="submit" value="Save Message"> <input type="reset" value="Reset!"><br>
</form>
</td></tr>



<tr class="bd"> <td colspan="2" >

  <p><span class="style3">Select a file to upload</span></p>
  <p> Choose a File (text of image) to be available to download </p>
  
<form action="upload.php" method="post" enctype="multipart/form-data">
  
    <input type="file" name="fileToUpload" id="fileToUpload"> 
    
    <input type="submit" name="submit" value="Upload File">
    
    <input type="reset" value="Reset!">
</form>

  <tr class="bd"> <td colspan="2" >
<p><span class="style3">Click here if you want to delete the file and the message</span></p><br>
<form action="deletefile.php" method="post">
  
  <input type="submit" value="Delete text and attached files" name="submit">
</form>
</td></tr>



 <tr class="bd"> <td colspan="2" >
<p><span class="style3">Click here to obtain the email list of users </span></p><br>
<form action="emaillist.php" method="post">
  
  <input type="submit" value="Email List" name="submit">
</form>
</td></tr>
<tr class="bd"> <td colspan="2">

<span class="style3"><a href="./logbook.php">Click here to see the log book </a></span><br>


</td></tr>

<tr class="bd"> <td colspan="2" >
<p><span class="style3">Click here to obtain the log of connection </span></p><br>




<form action="buddylogging.php" method="post">

  <input type="submit" value="Log List" name="list">
  <input type="submit" value="Delete Log List" name="delete_list">
</form>
</td></tr>
  

  <? } else 
   {
	header( 'Location: http://bristolbuddy.x10host.com/index.php' ) ;
	}
	
	  ?>
</td>
  
  </tr>
  
   
  
</table>
</body>

</html>