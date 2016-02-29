<?php

include "header.php";
include "createconnection.php";

$team = $_GET["id"];

$team = mysqli_real_escape_string($conn, $team);
foreach ( $conn->query("SELECT * FROM teams where id='$team'") as $row ) {

	$team = $row;

}
$teamname = $team['name'];
$leaguenum=$team["league"];
$teamnum=$team["id"];

$teamplayers="0";

$teamnum=mysqli_real_escape_string($conn, $teamnum);
foreach($conn->query("SELECT * FROM joint where team='$teamnum'") as $dumb) {
	$teamplayers++;
}


echo "<br>";


$leaguenum = mysqli_real_escape_string($conn, $leaguenum);
$result = $conn->query("SELECT * FROM teams WHERE league='$leaguenum'");
$numteams = mysqli_num_rows($result);

$leaguename = "";
$drafttime='';
date_default_timezone_set('America/Los_Angeles');
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $lll) {
	$drafttime = $lll['draftdate'];
	$leaguename = $lll['leaguename'];
}


$commissioner = FALSE;
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $curr) {
	if($curr['commissioner'] == $_SESSION['id']) {
		$commissioner = TRUE;
	}
}

$firstdayofweek = $week * 7;
$lastdayofweek = $firstdayofweek + 7;


$capacity = 0;
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $l) {
	$capacity = $l['numteams'];
}

$addWeek = FALSE;
$subtractWeek = FALSE;


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
};



function settingsDiv() {

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
	schedule.style.display = 'none';
	settings.style.display = 'block';
	var drop = document.getElementById('drop');
	drop.style.display = 'none';

	var rankings = document.getElementById('rankings');
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
      url: "team.php?id=<?php echo $teamnum; ?>", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
  })
	.done(function( page_html ) {
		var newDoc = document.open("text/html", "replace");
		newDoc.write(page_html);
		newDoc.close();
	});   
}


function dropPlayer($playerID) {
	var $playerToAdd = localStorage.getItem("playerToAdd");

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var team = document.getElementById('team');
			var players = document.getElementById('drop');
			team.style.display = 'block';
			players.style.display = 'none';

			update_content();
			update_content();
		}
	}
	xhttp.open("POST", "dropplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&playerToAdd=" + $playerToAdd + "&league=" + <?php echo $leaguenum; ?> + "&team=" + <?php echo $teamnum; ?>);
}

function addplayer($playerID, $currNumPlayers) {
	if($currNumPlayers != 7) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				update_content();
				update_content();

				var team = document.getElementById('team');
				var players = document.getElementById('players');
				team.style.display = 'block';
				players.style.display = 'none';
			}
		}
		xhttp.open("POST", "addplayer.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("playerid=" + $playerID + "&numplayers=" + $currNumPlayers + "&teamnum=" + <?php echo "$teamnum"; ?> + "&leaguenum=" + <?php echo $leaguenum; ?>);

		
	} else {

		localStorage.setItem("playerToAdd", $playerID);

		var drop = document.getElementById('drop');
		drop.style.display = 'block';
		var players = document.getElementById('players');
		players.style.display = 'none';
	}
}

function moveplayer($currPos, $player, $pos, $numg, $numf, $numx, $numb) {

	var ghereo1 = document.getElementById('ghereo1');
	var ghereo2 = document.getElementById('ghereo2');
	var gblank1 = document.getElementById('gblank1');
	var gblank2 = document.getElementById('gblank2');
	var gheref1 = document.getElementById('gheref1');
	var gheref2 = document.getElementById('gheref2');
	var gmovef1 = document.getElementById('gmovef1');
	var gmovef2 = document.getElementById('gmovef2');
	var gmove1g = document.getElementById('gmove1g');
	var gblank1g = document.getElementById('gblank1g');
	var gblank3 = document.getElementById('gblank3');
	var gblank4 = document.getElementById('gblank4');

	var fhereo1 = document.getElementById('fhereo1');
	var fhereo2 = document.getElementById('fhereo2');
	var fblank1 = document.getElementById('fblank1');
	var fblank2 = document.getElementById('fblank2');
	var fheref1 = document.getElementById('fheref1');
	var fheref2 = document.getElementById('fheref2');
	var fmovef1 = document.getElementById('fmovef1');
	var fmovef2 = document.getElementById('fmovef2');
	var fmove1g = document.getElementById('fmove1g');
	var fblank1g = document.getElementById('fblank1g');
	var fblank3 = document.getElementById('fblank3');
	var fblank4 = document.getElementById('fblank4');

	var xmove = document.getElementById('xmove');
	var xhere = document.getElementById('xhere');
	var xblank = document.getElementById('xblank');

	var bslot = document.getElementById('bslot');

	if($currPos !== 'B') {
		bslot.style.display = 'table-row';
	}

	if($numg == 0) {
		ghereo1.style.display = 'none';
		gblank1.style.display = 'block';
	} else if($numg == 1) {
		ghereo2.style.display = 'none';
		gblank2.style.display = 'block';
		gmove1g.style.display = 'none';
		gblank1g.style.display = 'block';
	} else {
		gblank3.style.display = 'block';
		gblank4.style.display = 'block';
		gheref1.style.display = 'none';
		gheref2.style.display = 'none';
		gmovef1.style.display = 'none';
		gmovef2.style.display = 'none';
	}


	if($numf == 0) {
		fhereo1.style.display = 'none';
		fblank1.style.display = 'block';
	} else if($numf == 1) {
		fhereo2.style.display = 'none';
		fblank2.style.display = 'block';
		fmove1g.style.display = 'none';
		fblank1g.style.display = 'block';
	} else {
		fblank3.style.display = 'block';
		fblank4.style.display = 'block';
		fheref1.style.display = 'none';
		fheref2.style.display = 'none';
		fmovef1.style.display = 'none';
		fmovef2.style.display = 'none';
	}

	if($pos == 'G') {
		if($numg == 0) {
			ghereo1.style.display = 'block';
			gblank1.style.display = 'none';
		} else if($numg == 1) {
			gmove1g.style.display = 'none';
			gblank1g.style.display = 'block';
			ghereo2.style.display = 'block';
			gblank2.style.display = 'none';
		} else {
			gheref1.style.display = 'block';
			gheref2.style.display = 'block';
			gblank3.style.display = 'none';
			gblank4.style.display = 'none';
		}

	} else if($pos == 'F') {
		if($numf == 0) {
			fhereo1.style.display = 'block';
			fblank1.style.display = 'none';
		} else if($numf == 1) {
			fhereo2.style.display = 'block';
			fblank2.style.display = 'none';
		} else {
			fheref1.style.display = 'block';
			fheref2.style.display = 'block';
			fblank3.style.display = 'none';
			fblank4.style.display = 'none';
		}
	}

	if($numx == 0) {
		xhere.style.display = 'block';
		xblank.style.display = 'none';
	} else {
		xhere1.style.display = 'block';
		xmove.style.display = 'none';
	}
	

	if (typeof(Storage) !== "undefined") {
    // Store
    localStorage.setItem("currentPlayer", $player);
    localStorage.setItem("currentPosition", $currPos);

} 
}

function finalizeMove($moveTo) {

	var $playerID = localStorage.getItem("currentPlayer");
	var $currPos = localStorage.getItem("currentPosition");
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			update_content();
			update_content();
		}
	}
	xhttp.open("POST", "moveplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&newpos=" + $moveTo + "&league=" + <?php echo "$leaguenum"; ?> + "&currentposition=" + $currPos);

	

}

function draft() {
	location.href = "draft.php?team=<?php echo $teamnum; ?>";
}


</script>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["teamname"])) {
		$newname=$_POST["teamname"];

		$newname=mysqli_real_escape_string($conn, $newname);

		$changename = "UPDATE teams SET name='$newname' WHERE id='$teamnum'";
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

		$changename = "UPDATE leagues SET draftdate='$newtime' WHERE id='$leaguenum'";
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
		$changename = "UPDATE leagues SET leaguename='$newname' WHERE id='$leaguenum'";
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

<h1><?php echo "$team[name]"; ?></h1>


<input class="TeamButtons" type="button" value="League" onclick="leagueDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="MyTeam" onclick="teamDiv()" />
<a>  </a>
<?php
$result = $conn->query("SELECT * FROM draft WHERE league='$leaguenum'");
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
$result = $conn->query("SELECT * FROM draft WHERE league='$leaguenum'");
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
$result = $conn->query("SELECT * FROM draft WHERE league='$leaguenum'");
if(mysqli_num_rows($result) != ($capacity * 7)) {
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

	foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $uno) {
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
					?>
					<tr>
						<?php
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

<div id="team" >

	<br>

	<table>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th>School</th>
			<th>PPG</th>
			<th>RPG</th>
			<th>APG</th>
			<th>Action</th>
		</tr>
		<?php
		$counter = 0; 

		$numguards=0;
		$g = "SELECT * FROM joint WHERE team='$teamnum' AND currentPos='G'";
		$result = $conn->query($g);
		$numguards=mysqli_num_rows($result);

		$numforwards=0;
		$f = "SELECT * FROM joint WHERE team='$teamnum' AND currentPos='F'";
		$result = $conn->query($f);
		$numforwards=mysqli_num_rows($result);

		$numflex=0;
		$x = "SELECT * FROM joint WHERE team='$teamnum' AND currentPos='X'";
		$result = $conn->query($x);
		$numflex=mysqli_num_rows($result);

		$numbench=0;
		$b = "SELECT * FROM joint WHERE team='$teamnum' AND currentPos='B'";
		$result = $conn->query($b);
		$numbench=mysqli_num_rows($result);

		if($numguards == 0) {
			?>
			<tr>
				<td>G</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td><div id="gblank1">--</div>
					<input class="HereButton" type="button" id="ghereo1" value="Here" style="display: none" onclick="finalizeMove(0)" />
				</td>
			</tr>
			<tr>
				<td>G</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>--</td>
			</tr>
			<?php
		} else if($numguards == 1) {


			foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='G'") as $current) {
				$id = $current["player"];
				$ppg = 0;
				$rpg = 0;
				$apg = 0;
				$numgamesplayed = 0;
				foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
				$id=mysqli_real_escape_string($conn, $id);
				foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
					?>
					<tr>
						<td>G</td>
						<td><?php echo $player["name"]; ?></td>
						<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
						<td><?php echo substr($ppg,0,5); ?></td>
						<td><?php echo substr($rpg,0,5); ?></td>
						<td><?php echo substr($apg,0,5); ?></td>
						<td><div id="gmove1g"><input class="MoveButton" type="button" id="gmove" value="Move" onclick="moveplayer('G',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" /></div>
							<div id="gblank1g" style="display: none">--</div>

						</td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td>G</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td><div id="gblank2">--</div>
					<input class="HereButton" type="button" id="ghereo2" value="Here" style="display: none" onclick="finalizeMove(1)" />
				</td>
			</tr>
			<?php
		} else {

			foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='G'") as $current) {
				$id = $current["player"];
				$ppg = 0;
				$rpg = 0;
				$apg = 0;
				$numgamesplayed = 0;
				foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
				$id=mysqli_real_escape_string($conn, $id);
				foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
					?>
					<tr>
						<td>G</td>
						<td><?php echo $player["name"]; ?></td>
						<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
						<td><?php echo substr($ppg,0,5); ?></td>
						<td><?php echo substr($rpg,0,5); ?></td>
						<td><?php echo substr($apg,0,5); ?></td>
						<td>
							<?php 
							if($counter == 0) { ?>
							<input class="MoveButton" type="button" id="gmovef1" value="Move" onclick="moveplayer('G',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" />
							<input class="HereButton" type="button" id="gheref1" value="Here" style="display: none" onclick="finalizeMove(0)" />
							<div id="gblank3" style="display: none">--</div>
							<?php
							$counter ++;
						} else {
							?>
							<input class="MoveButton" type="button" id="gmovef2" value="Move" onclick="moveplayer('G',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" />
							<input class="HereButton" type="button" id="gheref2" value="Here" style="display: none" onclick="finalizeMove(1)" />
							<div id="gblank4" style="display: none">--</div>
							<?php
						}

						?>
					</td>
				</tr>
				<?php
			}
		}

	}
	$counter = 1;
	if($numforwards == 0) {
		?>
		<tr>
			<td>F</td>
			<td>--</td>
			<td>--</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td><div id="fblank1">--</div>
				<input class="HereButton" type="button" id="fhereo1" value="Here" style="display: none" onclick="finalizeMove(2)" />
			</td>
		</tr>
		<tr>
			<td>F</td>
			<td>--</td>
			<td>--</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td>--</td>
		</tr>
		<?php
	} else if($numforwards == 1) {


		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='F'") as $current) {
			$id = $current["player"];
			$ppg = 0;
			$rpg = 0;
			$apg = 0;
			$numgamesplayed = 0;
			foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
			$id=mysqli_real_escape_string($conn, $id);
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>F</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
					<td><?php echo substr($ppg,0,5); ?></td>
					<td><?php echo substr($rpg,0,5); ?></td>
					<td><?php echo substr($apg,0,5); ?></td>
					<td><div id="fmove1g"><input class="MoveButton" type="button" id="fmove" value="Move" onclick="moveplayer('F',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" /></div>
						<div id="fblank1g" style="display: none">--</div>
					</td>
				</tr>
				<?php
			}
		}
		?>
		<tr>
			<td>F</td>
			<td>--</td>
			<td>--</td>
			<td>0</td>
			<td>0</td>
			<td>0</td>
			<td><div id="fblank2">--</div>
				<input class="HereButton" type="button" id="fhereo2" value="Here" style="display: none" onclick="finalizeMove(3)" />
			</td>
		</tr>
		<?php
	} else {

		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='F'") as $current) {
			$id = $current["player"];
			$ppg = 0;
			$rpg = 0;
			$apg = 0;
			$numgamesplayed = 0;
			foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
			$id=mysqli_real_escape_string($conn, $id);
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>F</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
					<td><?php echo substr($ppg,0,5); ?></td>
					<td><?php echo substr($rpg,0,5); ?></td>
					<td><?php echo substr($apg,0,5); ?></td>
					<td>
						<?php 

						if($counter == 2) { ?>
						<input class="MoveButton" type="button" id="fmovef1" value="Move" onclick="moveplayer('F',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" />
						<input class="HereButton" type="button" id="fheref1" value="Here" style="display: none" onclick="finalizeMove(2)" />
						<div id="fblank3" style="display: none">--</div>
						<?php

					} else {
						?>
						<input class="MoveButton" type="button" id="fmovef2" value="Move" onclick="moveplayer('F',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" />
						<input class="HereButton" type="button" id="fheref2" value="Here" style="display: none" onclick="finalizeMove(3)" />
						<div id="fblank4" style="display: none">--</div>
						<?php
					}

					?>
				</td>
			</tr>
			<?php
		}
	}

}
$counter = 4;
if($numflex == 0) {
	?>
	<tr>
		<td>FLEX</td>
		<td>--</td>
		<td>--</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td><div id="xblank">--</div>
			<input class="HereButton" type="button" id="xhere" value="Here" style="display: none" onclick="finalizeMove(4)" />
		</td>
	</tr>
	<?php
} else {
	foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='X'") as $current) {
		$id = $current["player"];
		$ppg = 0;
		$rpg = 0;
		$apg = 0;
		$numgamesplayed = 0;
		foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
		$id=mysqli_real_escape_string($conn, $id);
		$counter++;
		foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
			?>
			<tr>
				<td>FLEX</td>
				<td><?php echo $player["name"]; ?></td>
				<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
				<td><?php echo substr($ppg,0,5); ?></td>
				<td><?php echo substr($rpg,0,5); ?></td>
				<td><?php echo substr($apg,0,5); ?></td>
				<td><input class="MoveButton" type="button" id="xmove" value="Move" onclick="moveplayer('X',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" />
					<input class="HereButton" type="button" id="xhere1" value="Here" style="display: none" onclick="finalizeMove(4)" /></td>
				</tr>
				<?php
			}

		}
	}
	
	$counter = 5;
	foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='B'") as $current) {
		$id = $current["player"];
		$ppg = 0;
		$rpg = 0;
		$apg = 0;
		$numgamesplayed = 0;
		foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $game) {
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
		$id=mysqli_real_escape_string($conn, $id);
		$counter++;
		foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
			?>
			<tr>
				<td>BENCH</td>
				<td><?php echo $player["name"]; ?></td>
				<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
				<td><?php echo substr($ppg,0,5); ?></td>
				<td><?php echo substr($rpg,0,5); ?></td>
				<td><?php echo substr($apg,0,5); ?></td>
				<td><input class="MoveButton" type="button" id="bmove" value="Move" onclick="moveplayer('B',<?php echo $id; ?>, '<?php echo $player['position']; ?>', <?php echo $numguards; ?>, <?php echo $numforwards; ?>, <?php echo $numflex; ?>, <?php echo $numbench; ?> )" /></td>
			</tr>
			<?php
		}

	}
	?>

	<tr id="bslot" style="display: none">
		<td>BENCH</td>
		<td>--</td>
		<td>--</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>
			<input class="HereButton" type="button" id="bhere" value="Here" onclick="finalizeMove(7)" />
		</td>
	</tr>
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

		foreach($conn->query("SELECT * FROM players") as $player) {
			$id = $player["id"];
			$name = $player["name"];
			$school = $player['school'];

			$total = 0;
			$counter = 0;
			foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $statline) {
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
		foreach($conn->query("SELECT * FROM joint where team='0' AND league=$leaguenum") as $current) {
			$id = $current["player"];
			$id=mysqli_real_escape_string($conn, $id);
			array_push($players, $id); 
		}

		for($r=0; $r<count($rankings); $r++) {

			for($d=0; $d<count($players); $d++) {
				if($players[$d] == $rankings[$r]) {

					$playeridentification = $players[$d];

					foreach($conn->query("SELECT * FROM players where id='$playeridentification'") as $player) {
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
	$team = mysqli_real_escape_string($conn, $teamnum);
	$league = mysqli_real_escape_string($conn, $leaguenum);

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

<div id="scoreboard" style="display:none">
	<?php 
	if($addWeek == TRUE) {
		$week++;
		$addWeek = FALSE;
		echo "Add Week";
	}
	if($subtractWeek == TRUE) {
		$week--;
		$subtractWeek = FALSE;
		echo "Subtract Week";
	}
	?>
	<h3><?php echo "Week: " . ($week + 1); ?></h3>
	<br>
	<?php
	foreach($conn->query("SELECT * FROM schedule WHERE team='$teamnum' AND week='$week'") as $currentGame) {
		$otherteam= $currentGame['opponent'];
	}

	foreach($conn->query("SELECT * FROM teams WHERE id='$otherteam'") as $opp) {
		$otherteamname = $opp['name'];
	}

	foreach($conn->query("SELECT * FROM teams WHERE id='$teamnum'") as $opp) {
		$teamname = $opp['name'];
	}
	?>

	<table width="100%">
		<tr>
			<th>Team</th>
			<th>Sunday</th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
			<th>Saturday</th>
			<th>Total</th>
		</tr>

		<tr>
			<td><?php echo $teamname; ?></td>
			<?php
			$total = 0;
			for($i=0; $i<7; $i++) {
				?>
				<td>
					<?php
					$day = ($i + 7 * $week);
					$points = 0;
					
					$day = mysqli_real_escape_string($conn, $day);
					foreach($conn->query("SELECT * FROM teamstats WHERE day='$day' AND team='$teamnum'") as $dailyscore) {
						$points = $dailyscore['total'];
						$total = $total + $points;
					}
					echo $points;
					?>
				</td>
				<?php
			}
			?>
			<td><?php echo $total; ?></td>
		</tr>
		<tr>
			<td><?php echo $otherteamname; ?></td>
			<?php
			$total = 0;
			for($i=0; $i<7; $i++) {
				?>
				<td>
					<?php
					$day = ($i + 7 * $week);
					$points = 0;
					
					$otherteam = mysqli_real_escape_string($conn, $otherteam);
					foreach($conn->query("SELECT * FROM teamstats WHERE day='$day' AND team='$otherteam'") as $dailyscore) {
						$points = $dailyscore['total'];
						$total = $total + $points;
					}
					echo $points;
					?>
				</td>
				<?php
			}
			?>
			<td><?php echo $total; ?></td>
		</tr>
	</table>

	<br><br>

	<table width="48%" style="float: left;">
		<tr>
			<th colspan="3"><?php echo $teamname; ?></th>
		</tr>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th>Points</th>
		</tr>

		<?php
		for($i=0; $i<4; $i++) {
			if($i==0) {
				$sql = "SELECT * FROM joint WHERE team='$teamnum' and currentPos='G'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>G</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<tr>
						<td>G</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum' and currentPos='G'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<tr>
								<td>G</td>
								<td> -- </td>
								<td> 0 </td>
							</tr>
							<?php
						}
					}
				} else {
					foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum' and currentPos='G'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==1) {
				$sql = "SELECT * FROM joint WHERE team='$teamnum' and currentPos='F'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>F</td>
						<td>--</td>
						<td>0</td>
					</tr>
					<tr>
						<td>F</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<tr>
								<td>F</td>
								<td>--</td>
								<td>0</td>
							</tr>
							<?php
						}
					}
				} else {
					foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==2) {
				$sql = "SELECT * FROM joint WHERE team='$teamnum' and currentPos='X'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>X</td>
						<td>--</td>
						<td>0</td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					foreach($conn->query("SELECT * FROM joint WHERE team='$teamnum' and currentPos='X'") as $g) {
						$pnum=$g['player'];
						$total = 0;
						$pnum = mysqli_real_escape_string($conn, $pnum);
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>X</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==3) {
				foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='B'") as $b) {
					$id = $b["player"];
					$id=mysqli_real_escape_string($conn, $id);
					$total = 0;
					for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
						foreach($conn->query("SELECT * FROM playerstats WHERE player='$id' AND day='$l'") as $game) {
							$total = $total + $game['total'];
						}
					}
					foreach($conn->query("SELECT * FROM players where id='$id'") as $player) {
						?>
						<tr>
							<td>B</td>
							<td><?php echo $player["name"]; ?></td>
							<td><?php echo "$total"; ?></td>
						</tr>
						<?php
					}
				}
			}
		}

		?>
	</table>

	<table width="48%" style="float: left; margin-left: 4%;">
		<tr>
			<th colspan="3"><?php echo $otherteamname; ?></th>
		</tr>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th>Points</th>
		</tr>

		<?php
		for($i=0; $i<4; $i++) {
			if($i==0) {
				$otherteam = mysqli_real_escape_string($conn, $otherteam);
				$sql = "SELECT * FROM joint WHERE team='$otherteam' and currentPos='G'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>G</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<tr>
						<td>G</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='G'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<tr>
								<td>G</td>
								<td> -- </td>
								<td> 0 </td>
							</tr>
							<?php
						}
					}
				} else {
					$otherteam = mysqli_real_escape_string($conn, $otherteam);
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='G'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==1) {
				$otherteam = mysqli_real_escape_string($conn, $otherteam);
				$sql = "SELECT * FROM joint WHERE team='$otherteam' and currentPos='F'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>F</td>
						<td>--</td>
						<td>0</td>
					</tr>
					<tr>
						<td>F</td>
						<td> -- </td>
						<td> 0 </td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					$otherteam = mysqli_real_escape_string($conn, $otherteam);
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<tr>
								<td>F</td>
								<td>--</td>
								<td>0</td>
							</tr>
							<?php
						}
					}
				} else {
					$otherteam = mysqli_real_escape_string($conn, $otherteam);
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==2) {
				$otherteam = mysqli_real_escape_string($conn, $otherteam);
				$sql = "SELECT * FROM joint WHERE team='$otherteam' and currentPos='X'";
				$result = $conn->query($sql);
				if(mysqli_num_rows($result) == 0) {
					?>
					<tr>
						<td>X</td>
						<td>--</td>
						<td>0</td>
					</tr>
					<?php
				} else if(mysqli_num_rows($result) == 1) {
					$otherteam = mysqli_real_escape_string($conn, $otherteam);
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='X'") as $g) {
						$pnum=$g['player'];
						$pnum = mysqli_real_escape_string($conn, $pnum);
						$total = 0;
						for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
							foreach($conn->query("SELECT * FROM playerstats WHERE player='$pnum' AND day='$l'") as $game) {
								$total = $total + $game['total'];
							}
						}
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>X</td>
								<td><?php echo $player['name']; ?></td>
								<td><?php echo "$total"; ?></td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==3) {
				$otherteam = mysqli_real_escape_string($conn, $otherteam);
				foreach($conn->query("SELECT * FROM joint where team='$otherteam' AND currentPos='B'") as $b) {
					$id = $b["player"];
					$id=mysqli_real_escape_string($conn, $id);
					$total = 0;
					for($l=$firstdayofweek; $l<$lastdayofweek; $l++) {
						foreach($conn->query("SELECT * FROM playerstats WHERE player='$id' AND day='$l'") as $game) {
							$total = $total + $game['total'];
						}
					}
					foreach($conn->query("SELECT * FROM players where id='$id'") as $player) {
						?>
						<tr>
							<td>B</td>
							<td><?php echo $player["name"]; ?></td>
							<td><?php echo "$total"; ?></td>
						</tr>
						<?php
					}
				}
			}
		}
		?>
	</table>
</div>

<div id="schedule" style="display: none">
	<br>
	<table>
		<tr>
			<th>Week</th>
			<th>Opponent</th>
		</tr>
		<?php
		foreach($conn->query("SELECT * FROM schedule WHERE team='$teamnum'") as $game) {
			$gweek = $game['week'];
			$oppnum = $game['opponent'];
			$opponent = '';
			$oppnum = mysqli_real_escape_string($conn, $oppnum);
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

<br>
<div id="settings" style="display: none">
	<form method="post">
		Change Team Name:
		<?php

		?>
		<input type="text" name="teamname" value="<?php echo $teamname; ?>"  />
		<input type="submit" value="Change" onclick="teamDiv()" />
	</form>
	<?php
	$result=$conn->query("SELECT * FROM joint WHERE league='$leaguenum' AND team!='0'");
	$numDrafted = mysqli_num_rows($result);


	if($commissioner && ($numDrafted == 0)) {
		?>
		<form method="post">
			Change Draft Time: 
			<input id="dTime" type="datetime-local" name="drafttime" />
			<input type="submit" value="Change" onclick="teamDiv()" />
			<script>
			var x = document.getElementById("dTime");
			x.value=<?php echo $timeOfDraft; ?>;
			</script>
		</form>
		<?php
	}
	if($commissioner) {
		?>
		<form method="post">
			Change League Name:
			<input type="text" name="leaguename" value="<?php echo $leaguename; ?>" />
			<input type="submit" value="Change" onclick="teamDiv()" />
		</form>
		<?php
	}
	?>
</div>

<div id="drop" style="display: none"> 
	<table>
		<tr>
			<th>Position</th>
			<th>Player</th>
			<th>School</th>
			<th>Drop</th>
		</tr>
		<?php
		foreach($conn->query("SELECT * FROM joint WHERE league='$leaguenum' AND team='$teamnum'") as $pj) {
			$playerid = $pj['player'];
			$playerid = mysqli_real_escape_string($conn, $playerid);
			foreach($conn->query("SELECT * FROM players WHERE id='$playerid'") as $player) {

				$pos = $player['position'];
				$name = $player['name'];
				$school = $player['school'];
				?>

				<tr>
					<td><?php echo $pos; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $school; ?></td>
					<td><input class ='dButton' type='button' value='DROP' onclick='dropPlayer(<?php echo $playerid; ?>)' /></td>
				</tr>
				<?php
			}
		}

		?>
	</table>
</div>

<div id="rankings" style="display: none">
	<?php
	$averagePoints = array();
	$rankings = array();

	foreach($conn->query("SELECT * FROM players") as $player) {
		$id = $player["id"];

		$total = 0;
		$counter = 0;
		foreach($conn->query("SELECT * FROM playerstats WHERE player='$id'") as $statline) {
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
	foreach($conn->query("SELECT * FROM teams WHERE league='$leaguenum'") as $t) {
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



<?php
$conn->close();
?>