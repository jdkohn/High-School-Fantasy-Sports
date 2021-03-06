<?php

include 'createconnection.php';
include 'style.php';
include 'header.php';

date_default_timezone_set('America/Los_Angeles');

$team = mysqli_real_escape_string($conn, $_GET["id"]);
$teamname = '';
$league = '';
//get team name and league id
foreach($conn->query("SELECT * FROM teams WHERE id='$team'") as $t) {
	$teamname = $t['name'];
	$league = $t['league'];
}

$leaguename = '';
$capacity = 0;
$commissioner = FALSE;
$drafttime = '';
//get number of teams in league
foreach($conn->query("SELECT * FROM leagues WHERE id='$league'") as $l) {
	$leaguename = $l['leaguename'];
	$capacity = $l['numteams'];
	if($l['commissioner'] == $_SESSION['id']) {
		$commissioner = TRUE;
	}
	$drafttime = $l['draftdate'];
}

$numteams = 0;
foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $t) {
	$numteams++;
}





?>


<head>
	<title><?php echo $teamname; ?></title>
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>



function leagueDiv() {

	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'block';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	scoreboard.style.display = 'none';
	settings.style.display = 'none';

	var drop = document.getElementById('drop');
	drop.style.display = 'none';

	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
};

function teamDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'block';
	players.style.display = 'none';
	standings.style.display = 'none';
	scoreboard.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
};

function playersDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'block';
	standings.style.display = 'none';
	scoreboard.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
};

function standingsDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'block';
	scoreboard.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
};

function scoreboardDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');

	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
	scoreboard.style.display = 'block';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
}

function scheduleDiv() {

	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	scoreboard.style.display = 'none';
	schedule.style.display = 'block';
	settings.style.display = 'none';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'none';
}



function settingsDiv() {

	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	var drop = document.getElementById('drop');
	var rankings = document.getElementById('rankings');

	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	scoreboard.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'block';
	drop.style.display = 'none';
	rankings.style.display = 'none';
};

function powerRankingsDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var scoreboard = document.getElementById('scoreboard');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	var drop = document.getElementById('drop');
	var rankings = document.getElementById('rankings');

	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	scoreboard.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
	drop.style.display = 'none';
	var rankings = document.getElementById('rankings');
	rankings.style.display = 'block';
}


function update_content(){
	$.ajax({
		type: "GET",
      url: "baseballTeam.php?id=<?php echo $team; ?>", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
  })
	.done(function( page_html ) {
		var newDoc = document.open("text/html", "replace");
		newDoc.write(page_html);
		newDoc.close();
	});   
}

/* CODE FOR DROPPING*/

</script>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["teamname"])) {
		$newname=$_POST["teamname"];

		$newname=mysqli_real_escape_string($conn, $newname);

		$changename = "UPDATE teams SET name='$newname' WHERE id='$team'";
		if ($conn->query($changename) == TRUE) {
			?>
			<script type="text/javascript">
			update_content();
			</script>
			<?php

		} else {
			echo "Error: " . $changename . "<br>" . $conn->error;
		}
	} else if(isset($_POST["drafttime"])) {
		$newtime=$_POST["drafttime"];

		$changename = "UPDATE leagues SET draftdate='$newtime' WHERE id='$league'";
		if ($conn->query($changename) == TRUE) {
			?>
			<script type="text/javascript">
			update_content();
			</script>
			<?php
		} else {
			echo "Error: " . $changename . "<br>" . $conn->error;
		}
	} else if(isset($_POST["leaguename"])) {
		$newname=$_POST["leaguename"];

		$newname=mysqli_real_escape_string($conn, $newname);
		$changename = "UPDATE leagues SET leaguename='$newname' WHERE id='$league'";
		if ($conn->query($changename) == TRUE) {
			?>
			<script type="text/javascript">
			update_content();
			</script>
			<?php
		} else {
			echo "Error: " . $changename . "<br>" . $conn->error;
		}
	} 
}

?>



<html>

<h1><?php echo "$teamname"; ?></h1>


<input class="TeamButtons" type="button" value="League" onclick="leagueDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="MyTeam" onclick="teamDiv()" />
<a>  </a>
<?php
$result = $conn->query("SELECT * FROM draft WHERE league='$league'");
if(mysqli_num_rows($result) == ($capacity * 7)) {
	?>
	<input class="TeamButtons" type="button" value="Add Players" onclick="playersDiv()" />
	<a>  </a>
	<?php
}
?>
<input class="TeamButtons" type="button" value="Standings" onclick="standingsDiv()" />
<a>  </a>
<?php
$result = $conn->query("SELECT * FROM draft WHERE league='$league'");
if(mysqli_num_rows($result) == ($capacity * 7)) {
	?>
	<input class="TeamButtons" type="button" value="Matchup" onclick="scoreboardDiv()" />
	<a>  </a>
	<?php
}
?>
<input class="TeamButtons" type="button" value="Schedule" onclick="scheduleDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Power Ranks" onclick="powerRankingsDiv()" />
<a>  </a>
<input class="TeamSettingsButton" type="button" value="Settings" onclick="settingsDiv()" />
<a>  </a>
<?php
$result = $conn->query("SELECT * FROM baseballdraft WHERE league='$league'");
if(mysqli_num_rows($result) != ($capacity * 6)) {
	if(((time()+(60*60*1)) > strtotime($drafttime)) && ($numteams == $capacity)) {
		?>
		<input class="dButton" type="submit" value="Draft" id="goToDraft" onclick="draft()" />
		<br>
		<?php
	}
}
?>

<element id="league" style="display: none">
	<br>
	<?php
	$teams = array();
	$numGames = $numteams / 2;

	//get teams from league
	foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
		array_push($teams, $uno['id']);
	}
	?>
	<table>
		<tr>
			<th colspan="4">
				Games This Week
			</th>
		</tr>
		<tr>
			<td>Home</td>
			<td>Score</td>
			<td>Away</td>
			<td>Score</td>
		</tr>

		<?php
		
		$used = array();
		
		//decide if team has been used yet
		for($i=0;$i<$numteams; $i++) {
			$tt = $teams[$i];
			$use = TRUE;
			for($q=0; $q<count($used); $q++) {
				if($tt == $used[$q]) {
					$use = FALSE;
				}
			}
			//if team has not been used
			if($use) {
				$tt = mysqli_real_escape_string($conn, $tt);

				//find current game
				foreach($conn->query("SELECT * FROM schedule WHERE team='$tt' AND week='$week'") as $currentGame) {
					?>
					<tr>
						<?php
						$hometeamname = '';
						foreach($conn->query("SELECT * FROM teams WHERE id='$tt'") as $home) {
							$hometeamname = $home['name'];
						}
						$hometeampoints = 0;

						//add up home team total from the week
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

						//add up opponent total from the week
						for($l=($week * 7); $l<(($week+1) * 7); $l++) {
							$dia = $l;
							foreach($conn->query("SELECT * FROM teamstats WHERE day='$dia' AND team='$opponent'") as $hometeamforday) {
								$awayteampoints = $awayteampoints + $hometeamforday['total'];
							}
						}

						//set both teams as 'used'
						array_push($used, $tt);
						array_push($used, $opponent);

						?>
						<td><?php echo $hometeamname; ?></td>
						<td><?php echo $hometeampoints; ?></td>
						<td><?php echo $awayteamname; ?></td>
						<td><?php echo $awayteampoints; ?></td>
					</tr>
					<?php
				}
			}
		}
		?>
	</table>

</element>

<div id="team">
	<?php
	$outfielders = array();
	foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='O'") as $p) {
		array_push($outfielders, $p);
	}
	$infielders = array();
	foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='I'") as $p) {
		array_push($infielders, $p);
	}
	$flex = array();
	foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='X'") as $p) {
		array_push($flex, $p);
	}
	?>
	<br>

	<table>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th>School</th>
			<th>HPG</th>
			<th>RBI PG</th>
			<th>RPG</th>
		</tr>

		<?php

		$countOut = 0;
		foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='O'") as $out) {
			$countOut++;
			$outID = $out["player"];
			foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$outID'") as $p) {
				?>
				<tr>
					<td>OF</td>
					<td><?php echo $p['name']; ?></td>
					<td><?php echo $p['school']; ?></td>
					<td>--</td>
					<td>--</td>
					<td>--</td>
				</tr>
				<?php
			}
		}

		$numBlankOut = 0;
		if($countOut == 0) {
			$numBlankOut = 2;
		} else if($countOut == 1) {
			$numBlankOut = 1;
		}

		for($i=0; $i<$numBlankOut; $i++) {
			?>
			<tr>
				<td>OF</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
			</tr>
			<?php
		}

		$countIn = 0;
		foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='I'") as $in) {
			$countIn++;
			$inID = $in["player"];
			foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$inID'") as $p) {
				?>
				<tr>
					<td>IF/C</td>
					<td><?php echo $p['name']; ?></td>
					<td><?php echo $p['school']; ?></td>
					<td>--</td>
					<td>--</td>
					<td>--</td>
				</tr>
				<?php
			}
		}

		$numBlankIn = 0;
		if($countIn == 0) {
			$numBlankIn = 3;
		} else if($countIn == 1) {
			$numBlankIn = 2;
		} else if($countIn == 2) {
			$numBlankIn = 1;
		}

		for($i=0; $i<$numBlankIn; $i++) {
			?>
			<tr>
				<td>IF/C</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
			</tr>
			<?php
		}

		$countFlex = 0;
		foreach($conn->query("SELECT * FROM joint WHERE team='$team' AND currentPos='X'") as $flex) {
			$countFlex++;
			$flexID = $flex["player"];
			foreach($conn->query("SELECT * FROM baseballplayers WHERE id='$flexID'") as $p) {
				?>
				<tr>
					<td>FLEX</td>
					<td><?php echo $p['name']; ?></td>
					<td><?php echo $p['school']; ?></td>
					<td>--</td>
					<td>--</td>
					<td>--</td>
				</tr>
				<?php
			}
		}

		if($countFlex == 0) {
			?>
			<tr>
				<td>FLEX</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
				<td>--</td>
			</tr>
			<?php
		}


		?>

	</table>
	
</div>

<div id="players" style="display: none">
	<br>
	<table>
		<tr>
			<th>Player Name</th>
			<th>School</th>
			<th>Position</th>
			<th>Add</th>
		</tr>
		<?php
		$playerNames = array();
		$schoolNames = array();
		$averagePoints = array();
		$rankings = array();

		foreach($conn->query("SELECT * FROM baseballplayers") as $player) {
			$id = $player["id"];
			$name = $player["name"];
			$school = $player['school'];

			$total = 0;
			$counter = 0;
			foreach($conn->query("SELECT * FROM baseballstats WHERE player='$id'") as $statline) {
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

		$players = array();
		foreach($conn->query("SELECT * FROM joint where team='0' AND league='$league'") as $current) {
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
								<input class="addButton" type="button" value="+" onclick="addplayer(<?php echo $player['id']; ?>, <?php echo $teamplayers; ?>)" />
							</td>
						</tr>
						<?php
					}
				}
			}
		}
		?>
	</table>
</div>



<div id="standings" style="display: none">
	<br>
	<?php

	$teamname='';
	$team = mysqli_real_escape_string($conn, $team);
	$league = mysqli_real_escape_string($conn, $league);

	$teams = array();

	foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
		array_push($teams, $uno['id']);
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

	?>

	<table>
		<tr>
			<th>Team Name</th>
			<th>Wins</th>
			<th>Losses</th>
		</tr>
		<?php

		for($i=0; $i<count($teamresult); $i++) {
			$currentteam = $teams[$i];
			$numwins = 0;
			$numlosses = 0;
			$name = '';
			$currentteam = mysqli_real_escape_string($conn, $currentteam);
			foreach($conn->query("SELECT * FROM schedule WHERE team='$currentteam'") as $game) {
				if($game['result'] == 'W') {
					$numwins++;
				}
				if($game['result'] == 'L') {
					$numlosses++;
				}
			}
			foreach($conn->query("SELECT * FROM teams WHERE id='$currentteam'") as $curr) {
				$name = $curr['name'];
			}
			?>
			<tr>
				<td><?php echo $name; ?></td>
				<td><?php echo $numwins; ?></td>
				<td><?php echo $numlosses; ?></td>
			</tr>
			<?php
		}
		?>
	</table>

</div>


<div id="scoreboard" style="display: none">

</div>



<div id="schedule" style="display: none">
	<br>
	<table>
		<tr>
			<th>Week</th>
			<th>Opponent</th>
		</tr>
		<?php

		//get all games
		foreach($conn->query("SELECT * FROM schedule WHERE team='$team'") as $game) {
			$gweek = $game['week'];
			$oppnum = $game['opponent'];
			$opponent = '';
			$oppnum = mysqli_real_escape_string($conn, $oppnum);

			//get opposing team's week for each game
			foreach($conn->query("SELECT * FROM teams WHERE id ='$oppnum'") as $opp) {
				$opponent = $opp['name'];
			}
			?>
			<tr>
				<td><?php echo ($gweek + 1); ?></td>
				<td><?php echo $opponent; ?></td>
			</tr>
			<?php
		}

		?>
	</table>
</div>

<div id="drop" style="display: none">

</div>

<!-- Settings -->

<div id="settings" style="display: none">
	<br>
	<form method="post">
		Change Team Name:
		<?php

		?>
		<input type="text" name="teamname" value="<?php echo $teamname; ?>"  />
		<input type="submit" value="Change" onclick="teamDiv()" />
	</form>
	<?php
	$result=$conn->query("SELECT * FROM joint WHERE league='$league' AND team!='0'");
	$numDrafted = mysqli_num_rows($result);


	if($commissioner && ($numDrafted == 0)) {
		?>
		<form method="post">
			Change Draft Time: 
			<input id="dTime" type="datetime-local" name="drafttime" />
			<input type="submit" value="Change" onclick="teamDiv()" />
		</form>
		<?php
	}
	if($commissioner) {
		?>
		<form method="post">
			Change League Name:
			<input type="text" name="leaguename" value="<?php echo $leaguename; ?>" />
			<input type="submit" value="Change" onclick="teamDiv()" />
			<?php
		}
		?>
	</div>


	<!-- Rankings -->

	<div id="rankings" style="display: none">
		<?php
		$averagePoints = array();
		$rankings = array();

		foreach($conn->query("SELECT * FROM baseballplayers") as $player) {
			$id = $player["id"];

			$total = 0;
			$counter = 0;
			foreach($conn->query("SELECT * FROM baseballstats WHERE player='$id'") as $statline) {
				$total = $total + $statline['total'];
				$counter++;
			}
			if($counter != 0) {
				if($total != 0) {
					$total = $total / $counter;
					array_push($rankings, $id);
					array_push($averagePoints, $total);
				}
			}
		}

		array_multisort($averagePoints, SORT_DESC, $rankings);

		?>

		<br><br>


		<?php

		$teams = array();
		$averageRanking = array();
		foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $t) {
			$tnum = $t["id"];
			array_push($teams, $tnum);
			$total = 0;
			foreach($conn->query("SELECT * FROM joint WHERE team='$tnum'") as $p) {
				$playerNum = $p['player'];

				for($i=0; $i<count($rankings); $i++) {
					if($playerNum == $rankings[$i]) {
						$total = $total + $i;
					}
				}
			}
			if($total != 0) {
				$total = $total / 7;
			}
			array_push($averageRanking, $total);
		}

		array_multisort($averageRanking, $teams);
		?>

		<table>
			<tr>
				<th>Team Rank</th>
				<th>Team</th>
				<th>Average Player Ranking</th>
			</tr>
			<?php
			for($q=0; $q<count($averageRanking); $q++) {
				?>
				<tr>
					<td><?php echo $q + 1; ?></td>
					<td>
						<?php
						$tnum = $teams[$q];
						foreach($conn->query("SELECT * FROM teams WHERE id='$tnum'") as $ttt) {
							echo $ttt['name'];
						}
						?>
					</td>
					<td><?php echo substr($averageRanking[$q],0,4); ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>