<!DOCTYPE html>
<html>
<head>
    <title>Money Management Dashboard</title>
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
      .chart-container {
            height: 300px;
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
    
// Define the SQL query to fetch income for the current month
$incomeSql = "SELECT SUM(income) AS total_income
FROM bank_accounts
WHERE username = '$loggedInUsername'
  AND MONTH(month) = MONTH(CURRENT_DATE())";

// Execute the SQL query to get the total income for the current month
$incomeResult = $conn->query($incomeSql);

// Define the SQL query to fetch expenses for the current month
$expenseSql = "SELECT SUM(amount) AS total_expense
 FROM expenses
 WHERE username = '$loggedInUsername'
   AND MONTH(date) = MONTH(CURRENT_DATE())
   AND YEAR(date) = YEAR(CURRENT_DATE())";

// Execute the SQL query to get the total expense for the current month
$expenseResult = $conn->query($expenseSql);

// Calculate the net balance for the current month
$currentMonthIncome = 0;
$currentMonthExpense = 0;

if ($incomeResult && $expenseResult) {
$incomeRow = $incomeResult->fetch_assoc();
$currentMonthIncome = $incomeRow['total_income'];

$expenseRow = $expenseResult->fetch_assoc();
$currentMonthExpense = $expenseRow['total_expense'];
}

// Calculate net balance
$netBalance = $currentMonthIncome - $currentMonthExpense;

// ...
    ?>
    
    <div class="header">
        <div style="float: right; margin-right: 20px;">
            Account: <?php echo $loggedInUsername; ?> (<?php echo $loggedInRole; ?>)
        </div>
        <h1>Money Management Dashboard</h1>
    </div>
    
    <div class="sidebar">
        <a href="addaccount.php">Accounts</a>
        <a href="addexpense.php">Expenses</a>
        <a href="#">Income</a>
        <a href="#">Reports</a>
        <a href="Contact.php">Contact us</a>
        <a href="customerpage.html">Go Back</a>
    </div>

    <div class="content">
        <div class="widget">
            <h2>Account Balances</h2>
            <div class="chart-container">
                <!-- Implement your chart here -->
                <canvas id="accountBalancesChart"></canvas>
            </div>
        </div>
        
        <div class="widget">
            <h2>Recent Expenses</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
                <?php
                // Define the SQL query to fetch recent expenses
                $sql = "SELECT date, category, amount
                        FROM expenses
                        ORDER BY date DESC
                        LIMIT 10"; // Adjust the LIMIT value to fetch the desired number of recent expenses

                // Execute the SQL query
                $result = $conn->query($sql);

                // Initialize an array to store the recent expenses
                $recentExpenses = array();

                // Check if the query was successful and fetch the data
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $recentExpenses[] = $row;
                    }
                } else {
                    echo "Error: " . $conn->error;
                }

                foreach ($recentExpenses as $expense) {
                    echo "<tr>";
                    echo "<td>{$expense['date']}</td>";
                    echo "<td>{$expense['category']}</td>";
                    echo "<td>{$expense['amount']}</td>";
                    echo "</tr>";
                }

                // Close the database connection here
                $conn->close();
                ?>
            </table>
        </div>
        
        <!-- Add more widgets as needed -->
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>


        // Sample data for account balances chart (replace with actual data)
       // Sample data for account balances chart (replace with actual data)
var accountBalancesData = {
    labels: ['Transaction', 'Income', 'Expense'],
    datasets: [{
        label: 'Account Balances',
        data: [0, <?php echo $currentMonthIncome; ?>, <?php echo $currentMonthExpense; ?>], // Update with actual data
        backgroundColor: [
            'rgba(75, 192, 192, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)'
        ],
        borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)'
        ],
        borderWidth: 1
    }]
};

        // Create account balances chart
        var accountBalancesChart = new Chart(document.getElementById('accountBalancesChart'), {
            type: 'bar',
            data: accountBalancesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
