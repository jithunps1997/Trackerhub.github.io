<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = ($_POST["password"]); // Hash the password
    $submissionDate = date("Y-m-d H:i:s");
    $role = 'user';
    $location = 'bangalore';
}
    // SQL query to insert user data
    $sql = "INSERT INTO registration (name, email,username,password,role,date,location) VALUES ('$name','$email','$username','$password','$role','$submissionDate','$location')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
$conn->close();
?>