<?php

include "header.php";
include "createconnection.php";

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


$bsbPlayers = array();
$bsbSchools = array();
$bsbAverages = array();
$bsbRankings = array();

foreach($conn->query("SELECT * FROM baseballplayers") as $player) {
	$id = $player["id"];
	$name = $player["name"];
	$school = $player["school"];

	$totalPoints = 0;
	$count = 0;
	foreach($conn->query("SELECT * FROM baseballstats WHERE player='$id'") as $statline) {
		$totalPoints = $totalPoints + $statline["total"];
		$count++;
	}
	if($counter != 0) {
		if($total != 0) {
			$avg = $totalPoints / $count;
			array_push($bsbRankings, $id);
			array_push($bsbPlayers,$name);
			array_push($bsbSchools, $school);
			array_push($bsbAverages, $avg);
		}
	}
}

array_multisort($bsbAverages, SORT_DESC, $bsbPlayers, $bsbSchools, $bsbRankings);
?>

<script>
	function toggleBaseball() {
		var baseball = document.getElementById('baseball');
		var basketball = document.getElementById('basketball')

		baseball.style.display = 'block';
		basketball.style.display = 'none';
	}

	function toggleBasketball() {
		var baseball = document.getElementById('baseball');
		var basketball = document.getElementById('basketball')

		baseball.style.display = 'none';
		basketball.style.display = 'block';
	}

</script>

<br><br>
<div id="basketball">
	<input class="toggle" type="button" onclick="toggleBaseball()" value="Baseball" />
	<table>
		<tr>
			<th colspan="4">Basketball</th>
		<tr>
			<th>Rank</th>
			<th>Player Name</th>
			<th>School</th>
			<th>Average Points</th>
		</tr>
		<?php
		for($i=0; $i<count($averagePoints); $i++) {
			?>
			<tr>
				<td><?php echo ($i + 1); ?></td>
				<td><?php echo $playerNames[$i]; ?></td>
				<td><?php echo $schoolNames[$i]; ?></td>
				<td><?php echo substr($averagePoints[$i],0,5); ?></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>

<div id="baseball" style="display: none">
	<input class="toggle" type="button" onclick="toggleBasketball()" value="Basketball" />
	<table>
		<tr>
			<th colspan="4">Baseball</th>
		<tr>
		<tr>
			<th>Rank</th>
			<th>Player Name</th>
			<th>School</th>
			<th>Average Points</th>
		</tr>
		<?php
		for($i=0; $i<count($bsbAverages); $i++) {
			?>
			<tr>
				<td><?php echo ($i + 1); ?></td>
				<td><?php echo $bsbPlayers[$i]; ?></td>
				<td><?php echo $bsbSchools[$i]; ?></td>
				<td><?php echo substr($bsbAverages[$i],0,5); ?></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>


<?php
$conn->close();
?>


