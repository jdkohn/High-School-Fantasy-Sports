<?php

session_start();

include 'createconnection.php';

$owner = $_SESSION["id"];
$teamname = "Team " . $_SESSION["firstname"];
$leaguenum = $_POST["leaguenum"];
$password = $_POST["password"];
$addteam = "";

if($password == "9q4fd6bppl04s") {

	$addteam = "INSERT INTO teams (owner, name, league) VALUES ('$owner', '$teamname', '$leaguenum')";

} else {
	$sql = "SELECT * FROM leagues WHERE id='$leaguenum'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		 // output data of each row
		while($row = $result->fetch_assoc()) {
			if($password == $row["password"]) {
				$addteam = "INSERT INTO teams (owner, name, league) VALUES ('$owner', '$teamname', '$leaguenum')";
			} else {
				break;
			}
		}
	}
}

if ($conn->query($addteam) == TRUE) {
	echo '<script type="text/javascript">alert("Your team has been added!");</script>';
} else {
	echo "Error: " . $addteam . "<br>" . $conn->error;
}
$conn->close();
?>
