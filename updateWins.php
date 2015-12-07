<?php
include "createconnection.php";
$week = $_POST["week"];

for($i=0; $i<$week; $i++) {
	foreach($conn->query("SELECT * FROM teams") as $t) {
		$id=$t['id'];
		$teampts = 0;
		$opponentpts = 0;
		foreach($conn->query("SELECT * FROM teamstats WHERE team='$id' AND week='$i'") as $game) {
			$teampts = 0;
			$opponentpts = 0;
			$opp = $game['opponent'];
			$day = $i + $week * 7;
			foreach($conn->query("SELECT * FROM teamstats WHERE team='$opp' AND day='$day'") as $d) {
				$opponentpts = $opponentpts + $d["total"];
			}
			foreach($conn->query("SELECT * FROM teamstats WHERE team='$id' AND day='$day'") as $d) {
				$teampts = $teampts + $d["total"];
			}
		}
		foreach($conn->query("SELECT * FROM schedule WHERE team='$id'") as $s) {
			echo "!";

			if($teampts < $opponentpts) {
				$s["result"] = 'W';
			} else {
				$s["result"] = 'L';
			}
		}
	}
}
			
