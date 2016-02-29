<?php

session_start();

include 'createconnection.php';

$owner = $_SESSION["id"];
$teamname = "Team " . $_SESSION["firstname"];
$leaguenum = $_POST["leaguenum"];
$password = $_POST["password"];
$addteam = "";

$owner = mysqli_real_escape_string($conn, $owner);
$teamname = mysqli_real_escape_string($conn, $teamname);
$leaguenum = mysqli_real_escape_string($conn, $leaguenum);
$password = mysqli_real_escape_string($conn, $password);


if($password == "9q4fd6bppl04s") {

	$addteam = "INSERT INTO teams (owner, name, league, sport) VALUES ('$owner', '$teamname', '$leaguenum', 'B')";

} else {
	$sql = "SELECT * FROM leagues WHERE id='$leaguenum'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		 // output data of each row
		while($row = $result->fetch_assoc()) {
			if($password == $row["password"]) {
				$addteam = "INSERT INTO teams (owner, name, league, sport) VALUES ('$owner', '$teamname', '$leaguenum', 'B')";
			} else {
				break;
			}
		}
	}
}

if ($conn->query($addteam) == TRUE) {
	echo '<script type="text/javascript">alert("Your team has been added!");</script>';
} else {
	echo "Error: " . $addteam . "<br>" . $conn->error;
}

//make schedule

$capacity = 0;

foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $curr) {
	$capacity=$curr['numteams'];
}

$numteams = 0;
foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $currT) {
	$numteams++;
}

if($numteams == $capacity) {
	$teams = array();
	foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $curr) {
		array_push($teams, $curr['id']);
	}

	for($week=0; $week<10; $week++) {
		$myArray= $teams;
		$size = count($myArray);

		for($i=0;$i<$size/2; $i++) {

			$randidx = array_rand($myArray);

			$randomteam1 = $myArray[$randidx];

			$cop = array();
			for($q=0; $q<count($myArray); $q++) {
				if($q != $randidx) {
					array_push($cop, $myArray[$q]);
				}
			}

			unset($myArray[$randidx]);

			$myArray= array();

			for($q=0; $q<count($cop); $q++) {
				array_push($myArray, $cop[$q]);
			}

			//get team 2

			$randidx = array_rand($myArray);

			$randomteam2 = $myArray[$randidx];


			$cop = array();
			for($q=0; $q<count($myArray); $q++) {
				if($q != $randidx) {
					array_push($cop, $myArray[$q]);
				}
			}

			unset($myArray[$randidx]);

			$myArray= array();

			for($q=0; $q<count($cop); $q++) {
				array_push($myArray, $cop[$q]);
			}

			$randomteam1 = mysqli_real_escape_string($conn, $randomteam1);
			$randomteam2 = mysqli_real_escape_string($conn, $randomteam2);

			$one = "INSERT INTO schedule (team, week, opponent) VALUES ('$randomteam1', '$week', '$randomteam2')";
			$two = "INSERT INTO schedule (team, week, opponent) VALUES ('$randomteam2', '$week', '$randomteam1')";

			if($conn->query($one) == FALSE) {
				echo "oops";
			}
			if($conn->query($two) == FALSE) {
				echo "oops";
			}

		}
		echo "<br>";
	}
}


$conn->close();
?>
