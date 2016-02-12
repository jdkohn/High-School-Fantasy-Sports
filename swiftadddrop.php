<?php

include "createconnection.php";

$playerToAdd = $_POST["add"];
$playerToDrop = $_POST["drop"];
$league = $_POST["league"];
$team = $_POST["team"];

$conn->query("UPDATE joint SET team='0' WHERE joint.league='$league' AND joint.player='$playerToDrop'");
$conn->query("UPDATE joint set currentPosition='N' WHERE joint.league='$league' AND joint.player='$playerToDrop'");

$conn->query("UPDATE joint SET team='$team' WHERE joint.league='$league' AND joint.player='$playerToAdd'");
$conn->query("UPDATE joint set currentPos='B' WHERE joint.league='$league' AND joint.player='$playerToAdd'");

$conn->close()
?>