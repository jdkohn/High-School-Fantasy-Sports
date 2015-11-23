<?php

include "header.php";
include "createconnection.php";

$team = $_GET["id"];


foreach ( $conn->query("SELECT * FROM teams where id='$team'") as $row ) {

	$team = $row;

}
$teamname = $team['name'];
$leaguenum=$team["league"];
$teamnum=$team["id"];

$teamplayers="0";


foreach($conn->query("SELECT * FROM joint where team='$team[id]'") as $dumb) {
	$teamplayers++;
}


echo "<br>";


$week = 1;

$result = $conn->query("SELECT * FROM teams WHERE league='$leaguenum'");
$numteams = mysqli_num_rows($result);

$drafttime='';
date_default_timezone_set('America/Los_Angeles');
foreach($conn->query("SELECT * FROM leagues WHERE id='$leaguenum'") as $lll) {
	$drafttime = $lll['draftdate'];
}

?>

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

};

function update_content(){
	$.ajax({
		type: "GET",
      url: "team.php?id=<?php echo $team["id"]; ?>", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
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
		}
	}
	xhttp.open("POST", "dropplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&playerToAdd=" + $playerToAdd + "&league=" + <?php echo $leaguenum; ?> + "&team=" + <?php echo $teamnum; ?>);

	var team = document.getElementById('team');
	var players = document.getElementById('drop');
	team.style.display = 'block';
	players.style.display = 'none';

	update_content();
	update_content();
}

function addplayer($playerID, $currNumPlayers) {
	if($currNumPlayers != 7) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			}
		}
		xhttp.open("POST", "addplayer.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("playerid=" + $playerID + "&numplayers=" + $currNumPlayers + "&teamnum=" + <?php echo "$teamnum"; ?>);

		update_content();
		update_content();

		var team = document.getElementById('team');
		var players = document.getElementById('players');
		team.style.display = 'block';
		players.style.display = 'none';
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
		}
	}
	xhttp.open("POST", "moveplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&newpos=" + $moveTo + "&league=" + <?php echo "$leaguenum"; ?> + "&currentposition=" + $currPos);

	update_content();
	update_content();

}

function draft() {
	location.href = "draft.php?team=<?php echo $teamnum; ?>";
}


</script>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$newname=$_POST["teamname"];


	$changename = "UPDATE teams SET name='$newname' WHERE id='$teamnum'";
	if ($conn->query($changename) == TRUE) {
		?>
		<script type="text/javascript">
		update_content();
		</script>
		<?php

	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}

?>

<html>

<h1><?php echo "$team[name]"; ?></h1>


<input class="TeamButtons" type="button" value="League" onclick="leagueDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="MyTeam" onclick="teamDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Add Players" onclick="playersDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Standings" onclick="standingsDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Matchup" onclick="scoreboardDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Schedule" onclick="scheduleDiv()" />
<a>  </a>
<input class="TeamSettingsButton" type="button" value="Settings" onclick="settingsDiv()" />
<a>  </a>
<?php
if((time()+(60*60*1)) > strtotime($drafttime)) {
?>
<input class="dButton" type="submit" value="Draft" id="goToDraft" onclick="draft()" />
<br>
<?php
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
				<th colspan="2">
					Games This Week
				</th>
			</tr>
			<tr>
				<td>Home</td>
				<td>Away</td>
			</tr>

<?php
for($i=0;$i<$numGames; $i++) {
	$tt = $teams[0];
	foreach($conn->query("SELECT * FROM schedule WHERE team='$tt' AND week='$week'") as $currentGame) {
		?>
			<tr>
				<?php
				$hometeamname = '';
				foreach($conn->query("SELECT * FROM teams WHERE id='$tt'") as $home) {
					$hometeamname = $home['name'];
				}
				$opponent=$currentGame['opponent'];
				$awayteamname = '';
				foreach($conn->query("SELECT * FROM teams WHERE id='$opponent'") as $o) {
					$awayteamname=$o['name'];
				}
				for($i=0;$i<count($teams); $i++) {
					if($teams[$i] == $tt || $teams[$i] == $opponent) {
						unset($teams[$i]);
					}
				}
				?>
				<td><?php echo $hometeamname; ?></td>
				<td><?php echo $awayteamname; ?></td>
			</tr>
				<?php
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
		$g = "SELECT * FROM joint WHERE team='$team[id]' AND currentPos='G'";
		$result = $conn->query($g);
		$numguards=mysqli_num_rows($result);

		$numforwards=0;
		$f = "SELECT * FROM joint WHERE team='$team[id]' AND currentPos='F'";
		$result = $conn->query($f);
		$numforwards=mysqli_num_rows($result);

		$numflex=0;
		$x = "SELECT * FROM joint WHERE team='$team[id]' AND currentPos='X'";
		$result = $conn->query($x);
		$numflex=mysqli_num_rows($result);

		$numbench=0;
		$b = "SELECT * FROM joint WHERE team='$team[id]' AND currentPos='B'";
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
				foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
					?>
					<tr>
						<td>G</td>
						<td><?php echo $player["name"]; ?></td>
						<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
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
				foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
					?>
					<tr>
						<td>G</td>
						<td><?php echo $player["name"]; ?></td>
						<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
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
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>F</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
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
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>F</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
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
		$counter++;
		foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
			?>
			<tr>
				<td>FLEX</td>
				<td><?php echo $player["name"]; ?></td>
				<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
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
		$counter++;
		foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
			?>
			<tr>
				<td>BENCH</td>
				<td><?php echo $player["name"]; ?></td>
				<td><?php echo $player["school"] . ", " . $player["position"]; ?></td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
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
		foreach($conn->query("SELECT * FROM joint where team='0' AND league=$leaguenum") as $current) {
			$id = $current["player"];
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
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
		?>

	</table>
</div>

<div id="standings" style="display: none">
	<br>
	<?php

	$teamname='';
	$team = $teamnum;
	$league = $leaguenum;

	$teams = array();

	foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
		array_push($teams, $uno['id']);
	}

	$teamresult = array();
	for($i=0;$i<count($teams);$i++) {
		$current = $teams[$i];

		$totalwins = 0;
		foreach($conn->query("SELECT * FROM schedule WHERE team='$current'") as $game) {
			if($game['result'] == 'W') {
				$totalwins++;
			}
		}
		array_push($teamresult,(array($current, $totalwins)));
	}

	$standings = array();

	$numteams = count($teams);

	for($l = 0; $l<$numteams; $l++) {

		$greatest = $teamresult[0][1];

		$greatestteamnum = $teamresult[0][0];

		if(count($teamresult) != 1) {
			for($i = 1; $i<count($teams); $i++) {

				if($teamresult[$i][1] > $greatest) {
					$greatest = $teamresult[$i][1];
					$greatestteamnum = $teamresult[$i][0];
				}
			}
		}


		array_push($standings, $greatestteamnum);


		$cop = array();
		if(count($teamresult) != 1) {
			for($q=0; $q<count($teams); $q++) {
				if($q != $greatest) {
					array_push($cop, $teamresult[$q]);
				}
			}
		}


		$teamresult = array();

		for($q=0; $q<count($cop); $q++) {
			array_push($teamresult, $cop[$q]);
		}
	}
	?>

	<table>
		<tr>
			<th>Team Name</th>
			<th>Wins</th>
			<th>Losses</th>
		</tr>
		<?php
		for($i=0;$i<count($standings);$i++) {
			$currentteam = $standings[$i];
			$numwins = 0;
			$numlosses = 0;
			$name = '';
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
		</tr>

		<tr>
			<td><?php echo $teamname; ?></td>
			<?php
			for($i=1; $i<=7; $i++) {
				?>
				<td>
					<?php
					$day = ($i + 7 * $week);
					$points = 0;
					foreach($conn->query("SELECT * FROM teamstats WHERE day='$day' AND team='$teamnum'") as $dailyscore) {
						$points = $dailyscore['total'];
					}
					echo $points;
					?>
				</td>
				<?php
			}
			?>
		</tr>
		<tr>
			<td><?php echo $otherteamname; ?></td>
			<?php
			for($i=1; $i<=7; $i++) {
				?>
				<td>
					<?php
					$day = ($i + 7 * $week);
					$points = 0;
					foreach($conn->query("SELECT * FROM teamstats WHERE day='$day' AND team='$otherteam'") as $dailyscore) {
						$points = $dailyscore['total'];
					}
					echo $points;
					?>
				</td>
				<?php
			}
			?>
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
		for($i=0; $i<3; $i++) {
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td>0</td>
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td>0</td>
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>X</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
							</tr>
							<?php
						}
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
		for($i=0; $i<3; $i++) {
			if($i==0) {
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
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
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
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='G'") as $g) {
						$pnum=$g['player'];
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>G</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==1) {
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
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td>0</td>
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
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='F'") as $g) {
						$pnum=$g['player'];
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>F</td>
								<td><?php echo $player['name']; ?></td>
								<td>0</td>
							</tr>
							<?php
						}
					}
				}
			}
			if($i==2) {
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
					foreach($conn->query("SELECT * FROM joint WHERE team='$otherteam' and currentPos='X'") as $g) {
						$pnum=$g['player'];
						foreach($conn->query("SELECT * FROM players WHERE id='$pnum'") as $player) {
							?>
							<tr>
								<td>X</td>
								<td><?php echo $player['name']; ?></td>
								<td> 0 </td>
							</tr>
							<?php
						}
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
			foreach($conn->query("SELECT * FROM teams WHERE id ='$oppnum'") as $opp) {
				$opponent = $opp['name'];
			}
			?>
			<tr>
				<td><?php echo $gweek; ?></td>
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





<?php
$conn->close();
?>