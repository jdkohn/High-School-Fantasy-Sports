<?php

include "header.php"; 
include "createconnection.php";

$team = $_GET["team"];

$team = mysqli_real_escape_string($conn, $team);

foreach ( $conn->query("SELECT * FROM teams where id='$team'") as $row ) {
	$team = $row;
}

$leaguenum=$team["league"];
$teamnum=$team["id"];
$commish = 0;

$leaguenum = mysqli_real_escape_string($conn, $leaguenum);
$teamnum = mysqli_real_escape_string($conn, $teamnum);

$drafttime='';
date_default_timezone_set('America/Los_Angeles');
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $lll) {
	$drafttime = $lll['draftdate'];
	$commish = $lll['commissioner'];
}

$isCommish = 0;
if($commish == $_SESSION['id']) {
	$isCommish = 1;
}

$teams = array();
foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $curr) {
	array_push($teams, $curr['id']);
}

$reverse = array_reverse($teams);

$order = array();

$numteams=count($teams);
for($l=0; $l<3; $l++) {
	for($i=0; $i<$numteams; $i++) {
		array_push($order, $teams[$i]);
	}
	for($i=0; $i<$numteams; $i++) {
		array_push($order, $reverse[$i]);
	}
}

$picks = "SELECT * FROM baseballdraft WHERE league='$leaguenum'";
$result = $conn->query($picks);
$numpicks=mysqli_num_rows($result);

$totalp = "SELECT * FROM joint WHERE league='$leaguenum' AND team!='0'";
$result = $conn->query($totalp);
$totalplayers = mysqli_num_rows($result);

if($totalplayers == count($order)) {
	?>
	<script>
		window.location ="baseballTeam.php?id=" + <?php echo $teamnum; ?>;
	</script>
	<?php
}
$lastpicktime = 0;
if(time() < strtotime($drafttime)) {
	$ontheclock = '';
	$timeLeftOnClock = 1;
} else if(time() >= strtotime($drafttime) && $numpicks == 0) {
	$ontheclock = $order[0];
	$lastpicktime = strtotime($drafttime);
	$timeLeftOnClock = $lastpicktime - (time() - 60);
} else {
	$ontheclock = $order[$numpicks];
	$lastpicktime = '';
	foreach($conn->query("SELECT * FROM baseballdraft WHERE league='$leaguenum'") as $ppp) {
		$lastpicktime = $ppp['time'];
	}
	$timeLeftOnClock = $lastpicktime - (time() - 60);
}

$numOutfielders = 0;
$numInfielders = 0;
$numFlex = 0;
foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum'") as $pp) {
	if($pp["currentPos"] == 'O') {
		$numOutfielders++;
	}
	if($pp["currentPos"] == 'I') {
		$numInfielders++;
	}
	if($pp["currentPos"] == 'X') {
		$numFlex++;
	}
}


$OTCName = '';

$ontheclock = mysqli_real_escape_string($conn, $ontheclock);
foreach($conn->query("SELECT * FROM teams WHERE id='$ontheclock'") as $picker) {
	$OTCName = $picker['name'];
}



$p = "SELECT * FROM joint WHERE league='$leaguenum' AND team='$teamnum'";
$r = $conn->query($p);
$numplayers = mysqli_num_rows($r);


date_default_timezone_set('America/Los_Angeles');
$timeToDraft = time() - strtotime($drafttime);

$min = ((((int)($timeToDraft/60)))*-1);
$ttdnice = $min . ":";
$seconds = (($timeToDraft%60)*-1);
if($seconds<10) {
	$ttdnice = $ttdnice . "0" . $seconds;
} else {
	$ttdnice = $ttdnice . $seconds;
}

$autopick = 0;
foreach($conn->query("SELECT * FROM joint WHERE league='$leaguenum' AND currentPos='N'") as $prospect) {
	$autopick = $prospect['player'];
	break;
}
echo $autopick;
?>

<head>
<title>Draft</title>
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

function update_content(){
	$.ajax({
		type: "GET",
      url: "?team=<?php echo $teamnum; ?>", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
  })
	.done(function( page_html ) {
		var newDoc = document.open("text/html", "replace");
		newDoc.write(page_html);
		newDoc.close();
	});   
}


function draft($playerID) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			update_content();
		}
	}
	xhttp.open("POST", "draftplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&team=" + <?php echo "$ontheclock"; ?> + "&league=" + <?php echo "$leaguenum"; ?> + "&time=" + <?php echo "$lastpicktime"; ?> + "&commish=" + <?php echo "$isCommish"; ?>);	
}

function startTimer() {
	var str = document.getElementById("clock");
	var counter = 60;
	var newElement = document.createElement("p");
	newElement.innerHTML = "60";
	var id;

	str.parentNode.replaceChild(newElement, str);

	id = setInterval(function() {
	counter--;
	if(counter < 0) {

	} else {
	    newElement.innerHTML = counter.toString();
	    newElement.parentNode.replaceChild(newElement, newElement);
	}
	}, 1000);
}

</script>

<br><br>

<table width="100%">
	<tr>
		<?php
		if(time() < strtotime($drafttime)) {
			?>
			<div id="clock">
				<td> <?php echo "Time To Draft: " . $ttdnice; ?></td>
			</div>
			<?php
		} else {
			?>
				<td><?php echo "On The Clock: " . $OTCName; ?></td>
				<td><?php 

				if($ontheclock == $teamnum) {
					?>
						<a id="clock">60</a>
					<?php
				} else {
					echo $timeLeftOnClock; 
				}
				?></td>
			<?php
		}
		?>
	</tr>
</table>

<br>

<?php 
if($ontheclock == $teamnum) {
?>
	<h3 align="center">Patience is a virtue! Click "Draft" button only once!</h3>
	<script>
		startTimer();
	</script>
<?php 
}
?>

<table width="23%" style="float: left;">
	<tr>
		<th>Draft Order</th>
	</tr>

	<?php
	$counter = 1;
	foreach($conn->query("SELECT * FROM baseballdraft WHERE league='$leaguenum'") as $pick) {
		$team = $pick['team'];
		$player= $pick['player'];

		$teamname='';
		$playername='';

		$team = mysqli_real_escape_string($conn, $team);
		foreach($conn->query("SELECT * FROM teams WHERE id='$team'") as $teamresult) {
			$teamname=$teamresult['name'];
		}

		$player = mysqli_real_escape_string($conn, $player);
		foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$player'") as $playerresult) {
			$playername = $playerresult['name'];
		}

		?>

		<tr>
			<td><?php echo  $counter . ". " . $playername . " ($teamname" . ")"; ?></td>
		</tr>
		<?php
		$counter++;
	}


	//AUTOPICK

	if(($timeLeftOnClock <= 0) && ($commish == $_SESSION['id'])) {
		?>
		<script>
			draft(<?php echo $autopick; ?>);
		</script>	
		<?php
		$ontheclock++;
	}

	?>
</table>
<?php
if($ontheclock == $teamnum) {
	?>
		<table width="50%" style="float: left; margin-left:2%;">
		<tr>
			<th>Player Name</th>
			<th>School</th>
			<th>Position</th>
			<th>Draft!</th>
		</tr>
	<?php
		$playerNames = array();
		$schoolNames = array();
		$averagePoints = array();
		$rankings = array();

		if($numFlex == 0) {
			foreach($conn->query("SELECT * FROM baseballplayers") as $player) {
				include "getPlayersLoop.php";
			}
		} else if($numOutfielders == 2) {
			foreach($conn->query("SELECT * FROM baseballplayers WHERE position='I'") as $player) {
				include "getPlayersLoop.php";
			}
		} else if($numInfielders == 3) {
			foreach($conn->query("SELECT * FROM baseballplayers WHERE position='O'") as $player) {
				include "getPlayersLoop.php";
			}
		}

		array_multisort($averagePoints, SORT_DESC, $playerNames, $schoolNames, $rankings);

		$players = array();
		foreach($conn->query("SELECT * FROM joint where team='0' AND league=$leaguenum") as $current) {
			$id = $current["player"];
			$id=mysqli_real_escape_string($conn, $id);
			array_push($players, $id); 
		}

		for($r=0; $r<count($rankings); $r++) {

			for($d=0; $d<count($players); $d++) {
				if($players[$d] == $rankings[$r]) {

					$playeridentification = $players[$d];

					foreach($conn->query("SELECT * FROM baseballplayers where id='$playeridentification'") as $player) {
						?>
						<tr>
							<td><?php echo $player["name"]; ?></td>
							<td><?php echo $player["school"]; ?></td>
							<td><?php echo $player["position"]; ?></td>
							<td>
								<input class='dButton' type="button" value="Draft" onclick="draft(<?php echo $player['id']; ?>)" />
							</td>
						</tr>
						<?php
					}
				}
			}
		}
	?>
	</table>
	<?php
} else {
	?>
		<script type="text/javascript">
		  setTimeout(function(){
		    update_content();
		  },1000)
		</script>
	<table width="50%" style="float: left; margin-left:2%;">
		<tr>
			<th>Player Name</th>
			<th>School</th>
			<th>Position</th>
			<th>Draft!</th>
		</tr>
			<?php
		$playerNames = array();
		$schoolNames = array();
		$averagePoints = array();
		$rankings = array();

		if($numFlex == 0) {
			foreach($conn->query("SELECT * FROM baseballplayers") as $player) {
				include "getPlayersLoop.php";
			}
		} else if($numOutfielders == 2) {
			foreach($conn->query("SELECT * FROM baseballplayers WHERE position='I'") as $player) {
				include "getPlayersLoop.php";
			}
		} else if($numInfielders == 3) {
			foreach($conn->query("SELECT * FROM baseballplayers WHERE position='O'") as $player) {
				include "getPlayersLoop.php";
			}
		}

		array_multisort($averagePoints, SORT_DESC, $playerNames, $schoolNames, $rankings);

		$players = array();

		foreach($conn->query("SELECT * FROM joint where team='0' AND league=$leaguenum") as $current) {
			$id = $current["player"];
			$id=mysqli_real_escape_string($conn, $id);
			array_push($players, $id); 
		}

		for($r=0; $r<count($rankings); $r++) {

			for($d=0; $d<count($players); $d++) {
				if($players[$d] == $rankings[$r]) {

					$playeridentification = $players[$d];

					foreach($conn->query("SELECT * FROM baseballplayers where id='$playeridentification'") as $player) {
						?>
						<tr>
							<td><?php echo $player["name"]; ?></td>
							<td><?php echo $player["school"]; ?></td>
							<td><?php 

							if($player["position"] == "O") {
								echo "Outfield";
							} else {
								echo "Infield";
							}
							?>
							</td>
							<td>
								<input type="button" value="--" onclick="" />
							</td>
						</tr>
						<?php
					}
				}
			}
		}
	?>
	</table>
	<?php
}

?>



<table width="23%" style="float: left; margin-left:2%;">
	<tr>
		<th>My Team</th>
	</tr>

	<?php
	foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum'") as $pick) {
		$player= $pick['player'];
		$player = mysqli_real_escape_string($conn, $player);
		foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$player'") as $playerresult) {
			$name = $playerresult['name'];
			$position=$playerresult['position'];
			$school=$playerresult['school'];
		}

		?>

		<tr>
			<td><?php echo $name . ", " . $school. " " . $position; ?></td>
		</tr>
		<?php
	}


	?>
</table>


<?php

$conn->close()
?>