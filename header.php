<?php


session_start();

if(!isset($_SESSION["username"])) { 
	header( 'Location: logout.php');
}

echo "Hello, " . $_SESSION["firstname"] . "! Welcome to High School Fantasy Basketball!";

?>

<html>
<a href="logout.php" class="HeaderButtons" align="right"><input class="HeaderButtons" align="right" type="button" value="Log Out" /></a>


<br><br>
<a href="home.php" class="HeaderButtons"><input class="HeaderButtons" type="submit" value="Home" /></a>
<a>		</a>
<a href="http://www.espn.go.com" class="HeaderButtons"><input class="HeaderButtons" type="submit" value = "My Teams" /></a>
<a>		</a>
<a href="http://www.espn.go.com" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "My Leagues" /></a>
<a>		</a>
<a href="createleague.php" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "Create League" /></a>
<a>		</a>
<a href="http://www.espn.go.com" class="HeaderButtons"><input class="HeaderButtons" type="button" value = "Join League" /></a>
</html>


<style>
input.HeaderButtons {
width: 120px;
height: 35px;
padding: 5px;
font-weight: bold;
font-size: 90%;
background: white;
color: black;
cursor: pointer;
border: 1px solid #999999;

}
input.HeaderButtons:hover {
color: white;
background: black;
border: 1px solid #000033;
}
</style>
