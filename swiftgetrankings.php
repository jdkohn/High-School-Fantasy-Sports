<?php

include "createconnection.php";

$playerNames = array();
$schoolNames = array();
$averagePoints = array();
$rankings = array();

foreach($conn->query("SELECT * FROM players") as $player) {
	$id = $player["id"];
	$name = $player["name"];
	$school = $player['school'];

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
		}
	}
}

array_multisort($averagePoints, SORT_DESC, $playerNames, $schoolNames, $rankings);

for($i=0; $i<count($averagePoints); $i++) {
	echo $playerNames[$i];
	echo "*";
	echo $averagePoints[$i];
	echo "*";
	echo $schoolNames[$i];
	echo "&";
}


?>

