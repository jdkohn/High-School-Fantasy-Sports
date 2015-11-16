<?php

include "createconnection.php";

$player = $_POST["player"];
$league = $_POST["league"];
$newpos = $_POST["newpos"];
$currPos = $_POST["currentposition"];

foreach ( $conn->query("SELECT * FROM joint where league='$league' AND player='$player'") as $row ) {

	$team = $row["team"];

}

if($newpos == 0) {

	$q = "SELECT * FROM joint WHERE league='$league' AND team='$team' AND currentPos='G'";
	$result = $conn->query($q);
	$rowcount=mysqli_num_rows($result);
	if($rowcount == 0 || $rowcount == 1) {
		$conn->query("UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player'");
	} else {
		foreach($conn->query($q) as $curr) {
			$otherP = $curr["player"];
			$conn->query("UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player'");
			$conn->query("UPDATE joint SET currentPos = '$currPos' WHERE joint.league='$league' AND joint.player='$otherP'");
			break;
		}
	}

} else if($newpos == 1) {
	$q = "SELECT * FROM joint WHERE league='$league' AND team='$team' AND currentPos='G'";
	$result = $conn->query($q);
	$rowcount=mysqli_num_rows($result);
	if($rowcount == 0 || $rowcount == 1) {
		$conn->query("UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player'");
	} else {
		$counter = 0;
		foreach($conn->query($q) as $curr) {
			if($counter == 1) {
				$otherP = $curr["player"];
				$conn->query("UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player'");
				$conn->query("UPDATE joint SET currentPos = '$currPos' WHERE joint.league='$league' AND joint.player='$otherP'");
			}
			$counter++;
		}
	}
} else if($newpos == 2) {
	$q = "SELECT * FROM joint WHERE league='$league' AND team='$team' AND currentPos='F'";
	$result = $conn->query($q);
	$rowcount=mysqli_num_rows($result);
	if($rowcount == 0 || $rowcount == 1) {
		$conn->query("UPDATE joint SET currentPos = 'F' WHERE joint.league='$league' AND joint.player='$player'");
	} else {
		foreach($conn->query($q) as $curr) {
			$otherP = $curr["player"];
			$conn->query("UPDATE joint SET currentPos = 'F' WHERE joint.league='$league' AND joint.player='$player'");
			$conn->query("UPDATE joint SET currentPos = '$currPos' WHERE joint.league='$league' AND joint.player='$otherP'");
			break;
		}
	}
} else if($newpos == 3) {
	$q = "SELECT * FROM joint WHERE league='$league' AND team='$team' AND currentPos='F'";
	$result = $conn->query($q);
	$rowcount=mysqli_num_rows($result);
	if($rowcount == 0 || $rowcount == 1) {
		$conn->query("UPDATE joint SET currentPos = 'F' WHERE joint.league='$league' AND joint.player='$player'");
	} else {
		$counter = 0;
		foreach($conn->query($q) as $curr) {
			if($counter == 1) {
				$otherP = $curr["player"];
				$conn->query("UPDATE joint SET currentPos = 'F' WHERE joint.league='$league' AND joint.player='$player'");
				$conn->query("UPDATE joint SET currentPos = '$currPos' WHERE joint.league='$league' AND joint.player='$otherP'");
			}
			$counter++;
		}
	}
} else if($newpos == 4) {
	$q = "SELECT * FROM joint WHERE league='$league' AND team='$team' AND currentPos='X'";
	$result = $conn->query($q);
	$rowcount=mysqli_num_rows($result);
	if($rowcount == 0) {
		$conn->query("UPDATE joint SET currentPos = 'X' WHERE joint.league='$league' AND joint.player='$player'");
	} else {
				foreach($conn->query($q) as $curr) {
				$otherP = $curr["player"];
				$otherPPos = $curr["position"];


				$conn->query("UPDATE joint SET currentPos = 'X' WHERE joint.league='$league' AND joint.player='$player'");
				if($currPos !== 'B') {
					if($otherPPos !== $currPos) {
						$conn->query("UPDATE joint SET currentPos = 'B' WHERE joint.league='$league' AND joint.player='$otherP'");
					}
				} else {
				$conn->query("UPDATE joint SET currentPos = '$currPos' WHERE joint.league='$league' AND joint.player='$otherP'");
				}
			}
		}

	} else if($newpos == 7) {
		$conn->query("UPDATE joint SET currentPos = 'B' WHERE joint.league='$league' AND joint.player='$player'");
	}




$conn->close();

?>
