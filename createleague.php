<?php

include "header.php";
include "style.php";

echo "<br><br>";

?>

<html>



<?php
// define variables and set to empty values
$nameErr = $numTeamsErr = $draftDateErr = $passErr = "";
$name = $numTeams = $draftDate = $pass = "";
$nameSet = $numTeamsSet = $draftDateSet = $passSet = $passNeeded = FALSE;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["leaguename"])) {
		$nameErr = "League Name is required";
	} else {
		$name = test_input($_POST["leaguename"]);
		$nameSet = TRUE;
	}
	if (empty($_POST["numteams"])) {
		$numTeamsErr = "Number of Teams is required";
	} else {
		$numTeams = test_input($_POST["numteams"]);
		$numTeamsSet = TRUE;
	}

	if (empty($_POST["drafttime"])) {
		$draftDateErr = "Draft Time is required";
	} else {
		$draftDate = test_input($_POST["drafttime"]);
		$draftDateSet = TRUE;
	}
	if(strcmp($_POST["private"], "yes") == 0) {
		$passNeeded = TRUE;
		if(empty($_POST["password"])) {
			$passErr = "Password is required";
			echo "Password is required";
		} else {
			$pass = test_input($_POST["password"]);
			$passSet = TRUE;
		}
	}

	if(empty($_POST["drafttime"])) {
		$draftDateErr = "Draft date is required";
	} else {
		$draftDate = $_POST["drafttime"];
		$draftDay = substr($draftDate,0,10);
		$draftTime = " " . substr($draftDate,11) . ":00";
		$draftDate = $draftDay . $draftTime;
	}

	



	if($nameSet && $numTeamsSet && $draftDateSet) {
		include 'createconnection.php';

		$commissioner = $_SESSION["id"];

		if($passNeeded) {
			$sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate, password)
			VALUES ('$name', '$numTeams', '$commissioner', '$draftDate', '$pass')";
		} else {

			$sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate)
			VALUES ('$name', '$numTeams', '$commissioner', '$draftDate')";
		}

		if ($conn->query($sql) == FALSE) {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$leaguenum = -1;

		foreach($conn->query("SELECT * FROM leagues WHERE leaguename='$name' AND numteams = '$numTeams' AND commissioner='$commissioner' AND draftdate = '$draftDate'") as $c) {
			$leaguenum = $c['id'];
		}

		foreach ($conn->query("SELECT * FROM players") as $player) {
			$playerID = $player["id"];
			$addplayer = "INSERT INTO joint (league, player, currentPos, team) VALUES ('$leaguenum','$playerID', 'N', 0)";
			if ($conn->query($addplayer) == TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}

//add team into league for owner

		$owner = $_SESSION["id"];
		$teamname = "Team " . $_SESSION["firstname"];

		$getleaguenum = "SELECT * FROM leagues WHERE leaguename='$name' AND numteams='$numTeams' AND commissioner='$commissioner' AND draftdate='$draftDate'";
		$enteredleague = $conn->query($getleaguenum);
		$row = $enteredleague->fetch_assoc();
		$leaguenum = $row["id"];

		$addteam = "INSERT INTO teams (owner, name, league) VALUES ('$owner', '$teamname', '$leaguenum')";

		if ($conn->query($addteam) == TRUE) {
			
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close(); 
		?>
		<script>
			goToTeams();
			</script>
<?php
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$('input[name=private]').on('change', function(){
		var n = $(this).val();
		switch(n)
		{
			case 'yes':
			$('#show').html("You have chosen to make your league private. Enter a password below.<br> This password must be used to join the league.<br><input type=\"text\" name=\"password\"><span class=\"error\">* <?php echo $passErr;?></span>");
			<?php $passNeeded = TRUE; ?>
			break;
			case 'no':
			$('#show').html("Your league is not password protected. Anyone can join this league.");
			break;
		}
	});
});


function goToTeams() {
	window.location = "myteams.php";
}

</script>

<h1>Create League</h1>
<p>
	<span class="error">* required field</span>
	<form class="blocktext" method="post">
		League Name:<br>
		<input type="text" name="leaguename">
		<span class="error">* <?php echo $nameErr;?></span>
		<br><br>
		Number of Teams: 
		<select name="numteams">
			<option value=""></option>
			<option value="2">2</option>
			<option value="4">4</option>
			<option value="6">6</option>
			<option value="8">8</option>
			<option value="10">10</option>
		</select>
		<span class="error">* <?php echo $numTeamsErr;?></span>
		<br><br>
		Draft date and time: <input type="datetime-local" name="drafttime">
		<span class="error">* <?php echo $draftDateErr;?></span>
		<br><br>Private:
		Yes<input type="radio" name="private" value="yes"><a>	</a>No
		<input type="radio" name="private" value="no" checked="checked"><br>
		<div id='show'> 
			Your league is not private, anyone can join your league
		</div>
		<a href="www.espn.go.com"><input class="CreateButton" type="submit" value="Create" /></a>
	</p>
</form>


</html>



