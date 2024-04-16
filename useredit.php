<?php
session_start();
// Include your database connection file
include('conn.php');

 // Start the session to access user data
 $currentName = $currentEmail = $currentPhone = $currentUsername = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated profile information from the form
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPhone = $_POST['newPhone'];

    // Get the updated username and password from the form
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    // Update the user's profile in the database
    $username = $_SESSION['username']; // Get the username from the session

    $sql = "UPDATE users SET name='$newName', email='$newEmail', phno='$newPhone', username='$newUsername', password='$newPassword' WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Profile updated successfully!");</script>';
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}


// Retrieve the user's current profile data
$username = $_SESSION['username']; // Get the username from the session
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $currentName = $row['name'];
    $currentEmail = $row['email'];
    $currentPhone = $row['phno'];
    $currentUsername = $row['username']; // Add this line to retrieve the current username
    $currentPassword = $row['password']; // Add this line to retrieve the current password
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/styleuser.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="">
            <span>
              PHMS
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
              <!-- <li class="nav-item active">
                <a class="nav-link" href="userhome.php">Home <span class="sr-only">(current)</span></a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="pguserview.php"> PG</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user.php">HOSTEL</a>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile & Booking
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="useredit.php">Edit Profile</a>
                    <a class="dropdown-item" href="view_booking.php">View Booking</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php"> <i class="fa fa-user" aria-hidden="true"></i> Logout</a>
              </li>
              </form>
            </ul>
          </div>
        </nav>
      </div>
      <br><br>
    <!-- <form action="search.php" method="GET">
    <div class="search-container">
        <input type="text" name="query" placeholder="Search..." />
        <button type="submit">Search</button>
    </div>
    </form> -->
    <style>
    form {
        max-width: 400px;
        margin: 0 auto;
        background-color: #f7f7f7;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    input[type="password"],input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #222;
    }

    .error {
            color: red;
    }
    </style>

    <title>Edit Profile</title>
</head>
<body>
    <h1><center>Edit Your Profile</center></h1>
    <form id="editProfileForm" method="POST" action="">
    <label for="newName">Name:</label>
    <input type="text" id="newName" name="newName" value="<?php echo $currentName; ?>" required>
    <span id="nameError" class="error"></span><br>

    <label for="newEmail">Email:</label>
    <input type="email" id="newEmail" name="newEmail" value="<?php echo isset($currentEmail) ? $currentEmail : ''; ?>" required>
    <span id="emailError" class="error"></span><br>

    <label for="newPhone">Phone:</label>
    <input type="text" id="newPhone" name="newPhone" value="<?php echo $currentPhone; ?>" required>
    <span id="phoneError" class="error"></span><br>

    <label for="newUsername">Username:</label>
    <input type="text" id="newUsername" name="newUsername" value="<?php echo $currentUsername; ?>" required>
    <span id="usernameError" class="error"></span><br>

    <label for="newPassword">Password:</label>
    <input type="password" id="newPassword" name="newPassword" required>
    <span id="passwordError" class="error"></span><br>

    <input type="submit" value="Update Profile">
</form>
<script>
        // Function to validate the form
        function validateForm() {
            var name = document.getElementById("newName").value;
            var email = document.getElementById("newEmail").value;
            var phone = document.getElementById("newPhone").value;
            var username = document.getElementById("newUsername").value;
            var password = document.getElementById("newPassword").value;

            // Validate name
            if (name.trim() == "" || name.length < 3  || name.length > 25) {
                document.getElementById("nameError").innerText = "Name must be between 3 and 25 characters";
                return false;
            }

            // Validate email
            if (email.trim() == "") {
                document.getElementById("emailError").innerText = "Email is required";
                return false;
            } else if (!isValidEmail(email)) {
                document.getElementById("emailError").innerText = "Invalid email format";
                return false;
            }

            // Validate phone
            if (phone.trim() == "") {
                document.getElementById("phoneError").innerText = "Phone is required";
                return false;
            } else if (!isValidPhone(phone)) {
                document.getElementById("phoneError").innerText = "Invalid phone number";
                return false;
            }

            // Validate username
            if (username.trim() == "" || username.length < 3) {
                document.getElementById("usernameError").innerText = "Username must be at least 3 characters";
                return false;
            }

            // Validate password
            if (password.trim() == "" || password.length < 8) {
                document.getElementById("passwordError").innerText = "Password must be at least 8 characters";
                return false;
            }

            return true;
        }

        // Function to validate email format
        function isValidEmail(email) {
            var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return emailRegex.test(email);
        }

        // Function to validate phone number format
        function isValidPhone(phone) {
            var phoneRegex = /^\d{10}$/; // Assuming a 10-digit phone number format
            return phoneRegex.test(phone);
        }

        // Add event listener to form submit
        document.getElementById("editProfileForm").addEventListener("submit", function(event) {
            // Clear previous error messages
            document.querySelectorAll(".error").forEach(function(element) {
                element.innerText = "";
            });

            // Validate form
            if (!validateForm()) {
                // Prevent form submission if validation fails
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
