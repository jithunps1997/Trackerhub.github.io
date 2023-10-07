<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $newPassword = $_POST["new_password"];
    
    // Update the user's password in the database (without hashing)
    $updateQuery = "UPDATE registration SET password='$newPassword' WHERE username='$username'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $resetMessage = "Password reset successful!";   
        header("Location: userdetails.php");
    } else {
        $resetMessage = "Error: " . $conn->error;
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
   body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555555;
        }
        input[type="text"],
        input[type="password"] {
            width: 60%; /* Adjusted width here */
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 2px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .message {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Password Reset</h2>
    
    <?php
    if (isset($resetMessage)) {
        echo '<p class="message">' . $resetMessage . '</p>';
    }
    ?>

    <form method="post" action="" onsubmit="showAlert()">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>

        <label>Confirm Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Reset Password">
    </form>
</div>
<script>
    function showAlert() {
        alert("Password updated successfully");
    }
</script>
</body>
</html>
