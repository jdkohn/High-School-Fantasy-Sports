<?php

include "createconnection.php";

$player = $_POST["player"];
$league = $_POST["league"];
$newpos = $_POST["newpos"];

foreach ( $conn->query("SELECT * FROM joint where league='$league' AND player='$player'") as $row ) {

	$team = $row["team"];

}

// if($newpos == 0) {

// 	$q = "SELECT * FROM joint WHERE league='$league AND team='$team' AND currentPos='G'";
// 	if ($conn->query($q) == TRUE) {
// 		$rowcount=mysqli_num_rows($result);
// 		if($rowcount == 0 || $rowcount == 1) {
// 			"UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player;"
// 		} else {
// 			foreach($conn->query($q) as $curr) {
// 				$otherP = $curr["player"];
// 				"UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player;"
// 				"UPDATE joint SET currentPos = 'B' WHERE joint.league='$league' AND joint.player='$otherP;"
// 				break;
// 			}
// 		}
// 	} else {
// 		echo "Error: " . $sql . "<br>" . $conn->error;
// 	}
// } else if($newPos == 1) {
// 	$q = "SELECT * FROM joint WHERE league='$league AND team='$team' AND currentPos='G'";
// 	if ($conn->query($q) == TRUE) {
// 		$rowcount=mysqli_num_rows($result);
// 		if($rowcount == 0 || $rowcount == 1) {
// 			"UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player;"
// 		} else {
// 			$counter = 0;
// 			foreach($conn->query($q) as $curr) {
// 				if($counter == 1) {
// 				$otherP = $curr["player"];
// 				"UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player;"
// 				"UPDATE joint SET currentPos = 'B' WHERE joint.league='$league' AND joint.player='$otherP;"
// 			}
// 				$counter++;
// 			}
// 		}
// 	} else {
// 		echo "Error: " . $sql . "<br>" . $conn->error;
// 	}
// }



$moveplayer = "UPDATE joint SET currentPos = 'G' WHERE joint.league='$league' AND joint.player='$player'";

if ($conn->query($moveplayer) == TRUE) {
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}


$conn->close();

?>
