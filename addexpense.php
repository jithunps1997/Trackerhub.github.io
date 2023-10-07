<!DOCTYPE html>
<html>
<head>
    <title>Add Daily Expense</title>
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
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555555;
        }
        input[type="text"], select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 2px;
            margin-bottom: 10px;
        }
        input[type="date"] {
            width: 100%;
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
            background-color: #f2f2f2;
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
    <script>
        function showAlert() {
            alert("Expense updated Successfully");
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Add Daily Expense</h2>
    <div class="signout-buttons">
        <a href="dashboard.php" class="signout-link">Go Back</a>
    </div>
    <?php
    session_start();
    include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form  
        $username = $_SESSION["username"];
        $amount = $_POST["amount"];
        $date = $_POST["date"];
        $category = $_POST["category"];

        // Define the SQL query to insert data into your database
        $sql = "INSERT INTO expenses ( username,amount, date, category) 
                VALUES ('$username','$amount', '$date', '$category')";

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
           header("location: addexpense.php");
         } else {
          echo '<p class="message">Error: ' . $conn->error . '</p>';
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <form method="post" action="" onsubmit="showAlert()">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" required>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="Food">Food</option>
            <option value="Transportation">Transportation</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Shopping">Shopping</option>
            <option value="movie">Movie</option>
        </select>

        <input type="submit" value="Add Expense">
    </form>
</div>

</body>
</html>
