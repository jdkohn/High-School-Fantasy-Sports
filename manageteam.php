<?php

include "createconnection.php";



?>


<table>
	<tr>
		<th>Position</th>
		<th>Player</th>
		<th>School</th>
		<th>PPG</th>
		<th>RPG</th>
		<th>APG</th>
	</tr>
		<?php
		$counter = 0; 
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
				</tr>
				<?php
				$counter++;
			}

		?>

	</table>
	</html>
