<?php
include('conn.php');

// Check the connection
// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phno = $_POST["phno"];
  $username = $_POST["username"];
  $password = $_POST["password"]; // Hash the password

  // Insert data into the 'users' table

  if (empty($name) || empty($email) || empty($phno) || empty($username) || empty($password)) {
      echo "Please fill out all the fields.";
  } else if (!preg_match("/^\d{10}$/", $phno)) {
      echo "Phone number must be exactly 10 digits.";
  } else {
      // Hash the password using MD5 (not recommended for production)
      $hashed_password = md5($password);
      $status = 1;
      
      $sql_users = "INSERT INTO users (name, email, phno, username, password, status) VALUES ('$name', '$email', '$phno', '$username', '$ password', '$status')";
      
      if ($conn->query($sql_users) === TRUE) {
          // Insert data into the 'login' table
          $sql_login = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
          
          if ($conn->query($sql_login) === TRUE) {
              // Set a session variable to indicate successful registration
              session_start();
              $_SESSION['username'] = $username;
              echo '<script>alert("User registered  successfully!");</script>';
              header('Location: login.php');
          } else {
              echo "Error inserting data into 'login' table: " . $conn->error;
          }
      } else {
          echo "Error inserting data into 'users' table: " . $conn->error;
      }
  }
}
// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register</title> 
    <link rel="stylesheet" href="css/style1.css">
  </head>
  <body>
    <div class="wrapper">
      <h2>Registration</h2>
      <form action="" method="POST">
        <div class="input-box">
          <input type="text" id="name" name="name" placeholder="Enter your name" required>
          <span id="name-error" class="error"></span>
        </div>
        <div class="input-box">
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
          <span id="email-error" class="error"></span>
        </div>
        <div class="input-box">
          <input type="text" id="phno" name="phno" placeholder="Enter your phone number" required>
          <span id="phno-error" class="error"></span>
        </div>
        <div class="input-box">
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
          <span id="username-error" class="error"></span>
        </div>
        <div class="input-box">
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
          <span id="password-error" class="error"></span>
        </div>
       <!-- <div class="role-field">
          <label for="role">Role:</label>
          <select id="role" name="role">
              <option value="Choose" selected>Choose</option>
              <option value="U">User</option>
              <option value="P">Pg</option>
              <option value="H">Hostel</option>
          </select>
      </div> -->
        <!-- <div class="policy">
          <input type="checkbox">
          <h3>I accept all terms & condition</h3>
        </div> -->
        <div class="input-box button">
          <input type="submit" value="Register Now">
        </div>
        <div class="text">
          <h3>Already have an account? <a href="login.php">Login now</a></h3>
        </div>
      </form>
    </div>
    
    <script>
      document.getElementById("name").addEventListener("input", validateName);
      document.getElementById("email").addEventListener("input", validateEmail);
      document.getElementById("phno").addEventListener("input", validatePhno);
      document.getElementById("username").addEventListener("input", validateUsername);
      document.getElementById("password").addEventListener("input", validatePassword);
      
      function validateName() {
          const nameInput = document.getElementById("name");
          const nameError = document.getElementById("name-error");
          const isValid = /^[A-Za-z]+$/.test(nameInput.value) && nameInput.value.length >= 2 && nameInput.value.length <= 50;
      
          if (!isValid) {
              nameError.textContent = "Invalid name (2 to 50 characters, letters only)";
          } else {
              nameError.textContent = "";
          }
      }
      
      function validateEmail() {
          const emailInput = document.getElementById("email");
          const emailError = document.getElementById("email-error");
          const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
      
          if (!isValid) {
              emailError.textContent = "Invalid email address";
          } else {
              emailError.textContent = "";
          }
      }
      
      function validatePhno() {
          const phnoInput = document.getElementById("phno");
          const phnoError = document.getElementById("phno-error");
          const isValid = /^[0-9]+$/.test(phnoInput.value) && phnoInput.value.length >= 10 && phnoInput.value.length <= 12;
      
          if (!isValid) {
              phnoError.textContent = "Invalid phone number (10 to 12 digits)";
          } else {
              phnoError.textContent = "";
          }
      }
      
      function validateUsername() {
          const usernameInput = document.getElementById("username");
          const usernameError = document.getElementById("username-error");
          const isValid = /^[A-Za-z0-9_]+$/.test(usernameInput.value) && usernameInput.value.length >= 3;
      
          if (!isValid) {
              usernameError.textContent = "Invalid username (at least 3 characters, letters, numbers, and underscores only)";
          } else {
              usernameError.textContent = "";
          }
      }
      
      function validatePassword() {
          const passwordInput = document.getElementById("password");
          const passwordError = document.getElementById("password-error");
          const isValid = passwordInput.value.length >= 8;
      
          if (!isValid) {
              passwordError.textContent = "Invalid password (at least 8 characters)";
          } else {
              passwordError.textContent = "";
          }
      }
      
    </script>
    
  <style>
    .error {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
</style>
</body>
</html>
