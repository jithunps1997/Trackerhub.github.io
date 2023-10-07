<?php
$servername = "localhost";
$username = "moneymgmt";
$password = "Jithun@1234";
$dbname = "moneymgmt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
