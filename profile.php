<?php
    // Assume you have started the session and retrieved the username
    session_start();
    $loggedInUsername = $_SESSION['username'];

    // Replace with your actual database connection and query
    include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 

// Retrieve user information based on the session username
$username = $_SESSION['username'];
$query = "SELECT * FROM registration WHERE username = '$username'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
    $location = $row ['location'];
} else {
    // Handle the case where user data is not found (e.g., display an error message)
    $name = "N/A";
    $email = "N/A";
    $location = "N/A";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Location:</strong> <?php echo $location; ?></p>
        <p><a href="login.php">Logout</a></p> <!-- Include a logout link to destroy the session -->
    </div>
</body>
</html>
