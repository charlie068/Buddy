
<?php
    session_start();

    $echoedShout = "";

    if(count($_POST) > 0) {
        $_SESSION['shout'] = $_POST['shout'];

        header("HTTP/1.1 303 See Other");
  header("Location: " . $_SERVER['REQUEST_URI']);
        die();
    }
    else if (isset($_SESSION['shout'])){
        $echoedShout = $_SESSION['shout'];

        /*
            Put database-affecting code here.
        */

        session_unset();
        session_destroy();
    }
?>

<!DOCTYPE html>
<html>
<head><title>PRG Pattern Demonstration</title>
</head>
<body>
    <?php echo "<p>$echoedShout</p>" ?>
    <form action="prgtest.php" method="POST">
        <input type="text" name="shout" value="" />
    </form>
</body>
</html>