<?php

$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$email = $_POST['email'];
$usrnme = $_POST['username'];
$psswrd = $_POST['password'];

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
VALUES ('$firstname', '$lastname', '$email', '$usrnme', '$psswrd')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>