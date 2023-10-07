<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

$userDetails = array(); // Initialize the array
$preFilledUsername = isset($_SESSION["searched_username"]) ? $_SESSION["searched_username"] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchUsername = $_POST["search_username"];
    
    // Update the session-stored username with the new searched username
    $_SESSION["searched_username"] = $searchUsername;
    
    // SQL query to retrieve user details from login_sessions table
    $sql = "SELECT username, session_time,status FROM login_sessions WHERE username = '$searchUsername'";
    $result = $conn->query($sql);

    // Debug output
    if ($result === false) {
        echo "Query error: " . $conn->error;
    } else {
        while ($row = $result->fetch_assoc()) {
            $userDetails[] = $row; // Add rows to the array
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search User Details</title>
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            color: #555555;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #f5f5f5;
        }
        p {
            text-align: center;
            color: #777777;
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
    </style>
    </style>
</head>
<body>
<div class="container">
<div class="signout-buttons">
        <a href="login.html" class="signout-link">Sign Out</a>
        <a href="userlogininfo.php" class="signout-link">Refresh</a>
    </div>
    <h2>Search User Details</h2>
    
    <form method="post" action="">
        <label for="search_username">Enter Username:</label>
        <input type="text" name="search_username" id="search_username" value="<?php echo $preFilledUsername; ?>" required>
        <input type="submit" value="Search">
    </form>
    
    <?php if (!empty($userDetails)): ?>
        <h3>User Details</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Login Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($userDetails as $user): ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['session_time']; ?></td>
                    <td><?php echo $user['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_POST["search_username"])): ?>
        <p>No user details found for <?php echo $_POST["search_username"]; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
