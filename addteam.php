<?php

session_start();

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

$owner = $_SESSION["id"];
$teamname = "Team " . $_SESSION["firstname"];
$leaguenum = $_POST["leaguenum"];

$addteam = "INSERT INTO teams (owner, name, league) VALUES ('$owner', '$teamname', '$leaguenum')";

if ($conn->query($addteam) == TRUE) {
    header( 'Location: home.php' );
} else {
	echo "Error: " . $addteam . "<br>" . $conn->error;
}

?>
