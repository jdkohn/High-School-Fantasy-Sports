<?php

include "createconnection.php";

$league = $_POST['league'];

$playerNames = array();
$schoolNames = array();
$averagePoints = array();
$rankings = array();
$positions = array();

foreach($conn->query("SELECT * FROM players") as $player) {
	$id = $player["id"];
	$name = $player["name"];
	$school = $player['school'];
	$position = $player['position'];

	$total = 0;
	$counter = 0;
	foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $statline) {
		$total = $total + $statline['total'];
		$counter++;
	}
	if($counter != 0) {
		if($total != 0) {
			$total = $total / $counter;
			array_push($rankings, $id);
			array_push($playerNames,$name);
			array_push($schoolNames, $school);
			array_push($averagePoints, $total);
			array_push($positions, $position);
		}
	}
}

array_multisort($averagePoints, SORT_DESC, $playerNames, $schoolNames, $rankings, $positions);


for($i=0; $i<count($averagePoints); $i++) {
	$player = $rankings[$i];
	foreach($conn->query("SELECT * FROM joint WHERE league='$league' AND player='$player'") as $item) {
		if($item['team'] == 0) {
			echo $playerNames[$i];
			echo "*";
			echo $averagePoints[$i];
			echo "*";
			echo $rankings[$i];
			echo "*";
			echo $positions[$i];
			echo "&";
		}

	}
}


?>
