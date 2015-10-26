<?php

include "header.php";

echo "<br><br>";

?>

<html>
<style>

.error {
	color: #FF0000;
}

p {
	font-size: 18px;
	font-family: verdana;
}
h1 {
	font-size: 36px;
	font-family: verdana;
}

input.CreateButton {
width: 120px;
height: 35px;
padding: 5px;
font-weight: bold;
font-size: 90%;
background: green;
color: white;
cursor: pointer;
border: 1px solid white;

}
input.CreateButton:hover {
color: green;
background: white;
border: 1px solid #000033;
}
</style>


<?php
// define variables and set to empty values
$nameErr = $numTeamsErr = $draftDateErr = $passErr = "";
$name = $numTeams = $draftDate = $pass = "";
$nameSet = $numTeamsSet = $draftDateSet = $passSet = $passNeeded = FALSE;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["leaguename"])) {
     $nameErr = "League Name is required";
   } else {
     $name = test_input($_POST["leaguename"]);
     $nameSet = TRUE;
   }
   if (empty($_POST["numteams"])) {
     $numTeamsErr = "Number of Teams is required";
   } else {
     $numTeams = test_input($_POST["numteams"]);
     $numTeamsSet = TRUE;
   }

   if (empty($_POST["drafttime"])) {
     $draftDateErr = "Draft Time is required";
   } else {
     $draftDate = test_input($_POST["drafttime"]);
     $draftDateSet = TRUE;
   }
   if(strcmp($_POST["private"], "yes") == 0) {
   		$passNeeded = TRUE;
	   if($_POST["password"]) {
	    $passErr = "Password is required";
	    echo "Password is required";
	   } else {
	    $pass = test_input($_POST["password"]);
	    $passSet = TRUE;
	   }
	}

	if(empty($_POST["drafttime"])) {
		$draftDateErr = "Draft date is required";
	} else {
		$draftDate = $_POST["drafttime"];
    $draftDay = substr($draftDate,0,10);
    $draftTime = " " . substr($draftDate,11) . ":00";
    $draftDate = $draftDay . $draftTime;
	}

	echo $_POST["drafttime"] . "<br>";
  echo $draftDate . "<br>";

	



   if($nameSet && $numTeamsSet && $draftDateSet) {
      $servername = "localhost";
      $username = "hsfantasyball";
      $password = "2016";
      $dbname = "fantasyball";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 

     $usr = $_SESSION["username"];
	   $ssql = "SELECT * FROM users WHERE username='$usr'";

		 $result = $conn->query($ssql);

     if ($result->num_rows > 0) {
     // output data of each row
      while($row = $result->fetch_assoc()) {
        $commissioner = $row["id"];
      }
		 } else {
		    header( 'Location: login.php');
		 }

      if($passNeeded) {
      	$sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate, password)
      	VALUES ('$name', '$numTeams', '$commissioner', '$draftDate', '$pass')";
      }

      $sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate)
      VALUES ('$name', '$numTeams', '$commissioner', '$draftDate')";

      if ($conn->query($sql) == TRUE) {
          header( 'Location: home.php' );
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close(); 
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('input[name=private]').on('change', function(){
    var n = $(this).val();
    switch(n)
    {
            case 'yes':
                  $('#show').html("You have chosen to make your league private. Enter a password below.<br> This password must be used to join the league.<br><input type=\"text\" name=\"password\"><span class=\"error\">* <?php echo $passErr;?></span>");
                  break;
            case 'no':
            	$('#show').html("Your league is not password protected. Anyone can join this league.");
                  break;
        }
    });
});
</script>

<h1>Create League</h1>
<p>
	<span class="error">* required field</span>
<form class="blocktext" method="post">
  League Name:<br>
  <input type="text" name="leaguename">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Number of Teams: 
  <select name="numteams">
  	<option value=""></option>
  	<option value="2">2</option>
  	<option value="4">4</option>
  	<option value="6">6</option>
  	<option value="8">8</option>
  	<option value="10">10</option>
  </select>
  <span class="error">* <?php echo $numTeamsErr;?></span>
  <br><br>
  Draft date and time: <input type="datetime-local" name="drafttime">
  <span class="error">* <?php echo $draftDateErr;?></span>
  <br><br>Private:
Yes<input type="radio" name="private" value="yes"><a>	</a>No
<input type="radio" name="private" value="no" checked="checked"><br>
<div id='show'> 
	Your league is not private, anyone can join your league
</div>
<a href="www.espn.go.com"><input class="CreateButton" type="submit" value="Create" /></a>
</p>
</form>


</html>



