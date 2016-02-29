<?php

include "header.php";
include "style.php";

echo "<br><br>";

?>

<html>

<head>
<title>Join League</title>
</head>

<script>
function addteam($leaguenum, $noPass) {
  if($noPass == "1") {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        document.location.href="myteams.php";
      }
    }
    xhttp.open("POST", "addteam.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("leaguenum=" + $leaguenum + "&password=9q4fd6bppl04s");
  } else {
    var password = prompt("Please enter the league password", "");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        document.location.href="myteams.php";
      }
    }
    xhttp.open("POST", "addteam.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("leaguenum=" + $leaguenum + "&password=" + password);
  }
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
  include "createconnection.php";


  foreach ( $conn->query("SELECT * FROM leagues WHERE sport = 'B'") as $row ) {
    $leaguenum=$row["id"];
    $leaguenum = mysqli_real_escape_string($conn, $leaguenum);
    $sssql = "SELECT * FROM teams WHERE league=$leaguenum";
    $result = $conn->query($sssql);
    if(mysqli_num_rows($result) < $row["numteams"]) {
      ?>
      <tr>
        <td><?php echo $row["leaguename"]; ?></td>
        <td><?php echo mysqli_num_rows($result) . "/" . $row["numteams"]; ?></td>
        <td><?php echo $row["draftdate"]; ?></td>
        <td><?php if(is_null($row["password"])) { echo "Public"; } else { echo "Private"; } ?></td>
        <td>
          <div align="center">
          <input class="joinButton" type="button" value="Join" onclick="addteam(<?php echo $row["id"]; ?>, <?php if(is_null($row["password"])) { echo "1"; } else { echo "0"; } ?>)" />
        </div>
        </td>
      </tr>
      <?php
    }
  }  

  $conn->close(); 
  ?>

</table>
</html>
