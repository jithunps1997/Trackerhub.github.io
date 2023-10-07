<?php
// Database connection setup
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch user data
$sql = "SELECT name, email, username, role FROM registration";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set headers for CSV file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users_report.csv"');

    // Open output stream for writing CSV data
    $output = fopen('php://output', 'w');

    // Write header row
    fputcsv($output, array('Name', 'Username', 'Email', 'Role'));

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close output stream
    fclose($output);
} else {
    echo "No data found.";
}

$conn->close();
?>

