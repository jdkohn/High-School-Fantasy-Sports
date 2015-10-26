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

</style>

<html>
  <table style="width:100%">
    <tr>
      <th>League Name</th>
      <th>Members</th>
      <th>Draft Date</th>
      <th>Access</th>
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

$ssql = "SELECT * FROM leagues";

$result = $conn->query($ssql);

if ($result->num_rows > 0) {
     // output data of each row
  while($row = $result->fetch_assoc()) {
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
        </tr>
        <?php
      }
  }  
} else {
  header( 'Location: createleague.php');
}

// if($passNeeded) {
//  $sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate, password)
//  VALUES ('$name', '$numTeams', '$commissioner', '$draftDate', '$pass')";
// }

// $sql = "INSERT INTO leagues (leaguename, numteams, commissioner, draftdate)
// VALUES ('$name', '$numTeams', '$commissioner', '$draftDate')";

// if ($conn->query($sql) == TRUE) {
//   header( 'Location: home.php' );
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

$conn->close(); 
?>

</table>
</html>

