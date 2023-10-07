<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php';  // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"]; // Get the logged-in username from the session
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $date = date("Y-m-d H:i:s"); // Get the current date and time
    
 // Generate a random incident number
 $randomNumber = mt_rand(100, 999); // Generates a random 7-digit number
 $incidentNumber = "INC" . $randomNumber . "1098";

    // Retrieve the email associated with the logged-in username
    $emailQuery = "SELECT email FROM registration WHERE username='$username'";
    $emailResult = $conn->query($emailQuery);
    
    if ($emailResult->num_rows == 1) {
        $row = $emailResult->fetch_assoc(); 
        $email = $row["email"];
        $status = 'open';
        
        // Insert contact details into the database
        $sql = "INSERT INTO contact (name, email, subject, message,date, incident_number,status) 
                VALUES ('$username', '$email', '$subject', '$message', '$date', '$incidentNumber','$status')";
        
        if ($conn->query($sql) === TRUE) {
            // Call the showAlert function
            header("Location: home.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/logspic.jpg'); /* Relative path to your background image */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555555;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        textarea {
            resize: vertical;
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
        /* Styling for the logout link */
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
</head>
<body>

<div class="container">
<div class="signout-buttons">
        <a href="userpage.html" class="signout-link">Go Back</a>
    </div>
    <h2>Report a Case</h2>

    <form method="post" action="contact.php" onsubmit="showAlert()">

        <label for="recipient">To:</label>
        <input type="text" name="recipient" id="recipient" value="Admin team" readonly>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="4" required></textarea>

        <input type="submit" value="Send Message">
        <p>Want to track the status of your ticket? <a href="track_ticket.php">Click here</a></p>
    </form>
</div>
<script>
    function showAlert() {
        alert("Incident has been created. You can track the status via home page (Track issue). Issue will be addressed within 24 hrs");
    }
</script>


</body>
</html>
