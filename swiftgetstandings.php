<?php

include "createconnection.php";

$leaguenum = $_POST['league'];

$league = mysqli_real_escape_string($conn, $leaguenum);


//gets all teams
$teams = array();
foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
	array_push($teams, $uno['id']);
}

//gets counts up total wins for team
$teamwins = array();
$teamlosses = array();
for($i=0;$i<count($teams);$i++) {
	$current = $teams[$i];

	$totalwins = 0;
	$totallosses = 0;
	$current = mysqli_real_escape_string($conn, $current);
	foreach($conn->query("SELECT * FROM schedule WHERE team='$current'") as $game) {
		if($game['result'] == 'W') {
			$totalwins++;
		} else if($game['result'] == 'L') {
			$totallosses++;
		}
	}
	array_push($teamwins, $totalwins);
	array_push($teamlosses, $totallosses);
}

//sorts
array_multisort($teamwins, SORT_DESC, $teams, $teamlosses);

for($i=0; $i<count($teams); $i++) {
	$id = $teams[$i];

	echo $id;
	echo "*";

	foreach($conn->query("SELECT * FROM teams WHERE id='$id'") as $t) {
		echo $t["name"];
		echo "*";
		$owner = $t['owner'];
		foreach($conn->query("SELECT * FROM users WHERE id='$owner'") as $user) {
			$fullname = $user["firstname"] . " " . $user["lastname"];
			echo $fullname;
			echo "*";
		}
	}
	echo $teamwins[$i] . "-" . $teamlosses[$i];
	echo "&";
}

$conn->close()
?>