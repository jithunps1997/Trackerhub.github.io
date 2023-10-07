<?php
session_start();
include 'C:\xampp\htdocs\JPS\apps\Moneymgmt_Prod\Config\db_config.php';

// Disable caching for the page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Function to log login session to database with status
function logLoginSessionToDB($conn, $username, $status) {
    $sql = "INSERT INTO login_sessions (username, status) VALUES ('$username', '$status')";
    if ($conn->query($sql) === TRUE) {
        // Log added successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to lock an account
function lockAccount($conn, $username) {
    $sql = "UPDATE registration SET failed_attempts = 'locked' WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
        // Account locked successfully
        logLoginSessionToDB($conn, $username, 'locked'); // Log the "locked" status
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check if the provided username exists in the database
    $sql = "SELECT * FROM registration WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User exists
        $row = $result->fetch_assoc();

        if ($row["failed_attempts"] == 'locked') {
            // Account is locked, display an error message or redirect to a locked account page
            header("Location: account-locked.php");
            exit();
        }

        if ($password === $row["password"]) { // Compare plain text passwords
            // Login successful
            $_SESSION["username"] = $username;

            if ($row["role"] == "admin") {
                header("Location: home.html"); // Redirect to admin page
            } else {
                header("Location: customerpage.html"); // Redirect to dashboard page
            }

            $status = "success"; // Set the status as "success"
        } else {
            // Login failed
            $status = "failure"; // Set the status as "failure"

            // Increment failed login attempts
            $failedAttempts = $row["failed_attempts"] + 1;
            $sql = "UPDATE registration SET failed_attempts = $failedAttempts WHERE username = '$username'";
            $conn->query($sql);

            // If failed attempts reach 2, lock the account
            if ($failedAttempts >= 3) {
                lockAccount($conn, $username);
                header("Location: account-locked.php"); // Redirect to locked account page
                exit();
            }

            // Log login failure
            logLoginSessionToDB($conn, $username, $status);

            header("Location: login-error.html");
            exit();
        }

        // Log login success
        logLoginSessionToDB($conn, $username, $status);

        exit(); // Make sure to exit after redirection
    } else {
        // User does not exist, display an error message or redirect to an error page
        header("Location: user-not-found.html");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script>
    function showAlert() {
        alert("Account registered Successfully");
    }
</script>
    <link rel="stylesheet" href="css/login.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form" method="post" >
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required/>
            </div>
            <input type="submit" name="login" value="Login" class="btn solid" />
            <p class="social-text">Need help?</p>
            <div class="social-media">
          <a href="customersupport.php" class="">
           <i class=""></i>
           Customer Support
            </a>
  </div>
  <div>
              <a href="forgotpassword.php" class="">
                <i class=""></i>
                 Forgot Password
              </a>
            </div>
          </form>
          <form action="Registration.php" class="sign-up-form" method="post" onsubmit="showAlert()">
            <h2 class="title">Sign up</h2>
            <input type="hidden" name="location" value="Bengaluru">
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="name" placeholder="Full Name" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="ConfirmPassword" required/>
            </div>
            <input type="submit" name="register" class="btn" value="Sign up" />
            <p class="social-text">Or Sign up with social platforms</p>
            <div class="social-media">
            <div class="social-media">
          <a href="fb.php" class="social-icon">
           <i class="fab fa-facebook-f"></i>
            </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Daytrack</h3>
            <p>
             New here? Please register to our app Version 1.0 (Developer - Jithun PS)
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="aset/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Daytrack</h3>
            <p>
             I developed this application to control, manage and initiate our most critical problem
             Day to day management
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="aset/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
        <script src="logic/auth.js"></script>
  </body>
</html>
