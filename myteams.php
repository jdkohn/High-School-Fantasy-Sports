<?php

include 'header.php';
include 'createconnection.php';

echo "<br><br>";
?>
<html>

<table style="width:100%">
  <tr>
    <th>Team Name</th>
    <th>League Name</th>
    <th>Current Position</th>
  </tr>

  <?php 
//Needs work
  foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {
    foreach ($conn->query("SELECT * FROM leagues where id=$row[league]") as $league ) {
    ?>
      <tr>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $league["leaguename"]; ?></td>
        <td><?php echo "0/" . $league["numteams"]; ?></td>
      </tr>
      <?php
    }
  }


$conn->close();

?>

</html>