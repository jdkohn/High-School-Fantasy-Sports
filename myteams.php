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

<!-- Baseball Table -->

<table style="width:100%">
  <tr>
    <th colspan="4">Baseball</th>
  <tr>
    <th>Team Name</th>
    <th>League Name</th>
    <th>Current Position</th>
    <th>Draft</th>
  </tr>

  <?php 
  $teamnum = 0;

  foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]' AND sport='B'") as $row ) {
    $leaguenum = $row['league'];
    foreach ($conn->query("SELECT * FROM leagues where id='$row[league]'") as $f ) {

      $teamname='';

      $leaguenum = $f['id'];
      $teamnum = $row['id'];

      $team = mysqli_real_escape_string($conn, $teamnum);
      $league = mysqli_real_escape_string($conn, $leaguenum);

      $teams = array();

      foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
        array_push($teams, $uno['id']);
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
        array_push($teamresult, $totalwins);
      }

      array_multisort($teamresult, SORT_DESC, $teams);

      $currentPosition = 0;
      for($i=0;$i<count($teams);$i++) {
        if($teams[$i] == $team) {
          $currentPosition = $i + 1;
          break;
        }
      }
      ?>
      <tr>
        <td><a href="baseballTeam.php?id=<?php echo $row["id"] ?>"> <?php echo $row["name"]; ?></a></td>
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

            if(((time()+(60*60*1)) > $drafttime) && ($numteams == $f["numteams"])) {
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
  ?>
</table>
<br>

<!--Basketball Table-->

<table style="width:100%">
  <tr>
    <th colspan="4">Basketball</td>
  <tr>
    <th>Team Name</th>
    <th>League Name</th>
    <th>Current Position</th>
    <th>Draft</th>
  </tr>

  <?php 
  $teamnum = 0;

  foreach ( $conn->query("SELECT * FROM teams where owner='$_SESSION[id]' AND sport='K'") as $row ) {
    $leaguenum = $row['league'];
    foreach ($conn->query("SELECT * FROM leagues where id='$row[league]'") as $f ) {

      $teamname='';

      $leaguenum = $f['id'];
      $teamnum = $row['id'];

      $team = mysqli_real_escape_string($conn, $teamnum);
      $league = mysqli_real_escape_string($conn, $leaguenum);

      $teams = array();

      foreach($conn->query("SELECT * FROM teams WHERE league='$league'") as $uno) {
        array_push($teams, $uno['id']);
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
        array_push($teamresult, $totalwins);
      }

      array_multisort($teamresult, SORT_DESC, $teams);

      $currentPosition = 0;
      for($i=0;$i<count($teams);$i++) {
        if($teams[$i] == $team) {
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

            if(((time()+(60*60*1)) > $drafttime) && ($numteams == $f["numteams"])) {
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
  ?>


</table>

  <?php
  $conn->close();
  ?>

  <script>
  function draft($teamnum) {
    location.href = "draft.php?team=" + $teamnum;
  }
  </script>

  </html>