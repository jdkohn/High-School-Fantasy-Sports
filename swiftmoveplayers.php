<?php

include "createconnection.php";

$p1 = mysqli_real_escape_string($conn, $_POST['playerOne']);
$p2 = mysqli_real_escape_string($conn, $_POST['playerTwo']);
$league = mysqli_real_escape_string($conn, $_POST['league']);

$p1CurrentPos = "N";
$p1pos = "N";

foreach($conn->query("SELECT * FROM joint WHERE league='$league' AND player='$p1'") as $p) {
	$p1CurrentPos = $p['currentPos'];
}
foreach($conn->query("SELECT * FROM players WHERE id='$p1'") as $l) {
	$p1pos = $l['position'];
}

$p2CurrentPos = "N";
$p2pos = "N";

foreach($conn->query("SELECT * FROM joint WHERE league='$league' AND player='$p2'") as $a) {
	$p2CurrentPos = $a['currentPos'];
}
foreach($conn->query("SELECT * FROM players WHERE id='$p2'") as $q) {
	$p2pos = $q['position'];
}

$conn->query("UPDATE joint SET currentPos='$p2CurrentPos' WHERE joint.league='$league' AND joint.player='$p1'");


if($p2CurrentPos == 'X') {
	if($p2pos != $p1pos) {
		$conn->query("UPDATE joint SET currentPos='B' WHERE joint.league='$league' AND joint.player='$p2'");
	} else {
		$conn->query("UPDATE joint SET currentPos='$p1CurrentPos' WHERE joint.league='$league' AND joint.player='$p2'");
	}
} else {
	$conn->query("UPDATE joint SET currentPos='$p1CurrentPos' WHERE joint.league='$league' AND joint.player='$p2'");
}

$conn->close()
?>
