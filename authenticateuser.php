<?php
include "createconnection.php";


$usrusername = $_POST['username'];
$usrpassword = $_POST['password'];

$usrusername = mysqli_real_escape_string($conn, $usrusername);
$usrpassword = mysqli_real_escape_string($conn, $usrpassword);

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
