<?php

include "header.php";
include "createconnection.php";

$team = $_GET["id"];

foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {

	$team = $row;

}


echo "<br><br>";


?>


<script>

	function divOne() {
		window.alert("!");
		document.getElementById('league').style.display = "block";
		document.getElementById('team').style.display = "none";
	}

	function divTwo() {
		window.alert("!");
		document.getElementById('league').style.display = "none";
		document.getElementById('team').style.display = "block";
	}


}


</script>

<html>

<input class="TeamButtons" type="button" value="League" onclick="divOne()" />
<a>  </a>
<input class="TeamButtons" type="button" value="MyTeam" onclick="divTwo()"/>
<a>  </a>
<input class="TeamButtons" type="button" value="Add Players" />
<a>  </a>
<input class="TeamButtons" type="button" value="Standings" />
<a>  </a>
<input class="TeamButtons" type="button" value="Schedule" />


<div id="league">This is the League Page :)</div>

<div id="team" style="display: none;">Team</div>

</html>







<?php
	$conn->close();
?>