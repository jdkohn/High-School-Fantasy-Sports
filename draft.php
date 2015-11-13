<?php

include "header.php"; 
include "createconnection.php";

$team = 8;

foreach ( $conn->query("SELECT * FROM teams where id='$team'") as $row ) {

	$team = $row;

}

$leaguenum=$team["league"];
$teamnum=$team["id"];


?>
	<table>
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
					<td><input type="button" value="Draft" />
					</td>
				</tr>
				<?php
			}

		}
		?>
	</table>
<?php
	$conn->close()
?>