<?php

$player = $_POST["player"];
$team = $_POST["team"];
$league = $_POST["league"];

include "createconnection.php";

$addplayer = "UPDATE joint SET team='$team' WHERE joint.player='$player' AND joint.league='$league'";
$conn->query($addplayer);
$changepos = "UPDATE joint SET currentPos='B' WHERE joint.player='$player' AND joint.team='$team'";
$conn->query($changepos);
$draftplayer = "INSERT INTO draft (league, team, player) VALUES ('$league','$team','$player')";
if($conn->query($draftplayer) == FALSE) {
	echo "oopsies";
} 

$conn->close();
?>
