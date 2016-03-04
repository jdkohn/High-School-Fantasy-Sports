<?php
include "createconnection.php";

$player = $_POST["player"];
$team = $_POST["team"];
$league = $_POST["league"];
$lastPickTime = $_POST["time"];
$isCommish = $_POST['commish'];
$time = time();

$player = mysqli_real_escape_string($conn, $player);
$team = mysqli_real_escape_string($conn, $team);
$league = mysqli_real_escape_string($conn, $league);

include "createconnection.php";


$numOutfielders = 0;
$numInfielders = 0;
$numFlex = 0;
foreach($conn->query("SELECT * FROM joint WHERE team='$team'") as $pp) {
	if($pp["currentPos"] == 'O') {
		$numOutfielders++;
	}
	if($pp["currentPos"] == 'I') {
		$numInfielders++;
	}
	if($pp["currentPos"] == 'X') {
		$numFlex++;
	}
}

echo $numOutfielders . " outfielders, " . $numInfielders . " infielders, " . $numFlex . " flex.";

echo "</br>";

$playerPos = '';
foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$player'") as $pp) {
	$playerPos = $pp['position'];
}

$teamPosition = '';
if($playerPos == 'O' && $numOutfielders == 2) {
	$teamPosition = 'X';
	echo "X";
} else if($playerPos == "O" && $numOutfielders != 2) {
	$teamPosition = "O";
	echo "O";
} else if($playerPos == "I" && $numInfielders == 3) {
	$teamPosition = "X";
	echo "X";
} else {
	$teamPosition = "I";
	echo "I";
}


if(($time - $lastPickTime) < 63) {
	$addplayer = "UPDATE joint SET team='$team' WHERE joint.player='$player' AND joint.league='$league'";
	$conn->query($addplayer);
	$changepos = "UPDATE joint SET currentPos='$teamPosition' WHERE joint.player='$player' AND joint.team='$team'";
	$conn->query($changepos);
	$draftplayer = "INSERT INTO baseballdraft (league, team, player, time) VALUES ('$league','$team','$player', '$time')";
	if($conn->query($draftplayer) == FALSE) {
		echo "oopsies";
	}
} else if($isCommish == 1) {
	foreach($conn->query("SELECT * FROM joint WHERE league='$league' AND team='0' AND currentPos='N'") as $player) {
		$playerID = $player['player'];

		$addplayer = "UPDATE joint SET team='$team' WHERE joint.player='$playerID' AND joint.league='$league'";
		$conn->query($addplayer);
		$changepos = "UPDATE joint SET currentPos='$teamPosition' WHERE joint.player='$playerID' AND joint.team='$team'";
		$conn->query($changepos);
		$draftplayer = "INSERT INTO baseballdraft (league, team, player, time) VALUES ('$league','$team','$playerID', '$time')";
		if($conn->query($draftplayer) == FALSE) {
			echo "oopsies";
		}
		break;
	}
}

$conn->close();
?>
