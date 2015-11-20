<?php

include "createconnection.php";
include "style.php";

$teamname='';
$teamnum = 38;
$leaguenum = 23;

?>
<script>
function dropPlayer($playerID) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		}
	}
	//xhttp.open("POST", "dropplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID);
}
</script>


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
				<td><input type='button' value='DROP' onclick='dropPlayer(<?php echo $playerid; ?>)' /></td>
			</tr>
			<?php
		}
	}

	?>
</table>
