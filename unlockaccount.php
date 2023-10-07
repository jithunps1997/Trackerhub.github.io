<?php
session_start();
// Include your database configuration here
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

// Initialize the username variable
$username = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username from the form input
    $username = $_POST["username"];
    
    // Check if the username exists in the database
    $sqlCheck = "SELECT * FROM registration WHERE username = '$username'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows == 1) {
        // Update the database with the new status
        $sql = "UPDATE registration SET failed_attempts = null WHERE username = '$username'";
        if ($conn->query($sql) === TRUE) {
            header("location: userdetails.php");
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "User not found.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlock User Account</title>
    <script>
    function showAlert() {
        alert("Account unlocked successfully");
    }
</script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Unlock User Account</h1>
    <form method="post" action="" onsubmit="showAlert()">

        <input type="text" id="username" name="username" required value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">

        <input type="submit" value="Unlock">
    </form>
</body>
</html>