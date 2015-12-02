<?php

include "createconnection.php";

$id = $_POST["playerid"];
$teamplayers = $_POST["numplayers"];
$teamnum = $_POST["teamnum"];

$id = mysqli_real_escape_string($conn, $id);
$teamplayers = mysqli_real_escape_string($conn, $teamplayers);
$teamnum = mysqli_real_escape_string($conn, $teamnum);


if($teamplayers < 7) {
	if($conn->query("UPDATE joint SET team ='$teamnum' WHERE joint.player= '$id'") == TRUE) {
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	if($conn->query("UPDATE joint SET currentPos='B' WHERE joint.player='$id'") == TRUE) {
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

$conn->close()
?>
