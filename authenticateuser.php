<?php

$usrusername = $_POST['username'];
$usrpassword = $_POST['password'];

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


$sql = "SELECT * FROM users WHERE username='$usrusername' AND password='$usrpassword'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         session_start();
         $_SESSION["firstname"] = $row["firstname"];
         $_SESSION["username"] = $row["username"];
         $_SESSION["id"] = $row["id"];
         header( 'Location: home.php' ) ;
     }
} else {
     header( 'Location: login.php');
}

$conn->close();

?>
