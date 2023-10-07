<!DOCTYPE html>
<html>
<head>
    <title>Add Bank Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
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
        input[type="text"], select {
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
            alert("Details updated Successfully");
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Add Bank Account</h2>
    <div class="signout-buttons">
        <a href="dashboard.php" class="signout-link">Go Back</a>
    </div>
    <?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        $userName = $_SESSION["username"];
        $accountName = $_POST["bank_name"];
        $accountType = $_POST["account_type"];
        $income = $_POST["income"];
        $month = $_POST["month"];
        
        // Perform database insertion (you should include your database connection here)
        // Example:
        // $conn = new mysqli("your_server", "your_username", "your_password", "your_database");
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        
        // Define the SQL query to insert data into your database
        $sql = "INSERT INTO bank_accounts (username,bank_name, account_type, income, month) 
                VALUES ('$userName','$accountName', '$accountType', '$income', '$month')";
        
      // Execute the SQL query
         if ($conn->query($sql) === TRUE) {
        header ("location: addaccount.php");
         } else {
           echo '<p class="message">Error: ' . $conn->error . '</p>';
         }
        
        // Close the database connection
         $conn->close();
    }
    ?>

    <form method="post" action="" onsubmit="showAlert()">
        <label for="account_name">Bank Name:</label>
        <input type="text" name="bank_name" id="bank_name" required>
        
        <label for="account_type">Account Type:</label>
        <select name="account_type" id="account_type" required>
            <option value="Savings">Savings</option>
            <option value="Checking">Checking</option>
            <option value="Investment">Investment</option>
        </select>
        
        <label for="income">Income:</label>
        <input type="text" name="income" id="income" required>
        
        <label for="month">Month:</label>
        <select name="month" id="month" required>
            <?php
            // Generate options for months (Jan to Dec)
            $months = [
                "Jan" => "January",
                "Feb" => "February",
                "Mar" => "March",
                "Apr" => "April",
                "May" => "May",
                "Jun" => "June",
                "Jul" => "July",
                "Aug" => "August",
                "Sep" => "September",
                "Oct" => "October",
                "Nov" => "November",
                "Dec" => "December"
            ];
            
            foreach ($months as $shortMonth => $fullMonth) {
                echo "<option value='$shortMonth'>$fullMonth</option>";
            }
            ?>
        </select>
        
        <input type="submit" value="Add Account">
    </form>
</div>

</body>
</html>
