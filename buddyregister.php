<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bristol Buddy System</title>
<link href="css/default.css" media="all" rel="stylesheet" type="text/css" >
<LINK REL="shortcut icon" HREF="buddy_icon.ico">
    <link href="./css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="./css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <style type="text/css">
        /* just for the demo */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        label2 {
            position: relative;
            vertical-align: middle;
            bottom: 1px;
        }
        input[type=text],
        input[type=password],
        input[type=submit],
        input[type=email] {
            display: block;
            margin-bottom: 15px;
        }
        input[type=checkbox] {
            margin-bottom: 15px;
        }
    </style>
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

// load the registration class
require_once('login/classes/Registration.php');

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();

// showing the register view (with the registration form, and messages/errors)
include("login/views/register.php");
?>
</td>
</tr>
</table>

</body>

</html>