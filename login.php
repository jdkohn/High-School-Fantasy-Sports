<?php
include "style.php";

?>

<head>
<title>Login</title>
</head>

<form class="alignlinks">
  <a href="createaccount.php">Create Account</a> 
</form>  

<form float="center" action="authenticateuser.php" method="post">
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