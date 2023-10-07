<!DOCTYPE html>
<html>
<head>
    <title>View Logs</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-image: url('images/logspic.jpg'); /* Relative path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
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
            position: relative;
            border-radius: 10px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        p {
            text-align: center;
            color: #777777;
            font-size: 16px;
        }
        .search-form {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        .search-form label {
            margin-right: 10px;
            font-size: 14px;
        }
        .search-form input[type="text"] {
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 14px;
        }
        .search-form input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .no-logs {
            text-align: center;
            color: #ff0000;
            font-size: 16px;
            margin-top: 20px;
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
    <h2>Login Session Logs</h2>
    <div class="signout-buttons">
        <a href="home.html" class="signout-link">Go Back</a>
        <a href="logsinfo.php" class="signout-link">Refresh</a>
    </div>
    
    <form method="get" action="">
        <label for="search">Search by Username or Status:</label>
        <input type="text" name="search" id="search" placeholder="Enter username or status">
        <input type="submit" value="Search">
    </form>
    
    <?php
    session_start();
    include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 

    function getLoginSessionLogs($conn, $searchQuery) {
        $logs = array();
        $sql = "SELECT username, session_time, status FROM login_sessions WHERE username LIKE '%$searchQuery%' OR status LIKE '%$searchQuery%' ORDER BY session_time DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $logs[] = $row;
            }
        }
        return $logs;
    }

    $logs = array();
    $searchQuery = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $searchQuery = isset($_GET["search"]) ? $_GET["search"] : "";
    
        if ($searchQuery === "") {
            $logs = getLoginSessionLogs($conn, $searchQuery);
        } elseif (!empty($searchQuery)) {
            $logs = getLoginSessionLogs($conn, $searchQuery);
        }
    }
    ?>

    <?php if (isset($logs) && !empty($logs)): ?>
        <table>
            <tr>
                <th>Username</th>
                <th>Login Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['username']; ?></td>
                    <td><?php echo $log['session_time']; ?></td>
                    <td><?php echo $log['status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No login session logs found for the selected criteria.</p>
    <?php endif; ?>
    
</div>
</body>
</html>
