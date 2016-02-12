<?php

include "createconnection.php";

$team = mysqli_real_escape_string($conn, $_POST['team']);
$league = mysqli_real_escape_string($conn, $_POST['league']);

foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND league='$league'") as $p) {
	$player = $p['player'];

	echo $player;
	echo "*";

	$position = "N";

	foreach($conn->query("SELECT * FROM players WHERE id='$player'") as $thePlayer) {
		echo $thePlayer['name'];
		echo "*";
		$position = $thePlayer['position'];
	}


	$ppg = 0;
	$rpg = 0;
	$apg = 0;
	$numgamesplayed = 0;
	foreach($conn->query("SELECT * FROM playerstats WHERE player='$player'") as $game) {
		$ppg = $ppg + $game['points'];
		$rpg = $rpg + $game['rebounds'];
		$apg = $apg + $game['assists'];
		$numgamesplayed++;
	}
	if($numgamesplayed > 0) {
		$ppg = $ppg/$numgamesplayed;
		$rpg = $rpg/$numgamesplayed;
		$apg = $apg/$numgamesplayed;
	}

	echo $ppg;
	echo "*";
	echo $rpg;
	echo "*";
	echo $apg;
	echo "*";

	echo $p['currentPos'];
	echo "*";

	echo $position;

	echo "&";
}


$conn->close()
?>
