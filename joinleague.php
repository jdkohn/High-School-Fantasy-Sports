<?php

include "header.php";

echo "<br><br>";

?>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}

input.joinButton {
  width: 80px;
  height: 30px;
  padding: 5px;
  font-weight: bold;
  font-size: 90%;
  background: blue;
  color: white;
  cursor: pointer;
  border: 1px solid white;
} 
input.joinButton:hover {
  color: blue;
  background: white;
  border: 1px solid blue;
}

</style>

<html>

 
<script>
function addteam($leaguenum) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {

    }
  }
  xhttp.open("POST", "addteam.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("leaguenum=" + $leaguenum);
}
</script>

<table style="width:100%">
  <tr>
    <th>League Name</th>
    <th>Members</th>
    <th>Draft Date</th>
    <th>Access</th>
    <th>Join</th>
  </tr>

  <?php 
  $servername = "localhost";
  $username = "hsfantasyball";
  $password = "2016";
  $dbname = "fantasyball";

      // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 


  foreach ( $conn->query("SELECT * FROM leagues") as $row ) {
    $leaguenum=$row["id"];
    $sssql = "SELECT * FROM teams WHERE league=$leaguenum";
    $result = $conn->query($sssql);
    if($result->num_rows <= $row["numteams"]) {
      ?>
      <tr>
        <th><?php echo $row["leaguename"]; ?></th>
        <th><?php echo $result->num_rows . "/" . $row["numteams"]; ?></th>
        <th><?php echo $row["draftdate"]; ?></th>
        <th><?php if(is_null($row["password"])) { echo "Public"; } else { echo "Private"; } ?></th>
        <th>
            <input class="joinButton" type="button" value="Join" onclick="addteam(<?php echo $row["id"]; ?>)" />
          </th>
      </tr>
      <?php
    }
  }  

function joinLeague($leaguenum) {
  $owner = $_SESSION["id"];
  $teamname = "Team " . $_SESSION["firstname"];

  $addteam = "INSERT INTO teams (owner, name, league) VALUES ('$owner', '$teamname', '$leaguenum')";

      if ($conn->query($addteam) == TRUE) {
          //header( 'Location: home.php' );
      } else {
          echo "Error: " . $addteam . "<br>" . $conn->error;
      }
}

$conn->close(); 
?>

</table>
</html>
