<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .event-list {
            list-style-type: none;
            padding: 0;
        }

        .event-item {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .event-item strong {
            color: #333;
            font-size: 1.2em;
        }

        .event-item span {
            color: #777;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Details</h1>
        <a href="events.php" style="position: absolute; top: 10px; left: 10px; text-decoration: none;">Go Back</a>
            <?php
            // Initialize the session
            session_start();
            
            // Check if the username is set in the session
            if (!isset($_SESSION['username'])) {
                // Redirect to the login page or handle the case where the user is not logged in
                header("Location: login.php");
                exit;
            }
            
            // Now, you can safely use $_SESSION['username'] in your code
            $loggedInUsername = $_SESSION['username'];
            
            // Replace with your actual database connection and query
            include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

            // Query to retrieve event details for the logged-in user from the database
            $query = "SELECT ename, edate FROM events WHERE name = '$loggedInUsername'";

            // Execute the query
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $eventName = $row['ename'];
                    $eventDate = $row['edate'];

                    echo '<li class="event-item">';
                    echo '<strong>' . $eventName . '</strong><br>';
                    echo '<span>Date: ' . date('F j, Y', strtotime($eventDate)) . '</span>';
                    echo '</li>';
                }
            } else {
                echo '<li>No events found for ' . $loggedInUsername . '.</li>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </ul>
    </div>
</body>
</html>