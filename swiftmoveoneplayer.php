<?php

include "createconnection.php";

$newPos = mysqli_real_escape_string($conn, $_POST["position"]);
$league = mysqli_real_escape_string($conn, $_POST["league"]);
$player = mysqli_real_escape_string($conn, $_POST["player"]);

if($conn->query("UPDATE joint SET currentPos = '$newPos' WHERE joint.league='$league' AND joint.player='$player'") == TRUE) {
	echo "UPDATE joint SET currentPos = '$newPos' WHERE joint.league='$league' AND joint.player='$player'";
} else {
	echo "failure";
}

$conn->close();

?>
