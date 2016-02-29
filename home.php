<?php

include "style.php";

session_start();

if(isset($_SESSION["firstname"])) {
	echo "Hello, " . $_SESSION["firstname"] . "! Welcome to High School Fantasy Basketball!";

?>

<html>

<head>
<title>Home</title>
</head>

<a href="logout.php" class="HeaderButtons" align="right"><input class="HeaderButtons" align="right" type="button" value="Log Out" /></a>



<br><br>
<a href="home.php" class="HeaderButtons"><input class="HeaderButtons" type="submit" value="Home" /></a>
<a>		</a>
<a href="myteams.php" class="HeaderButtons"><input class="HeaderButtons" type="submit" value = "My Teams" /></a>
<a>		</a>
<a href="createleague.php" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "Create League" /></a>
<a>		</a>
<a href="joinleague.php" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "Join League" /></a>
<a>		</a>
<a href="news.php" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "News" /></a>
<a>		</a>
<a href="playerrankings.php" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "Rankings" /></a>
<br><br>
<div align="center">
<a href="https://itunes.apple.com/us/app/seattle-metro-fantasy-sports/id1079516397?mt=8"><input class="appButton" type="submit" value="iPhone App" /></a>
<br>
<h2>High School Fantasy Baseball Coming This Spring<h2>
</div>
</html>

<?php
} else {
?>

<div align="center">
<h2>Welcome to High School Fantasy Basketball</h2>

<p>Have you ever played fantasy basketball using players from the NBA like Lebron James and Steph Curry? Well,
	this is just like that, with one main difference: all players in these fantasy leagues are high school students
	in Seattle, Washington's Metro League. This league, comprised of sixteen high schools, is one of the best high school
	leagues in the country. There are more alumni from the 16 schools in Seattle's Metro League playing in the NBA than
	there are alumni from New York City's 799 high schools playing in the NBA. Make a league with your friends and draft
	today!</p>

	

<a href="login.php" class="HeaderButtons"><input class="HeaderButtons" type="submit" value="Login" /></a>
<a href="createaccount.php" class="HeaderButtons"><input class="HeaderButtons" type="submit" value="Join" /></a>

</div>

</html>
<?php
}
?>
