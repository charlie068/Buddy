
	
	<?php    
if(isset($_POST['submit'])){ //check if form was submitted
  $input = $_POST['factorA']; //get input text
  echo ('Hello');
  $message = "Success! You entered: ".$input;
  
}    
echo "<div id='divwithform'>";

if (isset($_POST["SubmitButton"]))  // if form was submitted (if you came here with form data)
{
    echo "Success";
}
else                // if form was not submitted (if you came here without form data)
{
    echo "<form> ..gg. </form>";
} 

echo "</div>";
	
	

	$dir = (__DIR__."/configfolder/config.ini");

	$ini_array = parse_ini_file($dir, true);
	//print_r($ini_array['DEFAULT']['factor b']);
	$sm=$ini_array['DEFAULT']['set moisture %'];
	$offset=$ini_array['DEFAULT']['offset'];
	$factorA=$ini_array['DEFAULT']['factor a'];
	$factorB=$ini_array['DEFAULT']['factor b'];
	$minspeed=$ini_array['DEFAULT']['min motor speed'];
	$maxspeed=$ini_array['DEFAULT']['max motor speed'];
	$interval=$ini_array['DEFAULT']['reading interval'];
	$alertlow=$ini_array['DEFAULT']['limit alert low'];
	$alerthigh=$ini_array['DEFAULT']['limit alert high'];
	
	
	?>
	
	
   <!doctype html>
	<html>
		
	<head>
	<meta charset="utf-8">
	</head>
	
	
	<body>
		
		<h2>HTML Forms</h2>
	<form method="post" action=""> 	
	Set Moisture (%): <input type="text" name="sm" value="<?php echo $sm;?>"> <br>
	Offset: <input type="text" name="offset" value="<?php echo $offset;?>"> <br>
	factorA: <input type="text" name="factorA" value="<?php echo $factorA;?>"> <br>
	factorB: <input type="text" name="factorB" value="<?php echo $factorB;?>"> <br>
	minspeed: <input type="text" name="minspeed" value="<?php echo $minspeed;?>"> <br>
	maxspeed: <input type="text" name="maxspeed" value="<?php echo $maxspeed;?>"> <br>
	interval: <input type="text" name="interval" value="<?php echo $interval;?>"> <br>
	alertlow: <input type="text" name="alertlow" value="<?php echo $alertlow;?>"> <br>
	alerthigh: <input type="text" name="alerthigh" value="<?php echo $alerthigh;?>"> <br><br>
	          <input type="submit" value="SubmitButton">
	</form>
	
	
	
	</body>
	</html>