<?php

include 'header.php';
include 'createconnection.php';

echo "<br><br>";
?>
<html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script> 
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});


</script>


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
          <td><a href="team.php?id=<?php echo $row["id"] ?>"> <?php echo $row["name"]; ?></a></td>
          <td><?php echo $league["leaguename"]; ?></td>
          <td><?php echo "0/" . $league["numteams"]; ?></td>
        </tr>
      <?php
    }
  }

  $conn->close();

  ?>

  </html>