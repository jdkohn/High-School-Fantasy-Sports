<?php

include "createconnection.php";
include "style.php";




$team = $_GET["id"];

foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {

	$team = $row;

}

$leaguenum=$team["league"];
$teamnum=$team["id"]

$teamplayers="0";


foreach($conn->query("SELECT * FROM joint where team='$team[id]'") as $dumb) {
	$teamplayers++;
}


}


?>

<html>
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
				</tr>
				<?php
			}

		}
		?>

	</table>
	</html>


