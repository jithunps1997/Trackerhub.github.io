<?php
// Include your database connection file
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketId = $_POST["incident_number"];
    $comment = $_POST["ticket_comments"];

    // Insert comment into the database
    $sql = "UPDATE contact SET ticket_comments = '$comment' WHERE incident_number = '$ticketId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_tickets.php?incident_number=$ticketId");
    } else {
        echo "Error adding comment: " . $conn->error;
    }

    $conn->close();
}
?>
