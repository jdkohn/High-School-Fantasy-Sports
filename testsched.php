<?php

include "createconnection.php";
include "style.php";


$ppg = 0;
$rpg = 0;
$apg = 0;
$counter = 0;
$id = 3;

foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
	$ppg = $ppg + $game['points'];
	$rpg = $rpg + $game['rebounds'];
	$apg = $apg + $game['assists'];
	$counter++;
}

echo ($ppg/$counter) . " " . ($rpg/$counter) . " " . ($apg/$counter);
?>

<html>





