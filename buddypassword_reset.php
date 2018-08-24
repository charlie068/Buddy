<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
    <link href="./css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
</head>

<body>

<table  CLASS="tablewhite">
  <tr class="bd">
    <td >

  </td></tr>
<tr class="bd">
     <td    >
	 
	 <?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('login/libraries/password_compatibility_library.php');
}
// include the config
require_once('login/config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('login/translations/en.php');

// include the PHPMailer library
require_once('login/libraries/PHPMailer.php');

// load the login class
require_once('login/classes/Login.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();

// the user has just successfully entered a new password
// so we show the index page = the login page
if ($login->passwordResetWasSuccessful() == true && $login->passwordResetLinkIsValid() != true) {
    include("login/views/not_logged_in.php");

} else {
    // show the request-a-password-reset or type-your-new-password form
    include("login/views/password_reset.php");
}
?>
</td>
</tr>
</table>

</body>

</html>