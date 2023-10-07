<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $role = $_POST["role"];

    // UPDATE user data into the database
    $sql = "UPDATE registration SET role = '$role' WHERE username = '$username'";
    
    if ($conn->query($sql) === TRUE) {
        header ("location: iam-panel.html");
        // Removed the exit() call from here
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
            font-size: 18px; /* Adjust the font size as needed */
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #dddddd;
            border-radius: 4px;
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
        .signout-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        .signout-link {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .clear-filter-button {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
    
<body>
        <div class="container">
            <h2>Access Management</h2>
            <form method="post" action="Access-Add.php" onsubmit="showAlert()">
            <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="Reason">Justification:</label>
        <input type="text" name="reason" id="reason" required><br><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="user">User</option>
            <option value="admin">Developer</option>
            <!-- You can add more role options here -->
        </select><br><br>
                <input type="submit" value="Assign">
            </form>
        </div>
    </div>

    <script>
        function showAlert() {
            alert("Role updated Successfully");
        }
    </script>
</body>
</html>