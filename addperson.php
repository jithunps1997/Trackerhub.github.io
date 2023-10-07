<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_prod\Config\db_config.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"]; // Hash the password
    $submissionDate = date("Y-m-d H:i:s");
    $role = 'user';
    $location = 'bangalore';

    // SQL query to insert user data
    $sql = "INSERT INTO registration (name, email, username, password, role, date, location) VALUES ('$name','$email','$username','$password','$role','$submissionDate','$location')";

    if ($conn->query($sql) === TRUE) {
        header("Location: iam-panel.html");
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Form</title>
    <style>
        /* Style for the form container */
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        /* Style for the input fields */
        .input-field {
            margin-bottom: 15px;
            position: relative;
        }

        .input-field i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #555555;
        }

        .input-field input[type="text"],
        .input-field input[type="email"],
        .input-field input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        /* Style for the submit button */
        .btn {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        /* Add some spacing between the form fields */
        .form-container input[type="submit"],
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            margin-bottom: 10px;
        }

        /* Style for the table header */
        .table-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
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
            alert("User activated Successfully");
        }
        </script>
</head>
<body>
<div class="form-container">
    <h2 class="table-header">Persons</h2> <!-- Add table header here -->
    <div class="signout-buttons">
        <a href="iam-panel.html" class="signout-link">Go Back</a>
    </div>
    <form method="POST" action="" onsubmit="showAlert()">
        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="name" placeholder="Full Name" required />
        </div>
        <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
        </div>
        <input type="submit" name="register" class="btn" value="Create Account" />
    </form>
</div>
</body>
</html>