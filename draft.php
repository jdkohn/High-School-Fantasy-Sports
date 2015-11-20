<?php

include "header.php"; 
include "createconnection.php";

$team = $_GET["team"];

foreach ( $conn->query("SELECT * FROM teams where id='$team'") as $row ) {

	$team = $row;

}

$leaguenum=$team["league"];
$teamnum=$team["id"];

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
for($i=0; $i<$numteams; $i++) {
		array_push($order, $teams[$i]);
}

$picks = "SELECT * FROM draft WHERE league='$leaguenum'";
$result = $conn->query($picks);
$numpicks=mysqli_num_rows($result);

$ontheclock = $order[$numpicks];

?>
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
		}
	}
	xhttp.open("POST", "draftplayer.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("player=" + $playerID + "&team=" + <?php echo "$teamnum"; ?> + "&league=" + <?php echo "$leaguenum"; ?>);

	update_content();
	update_content();
}

function updateEverySecond() {
    setInterval(update_content(), 5000);
}


</script>

<br><br>

<table width="23%" style="float: left;">
	<tr>
		<th>Draft Order</th>
	</tr>

	<?php
		foreach($conn->query("SELECT * FROM draft WHERE league='$leaguenum'") as $pick) {
			$team = $pick['team'];
			$player= $pick['player'];

			$teamname='';
			$playername='';

			foreach($conn->query("SELECT * FROM teams WHERE id='$team'") as $teamresult) {
				$teamname=$teamresult['name'];
			}

			foreach($conn->query("SELECT * FROM players WHERE id='$player'") as $playerresult) {
				$playername = $playerresult['name'];
			}

			?>

			<tr>
				<td><?php echo $teamname . " picked " . $playername; ?></td>
			</tr>
			<?php
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
	foreach($conn->query("SELECT * FROM joint where team='0' AND league=$leaguenum") as $current) {
		$id = $current["player"];
		foreach($conn->query("SELECT * FROM players where id=$id") as $player) {
			?>
			<tr>
				<td><?php echo $player["name"]; ?></td>
				<td><?php echo $player["school"]; ?></td>
				<td><?php echo $player["position"]; ?></td>
				<td>
					<input type="button" value="Draft" onclick="draft(<?php echo $player['id']; ?>)" />
				</td>
			</tr>
			<?php
		}

	}
	?>
</table>
<?php
} else {
?>
<script type="text/javascript">
  updateEverySecond();
</script>
<table width="50%" style="float: left; margin-left:2%;">
	<tr>
		<th>Player Name</th>
		<th>School</th>
		<th>Position</th>
		<th>Draft!</th>
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
					<input type="button" value="--" onclick="" />
				</td>
			</tr>
			<?php
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

			foreach($conn->query("SELECT * FROM players WHERE id='$player'") as $playerresult) {
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