
<?php

include "style.php";

?>

<form class="alignlinks">
  <a href="createaccount.php">Create Account</a> 
  <a> </a>
  <a href ="http://www.espn.go.com">Forgot Password</a><br>
</form>  

<form class="blocktext" action="authenticateuser.php" method="post">
  Username:<br>
  <input type="text" name="username">
  <br>
  Password:<br>
  <input type="password" name="password">
  <a>  </a>
    <input class="Submit" type="submit" value="Go" />
</form>


<style>

body {background-color: lightblue}


</style>