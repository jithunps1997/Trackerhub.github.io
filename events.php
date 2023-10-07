<html>
<head>
    <title>Event Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Header Styling */
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            text-align: center;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .sidebar a {
            display: block;
            color: #ffffff;
            padding: 10px;
            text-decoration: none;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        /* Widget Styling */
        .widget {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Chart Styling */
        .chart-container {
            height: 300px;
        }

        .sidebar {
            width: 250px;
            background-color: #333333;
            color: #ffffff;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }

        .sidebar a {
            display: block;
            color: #ffffff;
            padding: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
    // Assume you have started the session and retrieved the username
    session_start();
    $loggedInUsername = $_SESSION['username'];

    // Replace with your actual database connection and query
    include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 
    // Retrieve role from registration table
$roleQuery = "SELECT role FROM registration WHERE username = '$loggedInUsername'";
$roleResult = $conn->query($roleQuery);

$loggedInRole = "Unknown"; // Default value

if ($roleResult->num_rows > 0) {
    $row = $roleResult->fetch_assoc();
    $loggedInRole = $row['role'];
}

    // Check if a new event is being added
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ename = $_POST["ename"];
        $date = $_POST["edate"]; 

        // Insert event details into the database using a prepared statement
        $sql = "INSERT INTO events (name, ename, edate) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $loggedInUsername, $ename, $date);
            
            if ($stmt->execute()) {
                // Event added successfully
                echo "<script>alert('New event has been added.');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $stmt->error;
            }

            $stmt->close();
        }
    }
    ?>
    
    <div class="header">
        <div style="float: right; margin-right: 20px;">
            Account: <?php echo $loggedInUsername; ?> (<?php echo $loggedInRole; ?>)
        </div>
        <h1>Event Management</h1>
    </div>
    
    <div class="sidebar">
        <a href="addaccount.php">Arrangements</a>
        <a href="addexpense.php">Shoppings</a>
        <a href="#">Financial budget</a>
        <a href="#">Participants</a>
        <a href="viewusereventinfo.php">View events</a>
        <a href="Contact.php">Contact us</a>
        <a href="customerpage.html">Go Back</a>
    </div>

    <div class="content">
        <!-- Add Event Form -->
        <div class="widget">
            <h2>Add Event</h2>
            <form action="" method="post">
                <label for="event_name">Event Name:</label>
                <input type="text" id="event_name" name="ename" required>
                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="edate" required>
                <br>
                <input type="submit" value="Add Event">
            </form>
        </div>
        
        <!-- Add more widgets as needed -->
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    </script>
</body>
</html>