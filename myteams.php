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
    foreach ($conn->query("SELECT * FROM leagues where id=$row[league]") as $f ) {

      $teamname='';
      $team = $row['id'];
      $league = $row['league'];

      $teams = array();

      foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
        array_push($teams, $uno['id']);
      }

      $teamresult = array();
      for($i=0;$i<count($teams);$i++) {
        $current = $teams[$i];

        $totalwins = 0;
        foreach($conn->query("SELECT * FROM schedule WHERE team='$current'") as $game) {
          if($game['result'] == 'W') {
            $totalwins++;
          }
        }
        array_push($teamresult,(array($current, $totalwins)));
      }

      $standings = array();

      $numteams = count($teams);

      for($l = 0; $l<$numteams; $l++) {

        $greatest = $teamresult[0][1];

        $greatestteamnum = $teamresult[0][0];

        if(count($teamresult) != 1) {
          for($i = 1; $i<count($teams); $i++) {

            if($teamresult[$i][1] > $greatest) {
              $greatest = $teamresult[$i][1];
              $greatestteamnum = $teamresult[$i][0];
            }
          }
        }


        array_push($standings, $greatestteamnum);


        $cop = array();
        if(count($teamresult) != 1) {
          for($q=0; $q<count($teams); $q++) {
            if($q != $greatest) {
              array_push($cop, $teamresult[$q]);
            }
          }
        }


        $teamresult = array();

        for($q=0; $q<count($cop); $q++) {
          array_push($teamresult, $cop[$q]);
        }
      }

      $currentPosition = 0;
      for($i=0;$i<count($standings);$i++) {
        if($standings[$i] == $team) {
          $currentPosition = $i + 1;
          break;
        }
      }
      ?>
      <tr>
        <td><a href="team.php?id=<?php echo $row["id"] ?>"> <?php echo $row["name"]; ?></a></td>
        <td><?php echo $f["leaguename"]; ?></td>
        <td>
          <?php echo $currentPosition . "/" . $f["numteams"]; ?></td>
        </tr>
        <?php
      }
    }

    $conn->close();

    ?>

    </html>