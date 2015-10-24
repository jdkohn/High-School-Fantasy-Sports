<?php

echo "Create Account";

?>

<style>

.error {
  color: #FF0000;
}

form.blocktext {
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    margin-bottom: auto;
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

<?php
// define variables and set to empty values
$firstNameErr = $lastNameErr = $emailErr = $usernameErr = $passErr = "";
$firstname = $lastname = $email = $usrnme = $pass = "";
$firstSet = $lastSet = $emailSet = $usernameSet = $passSet = FALSE;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["firstname"])) {
     $firstNameErr = "First Name is required";
   } else {
     $firstname = test_input($_POST["firstname"]);
     $firstSet = TRUE;
   }
   if (empty($_POST["lastname"])) {
     $lastNameErr = "Last Name is required";
   } else {
     $lastname = test_input($_POST["lastname"]);
     $lastSet = TRUE;
   }
   
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
   } else {
     $email = test_input($_POST["email"]);
     $emailSet = TRUE;
   }

   if (empty($_POST["username"])) {
     $usernameErr = "Username is required";
   } else {
     $usrnme = test_input($_POST["username"]);
     $usernameSet = TRUE;
   }
   if($_POST["password"] != $_POST["password1"]) {
    $passErr = "Passwords don't match";
  } else {
    $pass = test_input($_POST["password"]);
    $passSet = TRUE;
   }

   if($firstSet && $lastSet && $emailSet && $usernameSet && $passSet) {
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

      $sql = "INSERT INTO users (firstname, lastname, email, username, password)
      VALUES ('$firstname', '$lastname', '$email', '$usrnme', '$pass')";

      if ($conn->query($sql) === TRUE) {
          session_start();
          $_SESSION["firstname"] = $firstname;
          $_SESSION["username"] = $usrnme;
          header( 'Location: home.php' );
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close(); 

      
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<p><span class="error">* required field.</span></p>
<form class="blocktext" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  First Name:<br>
  <input type="text" name="firstname">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <br>
  Last Name:<br>
  <input type="text" name="lastname">
  <span class="error">* <?php echo $lastNameErr;?></span>
  <br>
  Email Addresss:<br>
  <input type="text" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  <br>
  Username:<br>
  <input type="text" name="username">
  <span class="error">* <?php echo $usernameErr;?></span>
  <br>
  Password:<br>
  <input type="password" name="password">
  <span class="error">* </span>
  <br>
  Re-Type Password:<br>
  <input type = "password" name="password1">
  <span class="error">* <?php echo $passErr;?></span>
  <br>
    <input class="Submit" type="submit" value="Go" />
</form>




