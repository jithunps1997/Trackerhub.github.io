<?php
// Include your database connection file
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';

$ticket = null; // Initialize the $ticket variable

if (isset($_GET['incident_number'])) {
    $ticketId = $_GET['incident_number'];

    // Retrieve ticket data from the database
    $sql = "SELECT * FROM contact WHERE incident_number = '$ticketId'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error fetching ticket: " . $conn->error);
    }

    $ticket = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Ticket</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 6px;
        }

        /* Heading Styles */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        h3 {
            color: #007bff;
            margin-bottom: 10px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Comment Box Styles */
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            margin-bottom: 10px;
            resize: vertical;
        }

        /* Submit Button Styles */
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Flex Container Styles */
        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* Comment and Close Sections */
        .comment-section, .close-section {
            width: 48%;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Ticket</h2>
        <?php if ($ticket) { ?>
            <table>
                <tr>
                    <th>Incident Number:</th>
                    <td><?php echo $ticket['incident_number']; ?></td>
                </tr>
                <tr>
                    <th>Customer:</th>
                    <td><?php echo $ticket['email']; ?></td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <td><?php echo $ticket['status']; ?></td>
                </tr>
            </table>
            <h3>Comments</h3>
            <?php
            $ticketComments = "SELECT * FROM contact WHERE incident_number = '$ticketId'";
            $commentResult = $conn->query($ticketComments);
            if ($commentResult) {
                while ($comment = $commentResult->fetch_assoc()) {
                    echo "<p>{$comment['message']}</p>";
                }
            }
            ?>

            <div class="flex-container">
                <div class="comment-section">
                    <h3>Add Comment</h3>
                    <form method="post" action="add_comment.php">
                        <input type="hidden" name="incident_number" value="<?php echo $ticketId; ?>">
                        <textarea name="ticket_comments" rows="4" cols="50"></textarea><br>
                        <input type="submit" value="Add comment">
                    </form>
                </div>
                <div class="close-section">
                    <?php if ($ticket['status'] !== 'Resolved') { ?>
                        <h3>Close Ticket</h3>
                        <form method="post" action="close_ticket.php">
                            <input type="hidden" name="incident_number" value="<?php echo $ticketId; ?>">
                            <input type="submit" value="Close Ticket">
                        </form>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <p>Ticket not found.</p>
        <?php } ?>
    </div>
</body>
</html>