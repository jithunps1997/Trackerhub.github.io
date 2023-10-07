<!DOCTYPE html>
<html>
<head>
    <title>Ticket Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            text-align: center;
        }
        h2 {
            color: #333333;
            margin-bottom: 20px;
        }
        p {
            color: #555555;
            margin-bottom: 15px;
        }
        .status {
            font-weight: bold;
            font-size: 18px;
            color: #007bff;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ticket Status</h2>
        <?php
        include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

        session_start(); // Start the session to access session variables
        $username = $_SESSION["username"]; // Get the logged-in username

        $sql = "SELECT name, status, incident_number, ticket_comments FROM contact WHERE name = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = $row['status'];
                $comments = $row['ticket_comments'];
                $incidentNumber = $row['incident_number'];
                echo "<p>Username: <span class='status'>$username</span></p>";
                echo "<p>Incident Number: <span class='status'>$incidentNumber</span></p>";
                echo "<p>Resolution Comments: <span class='status'>$comments</span></p>";
                echo "<p>Status: <span class='status'>$status</span></p>";
                echo "<hr>";
            }
        } else {
            echo "<p>No tickets found for this username.</p>";
        }
        ?>
        <a href="login.php" class="back-link">Go Back</a>
    </div>  
</body>
</html>
