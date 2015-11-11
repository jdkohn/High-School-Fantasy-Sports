<?php

include "header.php";
include "createconnection.php";

$team = $_GET["id"];

foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {

	$team = $row;

}

$leaguenum=$team["league"];
$teamnum=$team["id"];

$teamplayers="0";


foreach($conn->query("SELECT * FROM joint where team='$team[id]'") as $dumb) {
	$teamplayers++;
}


echo "<br><br>";


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

function leagueDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'block';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
};

function teamDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'block';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
};

function playersDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'block';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'none';
};

function standingsDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'block';
	schedule.style.display = 'none';
	settings.style.display = 'none';
};

function scheduleDiv() {
	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');
	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'block';
	settings.style.display = 'none';
};



function settingsDiv() {

	var league = document.getElementById('league');
	var team = document.getElementById('team');
	var players = document.getElementById('players');
	var standings = document.getElementById('standings');
	var schedule = document.getElementById('schedule');
	var settings = document.getElementById('settings');

	league.style.display = 'none';
	team.style.display = 'none';
	players.style.display = 'none';
	standings.style.display = 'none';
	schedule.style.display = 'none';
	settings.style.display = 'block';

};

function update_content(){
    $.ajax({
      type: "GET",
      url: "team.php?id=<?php echo '$team'; ?>", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
    })
      .done(function( page_html ) {
    var newDoc = document.open("text/html", "replace");
    newDoc.write(page_html);
    newDoc.close();
    });   
}


function addplayer($playerID, $currNumPlayers) {
		
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
}

function moveplayer($currPos, $player, $pos) {
	if($pos == 'G') {
	var ghere = document.getElementById('ghere');
	var gblank = document.getElementById('gblank');
	ghere.style.display = 'block';
	gblank.style.display = 'none';
	} else {
	var fhere = document.getElementById('fhere');
	var fblank = document.getElementById('fblank');
	fhere.style.display = 'block';
	fblank.style.display = 'none';
	}

	

	if (typeof(Storage) !== "undefined") {
    // Store
    localStorage.setItem("currentPlayer", $player);
} 
}

function finalizeMove($moveTo) {
		var $playerID = localStorage.getItem("currentPlayer");
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			}
		}
		xhttp.open("POST", "moveplayer.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("player=" + $playerID + "&newpos=" + $moveTo + "&league=" + <?php echo "$leaguenum"; ?>);

		update_content();
		update_content();

}


</script>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$newname=$_POST["teamname"];


	$changename = "UPDATE teams SET name='$newname' WHERE id='$teamnum'";
	if ($conn->query($changename) == TRUE) {
		header( 'Location: myteams.php' );
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}

?>

<html>

<input class="TeamButtons" type="button" value="League" onclick="leagueDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="MyTeam" onclick="teamDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Add Players" onclick="playersDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Standings" onclick="standingsDiv()" />
<a>  </a>
<input class="TeamButtons" type="button" value="Schedule" onclick="scheduleDiv()" />
<a>  </a>
<input class="TeamSettingsButton" type="button" value="Settings" onclick="settingsDiv()" />

<br>

<element id="league" style="display: none">This is the League Page :)</element>

<div id="team" >

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
		$totalPlayers = 0;
		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='G'") as $current) {
			$id = $current["player"];
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>G</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td><input type="button" id="gmove" value="Move" />
						<input type="button" id="ghere" value="Here" style="display: none" onclick="finalizeMove(<?php echo $counter; ?>)" />
					</td>
				</tr>
				<?php
			}
		}
		while($counter < 2) {
			?>
			<tr>
				<td>G</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td><div id="gblank">--</div>
				<input type="button" id="ghere" value="Here" style="display: none" onclick="finalizeMove(<?php echo $counter; ?>)" />
			</td>
			</tr>
			<?php
			$counter++;
		}

		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='F'") as $current) {
			$id = $current["player"];
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>F</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td><input type="button" id="fmove" value="Move"/>
					<input type="button" id="fhere" value="Here" style="display: none" onclick="finalizeMove(<?php echo $counter; ?>)" />
				</td>
				</tr>
				<?php
			}

		}
		while($counter < 4) {
			?>
			<tr>
				<td>F</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td><div id="fblank">--</div>
				<input type="button" id="fhere" value="Here" style="display: none" onclick="finalizeMove(<?php echo $counter; ?>)" />
			</td>
			</tr>
			<?php
			$counter++;
		}

		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='X'") as $current) {
			$id = $current["player"];
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>FLEX</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td><input type="button" id="xmove" value="Move" /></td>
				</tr>
				<?php
			}

		}

		while($counter < 5) {
			?>
			<tr>
				<td>FLEX</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>--</td>
			</tr>
			<?php
			$counter++;
		}
		foreach($conn->query("SELECT * FROM joint where team='$teamnum' AND currentPos='B'") as $current) {
			$id = $current["player"];
			$counter++;
			foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
				?>
				<tr>
					<td>BENCH</td>
					<td><?php echo $player["name"]; ?></td>
					<td><?php echo $player["school"]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td><input type="button" id="bmove" value="Move" onclick="moveplayer('B',<?php echo $id; ?>, '<?php echo $player['position']; ?>')" /></td>
				</tr>
				<?php
			}

		}

		while($counter < 7) {
			?>
			<tr>
				<td>BENCH</td>
				<td>--</td>
				<td>--</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>--</td>
			</tr>
			<?php
			$counter++;
		}

		?>

	</table>
</div>

<div id="players" style="display: none">

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
					<td><input type="button" value="+" onclick="addplayer(<?php echo $player['id']; ?>, <?php echo $teamplayers; ?>)" />
				</td>
			</tr>
			<?php
		}

	}
	?>

</table>
</div>

<div id="standings" style="display: none">Standings</div>

<div id="schedule" style="display: none">Schedule</div>

<br>
<div id="settings" style="display: none">
	<form method="post">
		Change Team Name:
		<input type="text" name="teamname" value="<?php echo $team['name']; ?>"  />
		<input type="submit" value="Change" />
	</form>
</div>





<?php
$conn->close();
?>