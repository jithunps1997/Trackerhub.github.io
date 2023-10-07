<!DOCTYPE html>
<html>
<head>
    <title>Discover Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        .back-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Discover Table</h1>
        <?php
        // Replace with your actual database connection and query
        include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

        // Retrieve data from the 'discover' table
        $sql = "SELECT * FROM discover";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Username</th><th>Note</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['note'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No data found.';
        }

        // Close the database connection
        $conn->close();
        ?>

        <!-- Back button -->
        <button class="back-button" onclick="goBack()">Back</button>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </div>
</body>
</html>
