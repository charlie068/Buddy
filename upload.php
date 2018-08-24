<?php 
 include ($_SERVER["DOCUMENT_ROOT"].'/isregistered.php');
   if (($_SESSION['user_logged_in']==true) and ($_SESSION['isadmin']==true)) 
  
  { 
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br/>\n ";
    $uploadOk = 0;
}
// Allow certain file formats
if(strtolower($FFileType) != "jpg" && strtolower($FFileType) != "pdf" && strtolower($FFileType) != "jpeg"
&& strtolower($FFileType) != "doc" && strtolower($FFileType) != "docx"  && strtolower($FFileType) != "txt"
&& strtolower($FFileType) != "xls" && strtolower($FFileType) != "xlsx" ) {
    echo "Sorry, only TXT, JPG, JPEG, PDF, XLS, XLSX, DOC & DOCX files are allowed. <br/>\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.  ";
    } else {
        echo "Sorry, there was an error uploading your file.<br/>\n ";
    }
}
Echo "</br>You will be redirected in 5 seconds.";
 header( "refresh:5;url=http://bristolbuddy.x10host.com/adminpage.php");}
?> 
 