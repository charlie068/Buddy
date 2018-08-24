<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php



function calendarize ($title, $desc, $ev_date, $cal_id) {



    session_start();



    /************************************************

    Make an API request authenticated with a service

    account.

    ************************************************/

    set_include_path( '../google-api-php-client/src/');



    require_once 'Google/Client.php';

    require_once 'Google/Service/Calendar.php';



    //obviously, insert your own credentials from the service account in the Google Developer's console

    $client_id = '1006125801648-nqp3dh548nupick91jnpkbv7hm63252g.apps.googleusercontent.com';

    $service_account_name = '1006125801648-nqp3dh548nupick91jnpkbv7hm63252g@developer.gserviceaccount.com';

    $key_file_location = 'LSBbuddy-1f47bf5e4a2d.p12';



    if (!strlen($service_account_name) || !strlen($key_file_location))

        echo missingServiceAccountDetailsWarning();



    $client = new Google_Client();

    $client->setApplicationName("BristolBuddy App");



    if (isset($_SESSION['service_token'])) {

        $client->setAccessToken($_SESSION['service_token']);

    }



    $key = file_get_contents($key_file_location);

    $cred = new Google_Auth_AssertionCredentials(

        $service_account_name, 

        array('https://www.googleapis.com/auth/calendar'), 

        $key

    );

    $client->setAssertionCredentials($cred);

    if($client->getAuth()->isAccessTokenExpired()) {

        $client->getAuth()->refreshTokenWithAssertion($cred);

    }

    $_SESSION['service_token'] = $client->getAccessToken();



    $calendarService = new Google_Service_Calendar($client);

    $calendarList = $calendarService->calendarList;



    //Set the Event data

    $event = new Google_Service_Calendar_Event();

    $event->setSummary($title);

    $event->setDescription($desc);



    $start = new Google_Service_Calendar_EventDateTime();

    $start->setDateTime($ev_date);

    $event->setStart($start);



    $end = new Google_Service_Calendar_EventDateTime();

    $end->setDateTime($ev_date);

    $event->setEnd($end);



    $createdEvent = $calendarService->events->insert($cal_id, $event);



    echo $createdEvent->getId();

} 



?>
</body>
</html>