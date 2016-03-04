<?php

$id = $player["id"];
$name = $player["name"];
$school = $player['school'];

$total = 0;
$counter = 0;
foreach($conn->query("SELECT * FROM baseballstats WHERE player='$id'") as $statline) {
	$total = $total + $statline['total'];
	$counter++;
}
//$total = $total / $counter;
array_push($rankings, $id);
array_push($playerNames,$name);
array_push($schoolNames, $school);
array_push($averagePoints, $total);

?>
