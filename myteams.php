<?php

include 'header.php';
include 'createconnection.php';

echo "<br><br>";
?>
<html>

<head>
  <title>My Teams</title>
</head>

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
    <th>Draft</th>
  </tr>

  <?php 
  $teamnum = 0;
//Needs work
  foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]'") as $row ) {
    $leaguenum = $row['league'];
    foreach ($conn->query("SELECT * FROM leagues where id=$row[league]") as $f ) {

      $teamname='';
      $team = $row['id'];
      $league = $row['league'];

      $teamnum = $team;

      $teams = array();

      $totalteams = 0;

      $league = mysqli_real_escape_string($conn, $league);
      foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
        array_push($teams, $uno['id']);
        $totalteams++;
      }

      $teamresult = array();
      for($i=0;$i<count($teams);$i++) {
        $current = $teams[$i];

        $totalwins = 0;
        $current = mysqli_real_escape_string($conn, $current);
        foreach($conn->query("SELECT * FROM schedule WHERE team='$current'") as $game) {
          if($game['result'] == 'W') {
            $totalwins++;
          }
        }
        array_push($teamresult,(array($current, $totalwins)));
      }

      $standings = array();

      for($l = 0; $l<$totalteams; $l++) {

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
        <td><?php echo $currentPosition . "/" . $f["numteams"]; ?></td>
        <td>
          <?php 
          $p = $conn->query("SELECT * FROM teams WHERE league = '$leaguenum'");
          $numteams = mysqli_num_rows($p);
          date_default_timezone_set('America/Los_Angeles');
          $drafttime = strtotime($f['draftdate']);

          $result = $conn->query("SELECT * FROM draft WHERE league='$leaguenum'");
          if(mysqli_num_rows($result) != ($f["numteams"] * 7)) {

            if(((time()+(60*60*1)) > $drafttime) && ($totalteams == $f["numteams"])) {
              ?>
              <input class="dButton" type="submit" value="Draft" id="goToDraft" onclick="draft(<?php echo $teamnum; ?>)" />
              <br>
              <?php
            } else {
              echo $f["draftdate"];
            }
          } else {
            echo "Drafted!";
          }
          ?>


        </td>
      </tr>
      <?php
    }
  }

  $conn->close();

  ?>

<script>
function draft($teamnum) {
  location.href = "draft.php?team=" + $teamnum;
}
</script>

  </html>