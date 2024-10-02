<?php
$servername = "localhost";
$username = "root";
$password = "driverover1";
$dbname = "CAT1";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>