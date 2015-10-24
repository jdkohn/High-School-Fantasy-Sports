
<?php


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

form.blocktext {
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    margin-bottom: auto;
    width: 14em
}

form.alignlinks {
  margin-right: auto;
}

input.Submit {
width: 50px;
padding: 5px;
font-weight: bold;
font-size: 75%;
background: white;
color: black;
cursor: pointer;
border: 1px solid #999999;
border-radius: 10px;
}
input.Submit:hover {
color: white;
background: black;
border: 1px solid #000033;
}

</style>