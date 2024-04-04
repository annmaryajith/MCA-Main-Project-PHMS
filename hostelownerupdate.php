<?php
session_start();
include('conn.php'); // Include your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    // Get PG owner's username from the session
    $username = $_SESSION['username'];

    // Retrieve data from the form
    $pg_owner_name = $_POST["pg_owner_name"];
    $new_password = $_POST["new_password"];

    // You should hash the new password for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the PG owner's information in the database
    $update_query = "UPDATE hostel_owners1 SET hostel_owner = '$pg_owner_name', password = '$new_password' WHERE username = '$username'";

    if ($conn->query($update_query) === TRUE) {
        echo '<script>alert("Profile updated successfully!");</script>';
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Fetch hostel owner's name based on the logged-in username
$username = $_SESSION['username'];
$get_owner_name_query = "SELECT hostel_owner FROM hostel_owners1 WHERE username = '$username'";
$result = $conn->query($get_owner_name_query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_hostel_owner_name = $row['hostel_owner'];
} else {
    $current_hostel_owner_name = ''; // Default value if name not found
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hostel Owner Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            height: 100%;
            overflow-y: auto;
            position: fixed;
            background-color: #001f3f; /* Dark blue background color */
            color: #fff;
        }

        .sidebar a {
            padding: 10px;
            display: block;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #003366; /* Slightly lighter shade of blue on hover */
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            color: #333; /* Label text color */
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Border color */
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #001f3f; /* Dark blue button color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition effect */
        }

        input[type="submit"]:hover {
            background-color: #003366; /* Darker shade of blue on hover */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Hostel Owner Dashboard</h2>
        <ul>
            <li><a href="hostelowner_dashboard.php">Home</a></li>
            <li><a href="owner_interface.php">Add Rooms</a></li>
            <li><a href="viewhostelroom.php">View Rooms</a></li>
            <li><a href="add_hostel_details.php">Add Hostel details</a></li>
            <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
            <li><a href="add_hostelowner_details.php">Add owner details</a></li>
                <li><a href="hostelownerupdate.php">Update profile</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2><center>Update Hostel Owner Profile</center></h2>
        <div class="form-container">
            <form method="post" action="">
                <label for="pg_owner_name">Hostel Owner Name:</label>
                <input type="text" name="pg_owner_name" id="pg_owner_name" value="<?php echo $current_hostel_owner_name; ?>" required>
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
                <input type="submit" name="update_profile" value="Update Profile">
            </form>
        </div>
    </div>
    <script>
         function validateForm() {
            var pgOwnerName = document.getElementById('pg_owner_name').value;
            var newPassword = document.getElementById('new_password').value;

            if (pgOwnerName.trim() === '') {
                alert('Please enter Hostel Owner Name');
                return false;
            }

            if (newPassword.trim() === '') {
                alert('Please enter New Password');
                return false;
            }

            // Check if the password length is between 6 and 20 characters
            if (newPassword.length < 6 || newPassword.length > 20) {
                alert('Password must be between 6 and 20 characters');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

