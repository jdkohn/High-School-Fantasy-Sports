<?php

include "createconnection.php";

$leaguenum = mysqli_real_escape_string($conn, $_POST['league']);





$teams = array();
$numteams = 0

foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $uno) {
	array_push($teams, $uno['id']);
	$numteams++;
}

$numGames = $numteams / 2;


$used = array();
for($i=0;$i<$numteams; $i++) {
	$tt = $teams[$i];
	$use = TRUE;
	for($q=0; $q<count($used); $q++) {
		if($tt == $used[$q]) {
			$use = FALSE;
		}
	}
	if($use) {
		$tt = mysqli_real_escape_string($conn, $tt);
		foreach($conn->query("SELECT * FROM schedule WHERE team='$tt' AND week='$week'") as $currentGame) {


//tr





			$hometeamname = '';
			foreach($conn->query("SELECT * FROM teams WHERE id='$tt'") as $home) {
				$hometeamname = $home['name'];
			}
			$hometeampoints = 0;

			for($l=($week * 7); $l<(($week+1) * 7); $l++) {
				$dia = $l;
				foreach($conn->query("SELECT * FROM teamstats WHERE day='$dia' AND team='$tt'") as $hometeamforday) {
					$hometeampoints = $hometeampoints + $hometeamforday['total'];
				}
			}



			$opponent=$currentGame['opponent'];
			$awayteamname = '';
			$opponent = mysqli_real_escape_string($conn, $opponent);
			$awayteampoints = 0;
			foreach($conn->query("SELECT * FROM teams WHERE id='$opponent'") as $o) {
				$awayteamname=$o['name'];
			}
			for($l=($week * 7); $l<(($week+1) * 7); $l++) {
				$dia = $l;
				foreach($conn->query("SELECT * FROM teamstats WHERE day='$dia' AND team='$opponent'") as $hometeamforday) {
					$awayteampoints = $awayteampoints + $hometeamforday['total'];
				}
			}
			array_push($used, $tt);
			array_push($used, $opponent);

//tds
			echo $hometeamname . ": " . $hometeampoints;

			echo "*";

			foreach($conn->query("SELECT * FROM joint WHERE team='$tt' AND currPos != 'B' LIMIT 5") as $p) {
				$playerID = $p['player'];
				foreach($conn->query("SELECT * FROM players WHERE id='$playerID'") as $thePlayer) {
					echo $thePlayer['name'];
					echo "*"
				}
			}


			echo $hometeamname;
			echo $hometeampoints;
			echo $awayteamname;
			echo $awayteampoints;


// /tds



			echo "&"
		}
	}
}


?>
