<?php

include "header.php";
include "createconnection.php";

echo "<br><br>";
?>
<html>

<table style="width:100%">
  <tr>
    <th>League Name</th>
    <th>Team Name</th>
    <th>Number of Teams</th>
    <th>Commissioner</th>
  </tr>

  <?php 
//Needs work
  foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {
    foreach ($conn->query("SELECT * FROM leagues where id=$row[league]") as $league ) {
    ?>
      <tr>
        <td><?php echo $league["name"]; ?></td>
        <td><?php echo $league["leaguename"]; ?></td>
        <td><?php echo "0/" . $league["numteams"]; ?></td>
      </tr>
      <?php
    }
  }


$conn->close();

?>

</html>





