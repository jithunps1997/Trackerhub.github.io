<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

$userDetails = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchUsername = $_POST["search_username"];
    // Retrieve user details from the database based on the search username
    $sql = "SELECT * FROM registration WHERE username='$searchUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
    }
}
$startDate = date("Y-m-d H:i:s", strtotime("-7 days"));
// Retrieve login session logs for the selected user
$loginSessionLogs = array();
if (!empty($userDetails)) {
    $username = $userDetails['username'];
    $sqlLogs = "SELECT session_time, status FROM login_sessions WHERE username='$username' ORDER BY session_time DESC";
    $resultLogs = $conn->query($sqlLogs);

    if ($resultLogs->num_rows > 0) {
        while ($row = $resultLogs->fetch_assoc()) {
            $loginSessionLogs[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        label {
            display: block;
            font-weight: bold;
            color: #555555;
        }
        input[type="text"] {
            width: 60%;
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
        .date-range-form {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }

        .date-range-form label {
            margin-right: 10px;
            font-weight: bold;
        }

        .date-range-form input {
            padding: 5px;
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
</head>
<body>
<div class="container">
    <h2>User Details</h2>
    <form method="post" action="">
        <label for="search_username">Username:</label>
        <input type="text" name="search_username" id="search_username" required>
        <input type="submit" value="Search">
        <div class="signout-buttons">
        <a href="iam-panel.html" class="signout-link">Go back</a>
    </div>
    </form>
    <?php if (!empty($userDetails)): ?>
        
        <h3>User Details for <?php echo $userDetails['username']; ?>:</h3>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Created</th>
                <th>Role</th>  
                <th>Account Status</th> 
            </tr>
            <tr>
                <td><?php echo $userDetails['username']; ?></td>
                <td><?php echo $userDetails['email']; ?></td>
                <td><?php echo $userDetails['date']; ?></td>
                <td><?php echo $userDetails['role']; ?></td>
                <td>
    <?php
    if ($userDetails['failed_attempts'] === null) {
        echo 'Active';
    } else {
        echo $userDetails['failed_attempts'];
    }
    ?>
</td>
<a href="passwordreset.php?username=<?php echo urlencode($username); ?>">Password reset</a>
<td>
<a href="unlockaccount.php?username=<?php echo urlencode($username); ?>">Unlock user account</a></td>
            </tr>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No user details found for the given username.</p>
    <?php endif; ?>

    <?php if (!empty($loginSessionLogs)): ?>
        <h3>Login Session Logs for <?php echo $userDetails['username']; ?>:</h3>
        <table>
            <tr>
                <th>Session Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($loginSessionLogs as $log): ?>
                <tr>
                    <td><?php echo $log['session_time']; ?></td>
                    <td><?php echo $log['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</div>
</body>
</html>