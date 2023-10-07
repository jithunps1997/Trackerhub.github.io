<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
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

        .signout-button {
            text-align: center;
            margin-top: 20px;
        }

        .signout-link {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>User Information</h1>
    
    <!-- Search Box -->
    <form method="GET">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search">
        <select name="filter">
            <option value="username">Username</option>
            <option value="status">Status</option>
            <option value="role">Role</option>
            <option value="location">Location</option>
        </select>
        <input type="submit" value="Search">
        <a href="?clear" class="clear-filter-button">Clear Filter</a>
        <a href="iam-panel.html" class="clear-filter-button">Go Back</a>
    </form>

    <?php
   // Database connection parameters
   session_start();
   include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

   // Initialize user data query
   $sql = "SELECT * FROM registration";

   // Check if a search query is submitted
   if (isset($_GET['search']) && isset($_GET['filter'])) {
       $search = $_GET['search'];
       $filter = $_GET['filter'];
       
       // Modify the query to filter based on the selected filter
       if ($filter === 'username') {
           $sql .= " WHERE username LIKE '%$search%'";
       } elseif ($filter === 'status') {
           $sql .= " WHERE failed_attempts LIKE '%$search%'";
       } elseif ($filter === 'role') {
           $sql .= " WHERE role LIKE '%$search%'";
       } elseif ($filter === 'location') {
           $sql .= " WHERE location LIKE '%$search%'";
       }
   }

   // Check if the Clear Filter button is clicked
   if (isset($_GET['clear'])) {
       // Clear the search and filter criteria
       $sql = "SELECT * FROM registration";
   }

   // Execute the query
   $result = $conn->query($sql);

   // Display user data in a table
   if ($result->num_rows > 0) {
       echo '<h2>Users:</h2>';
       echo '<table>';
       echo '<tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Location</th><th>Status</th></tr>';

       while ($row = $result->fetch_assoc()) {
           echo '<tr>';
           echo '<td>' . $row['name'] . '</td>';
           echo '<td>' . $row['username'] . '</td>';
           echo '<td>' . $row['email'] . '</td>';
           echo '<td>' . $row['role'] . '</td>';
           echo '<td>' . $row['location'] . '</td>';
           echo '<td>' . ($row['failed_attempts'] === null ? 'Active' : $row['failed_attempts']) . '</td>';
           echo '</tr>';
       }

       echo '</table>';
   } else {
       echo '<p>No results found.</p>';
   }

   // Close the database connection
   $conn->close();
    ?>
</body>
</html>
