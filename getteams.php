<?php
include "createconnection.php";

$id = $_POST['id'];

$userID = mysqli_real_escape_string($conn, $id);

foreach($conn->query("SELECT * FROM teams WHERE owner='$userID'") as $team) {
	echo $team["id"];
	echo "*";
	echo $team['name'];
	echo "*";
	$leagueID = $team['league'];
	$team = $team['id'];
	foreach ($conn->query("SELECT * FROM leagues where id='$leagueID'") as $league) {
		echo $league['leaguename'];
		echo "*";

		$numTeams = 0;

		//get current position

		$teams = array();

		foreach($conn->query("SELECT * FROM teams WHERE league='$leagueID'") as $uno) {
			array_push($teams, $uno['id']);
			$numTeams++;
		}

		$teamresult = array();
		for($i=0;$i<count($teams);$i++) {
			$current = $teams[$i];

			$totalwins = 0;
			$current = mysqli_real_escape_string($conn, $current);
			foreach($conn->query("SELECT * FROM schedule WHERE team='$current'") as $game) {
				if($game['result'] == 'W') {
					$totalwins++;
				}
			}
			array_push($teamresult, $totalwins);
		}

		array_multisort($teamresult, SORT_DESC, $teams);

		$currentPosition = 0;
		for($i=0;$i<$numTeams;$i++) {
			if($teams[$i] == $team) {
				$currentPosition = $i + 1;
				break;
			}
		}

		echo $currentPosition;

		echo "*";

		echo $numTeams;

		echo "*";

		echo $leagueID;
	}
	echo "&";
}



$conn->close()
?>

