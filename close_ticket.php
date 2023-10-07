<?php
// Include your database connection file
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketId = $_POST["incident_number"];

    // Update ticket status to "Closed"
    $sql = "UPDATE contact SET status = 'Resolved' WHERE incident_number = '$ticketId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ticket.php");
    } else {
        echo "Error closing ticket: " . $conn->error;
    }

    $conn->close();
}
?>
