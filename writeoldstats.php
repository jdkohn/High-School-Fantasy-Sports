<?php

include "createconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name=$_POST['name'];
	$school=$_POST['team'];
	$position = $_POST['position'];

		$addplayer = "INSERT INTO players (name,school,position) VALUES ('$name','$school','$position')";
		if($conn->query($addplayer) == TRUE) {

		} else {
			echo "Error: " . $addstats . "<br>" . $conn->error;
		}
	}
		?>


		<html>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<a>Name: </a>
			<input type="text" name="name">
			<br>
			<a> School: </a>
			<select name="team" id="chooseteam">
				<option value="Garfield">Garfield</option>
				<option value="Rainer Beach">Rainer Beach</option>
				<option value="Nathan Hale">Nathan Hale</option>
				<option value="Odea">O'Dea</option>
				<option value="Ingraham">Ingraham</option>
				<option value="Roosevelt">Roosevelt</option>
				<option value="Lakeside">Lakeside</option>
				<option value="Bishop Blanchet">Blanchet</option>
				<option value="Seattle Prep">Prep</option>
				<option value="West Seattle">West Seattle</option>
				<option value="Cheif Sealth">Sealth</option>
				<option value="Eastside Catholic">Eastside</option>
				<option value="Franklin">Franklin</option>
				<option value="Cleveland">Cleveland</option>
				<option value="Bainbridge">Bainbridge</option>
				<option value="Ballard">Ballard</option>
			</select>
			<br>
			<a>Position </a>
			<input type="text" name="position">
			<input type="submit" value="submit">
		</form>

		</html>
