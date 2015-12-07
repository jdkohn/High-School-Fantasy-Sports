<?php
include "header.php";
include "createconnection.php";

$team = "";
date_default_timezone_set('America/Los_Angeles');


if($_SESSION["id"] == 7) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!empty($_POST['week'])) {

			for($i=0; $i<$week; $i++) {
				foreach($conn->query("SELECT * FROM teams") as $t) {
					$id=$t['id'];
					$teampts = 0;
					$opponentpts = 0;
					for($l=0; $l<7; $l++) {
						$day = ($i * 7) + $l;

							$opp = "";
							foreach($conn->query("SELECT * FROM schedule WHERE team='$id' AND week='$i'") as $s) {
								$opp = $s['opponent'];
							}


							foreach($conn->query("SELECT * FROM teamstats WHERE team='$opp' AND day='$day'") as $d) {
								$opponentpts = $opponentpts + $d["total"];
							}
							foreach($conn->query("SELECT * FROM teamstats WHERE team='$id' AND day='$day'") as $d) {
								$teampts = $teampts + $d["total"];
							}

							echo $id . "-" . $day . ": " . $teampts . "<br>";

						}
					foreach($conn->query("SELECT * FROM schedule WHERE team='$id' AND week='$i'") as $s) {

						if($teampts > $opponentpts) {
							$s["result"] = 'W';
							echo "W for: " . $id . "<br>";
							$conn->query("UPDATE schedule SET schedule.result='W' WHERE schedule.team='$id' AND schedule.week='$i'");
						} else {
							$s["result"] = 'L';
							echo "L for: " . $id . "<br>";
							$conn->query("UPDATE schedule SET schedule.result='L' WHERE schedule.team='$id' AND schedule.week='$i'");
						}
					}
				}
			}
		} else if(!empty($_POST['team'])) {
			$team = $_POST['team'];
			?>
			<script>
			update_content();
			</script>
			<?php
		} else if(!empty($_POST['dayToUpdate'])) {
			$day = $_POST['dayToUpdate'];
			$day = strtotime($day);
			$starttime = 1448755200;
			$day = ((int) (($day - $starttime) / (60*60*24)));


			if($conn->query("DELETE FROM teamstats WHERE day='$day'") == FALSE) {
				echo "!";
			}

			$total = 0;
			foreach($conn->query("SELECT * FROM teams") as $t) {
				$teamID = $t["id"];
				$total = 0;
				foreach($conn->query("SELECT * FROM joint WHERE team='$teamID' AND currentPos!='B'") as $p) {
					$playerID = $p['player'];
					foreach($conn->query("SELECT * FROM playerstats WHERE player='$playerID' AND day='$day'") as $g) {
						$total = $total + $g["total"];
					}
				}
				$conn->query("INSERT INTO teamstats (team,day,total) VALUES ('$teamID','$day','$total')");
			}
		} else {
			$id = $_POST["player"];
			$id = mysqli_real_escape_string($conn, $id);

			$points = $_POST["points"];
			if(empty($points)) {
				$points = 0;
			} else {
				$points = mysqli_real_escape_string($conn, $points);
			}
			


			$assists = $_POST["assists"];
			if(empty($assists)) {
				$assists = 0;
			} else {
				$assists = mysqli_real_escape_string($conn, $assists);
			}

			$rebounds = $_POST["rebounds"];
			if(empty($rebounds)) {
				$rebounds = 0;
			} else {
				$rebounds = mysqli_real_escape_string($conn, $rebounds);
			}


			if(!empty($_POST["day"])) {
				$day = $_POST["day"];
				$day = strtotime($day);

				$starttime = 1448755200;

				$day = ((int) (($day - $starttime) / (60*60*24)));
			} else {
				$day = $day + 1;
			}

			$fantasypoints = ($points + $assists + $rebounds);

			$conn->query("DELETE FROM playerstats WHERE day='$day' AND player='$id'");

			$addStatLine = "INSERT INTO playerstats (player, day, points, rebounds, assists, total) VALUES ('$id', '$day', '$points', '$rebounds', '$assists','$fantasypoints')";

			if($conn->query($addStatLine) == TRUE) {
				echo "<br> Added stat line for player: " . $id . "<br>";
			}
		}
	}
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

function update_content(){
	$.ajax({
		type: "GET",
      url: "addPlayerStat.php", // post it back to itself - use relative path or consistent www. or non-www. to avoid cross domain security issues
      cache: false, // be sure not to cache results
  })
	.done(function( page_html ) {
		var newDoc = document.open("text/html", "replace");
		newDoc.write(page_html);
		newDoc.close();
	});   
}
</script>



<html>

<br><br>
Team:
<form method="POST">
	<select name="team"><option value="Nathan Hale">Hale</option><option value="Garfield">Garfield</option><option value="Rainer Beach">Beach</option><option value="Odea">O'Dea</option><option value="Roosevelt">Roosevelt</option><option value="Lakeside">Lakeside</option><option value="Franklin">Franklin</option><option value="Bishop Blanchet">Blanchet</option><option value="Seattle Prep">Prep</option><option value="West Seattle">West Seattle</option><option value="Eastside Catholic">Eastside</option><option value="Cleveland">Cleveland</option><option value="Bainbridge">Bainbridge</option><option value="Rainer Beach">Beach</option><option value="Ballard">Ballard</option></select>
	<br>
	<input type="submit" value="go"> 
</form>
<br>
<form method="POST">
	Player:
	<select name="player">
		<option value="">--</option>
		<?php
		foreach($conn->query("SELECT * FROM players WHERE school = '$team'") as $p) {
			?>
			<option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
			<?php
		}
		?>
	</select>
	<br>
	Points:
	<input type="text" name="points"><br>
	Assists:
	<input type="text" name="assists"><br>
	Rebounds:
	<input type="text" name="rebounds"><br>
	Day:
	<input type="date" name="day"> <input type="submit" value="go"> <br>
</form>

<br><br>

<form method="POST">
	Update Team Stats for One Day:
	<input type="date" name="dayToUpdate"> <input type="submit" value="go"><br>
</form>

<br>
<form method="POST">
	Update Win/Loss:
	<input type="date" name="week"><input type="submit">
	</html>