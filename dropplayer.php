<?php

include "createconnection.php";

$playerToDrop = $_POST['player'];
$playerToAdd = $_POST['playerToAdd'];
$league = $_POST['league'];
$team = $_POST['team'];

$addPlayer = "UPDATE joint SET team='$team' WHERE joint.player = '$playerToAdd' AND league='$league'";
$changePos = "UPDATE joint SET currentPos = 'B' WHERE joint.player='$playerToAdd' AND league='$league'";
$conn->query($addPlayer);
$conn->query($changePos);

$dropPlayer = "UPDATE joint SET team='0' WHERE joint.player = '$playerToDrop' AND league='$league'";
$removePos = "UPDATE joint SET currentPos = 'N' WHERE joint.player='$playerToDrop' AND league='$league'";
$conn->query($dropPlayer);
$conn->query($removePos);

$conn->close();
?>
