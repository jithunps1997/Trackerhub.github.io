<?php
// Include your database connection file
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';
// Initialize variables for search
$searchText = ""; // Variable to hold the search text
$searchStatus = ""; // Variable to hold the selected status

// Check if a search query is submitted
if (isset($_GET['search'])) {
    $searchText = $_GET['search'];
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $searchStatus = $_GET['status'];
}

// Modify the SQL query to include search conditions for both open and Resolved statuses
if (!empty($searchStatus)) {
    $sql = "SELECT * FROM contact WHERE status = '$searchStatus'";
} else {
    // Default query without search
    $sql = "SELECT * FROM contact";
}

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching tickets: " . $conn->error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Management</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/logspic.jpg'); /* Relative path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px; /* Adjust the width as needed */
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }
        /* Form Styles */
        .search-form {
            margin-bottom: 20px;
            text-align: center;
        }
        .search-input {
            padding: 8px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
        .search-button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Styling for the logout link */
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
        <h2>Ticket Management</h2>
        <!-- Search Form -->
        <div class="signout-buttons">
        <a href="home.html" class="signout-link">Go Back</a>
        <a href="ticket.php?search=&status=Open" class="signout-link">Refresh</a>
    </div>
    <form class="search-form" method="get">
    <label for="search">Search by Status or Incident Number:</label>
    <input class="search-input" type="text" name="search" value="<?php echo $searchText; ?>" placeholder="Search...">
    
    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">All</option>
        <option value="Open" <?php if ($searchStatus === 'Open') echo 'selected="selected"'; ?>>Open</option>
        <option value="Resolved" <?php if ($searchStatus === 'Resolved') echo 'selected="selected"'; ?>>Resolved</option>
    </select>
    
    <button class="search-button" type="submit">Search</button>
</form>
        <!-- Table of Results -->
        <table>
            <tr>
                <th>Incident</th>
                <th>Note</th>
                <th>Status</th>
                <th>Open date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><a href="view_tickets.php?incident_number=<?php echo $row['incident_number']; ?>"><?php echo $row['incident_number']; ?></a></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><a href="view_tickets.php?incident_number=<?php echo $row['incident_number']; ?>">View</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>