<!DOCTYPE html>
<html>
<head>
    <title>Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group textarea, .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: vertical; /* Allow vertical resizing */
            rows: 5; /* Define the number of visible rows */
        }
        .form-group button {
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
        <h1>Discover something!</h1>
        <?php
        session_start();
        // Replace with your actual database connection and query
        include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_SESSION["username"];
            $note = $_POST['note'];

            // Insert the note into the 'discover' table
            $sql = "INSERT INTO discover (username, note) VALUES ('$username', '$note')";
            if ($conn->query($sql) === TRUE) {
                header("location: customerpage.html");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close the database connection
            $conn->close();
        }
        ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="note">Enter your Note:</label>
                <textarea id="note" name="note" rows="5" required placeholder="Please feel free to provide your insights or suggestions if you have any ideas or notice any areas where the application can be enhanced."></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit feedback</button>
            </div>
        </form>
    </div>
</body>
</html>
