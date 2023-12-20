<?php
// Database configuration
$dbHost = 'localhost';
$dbName = 'ecom1_project';
$dbUser = 'root';
$dbPass = '';

// Create connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPass , $dbName);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>