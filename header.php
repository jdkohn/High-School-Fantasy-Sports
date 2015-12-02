<?php

include "style.php";

session_start();

if(!isset($_SESSION["username"])) { 
	header( 'Location: logout.php');
}

echo "Hello, " . $_SESSION["firstname"] . "! Welcome to High School Fantasy Basketball!";

$starttime = 1448755200;

$day = ((int) ((time() - $starttime) / (60*60*24)));

if($day >=0) {
	$week = ((int) ($day / 7));
} else {
	$week = 0;
	$day = 0;
}

?>

<html>
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
</html>

