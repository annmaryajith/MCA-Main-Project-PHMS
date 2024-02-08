<?php
include('conn.php'); // Include your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    session_start();

    // Get PG owner's username from the session
    $username = $_SESSION['username'];

    // Retrieve data from the form
    $pg_owner_name = $_POST["pg_owner_name"];
    $new_password = $_POST["new_password"];

    // You should hash the new password for security
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the PG owner's information in the database
    $update_query = "UPDATE pg_owners SET pg_owner= '$pg_owner_name', password = '$new_password' WHERE username = '$username'";

    if ($conn->query($update_query) === TRUE) {
        echo '<script>alert("Profile updated successfully!");</script>';
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update PG Owner Profile</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.container {
    display: flex;
}

.sidebar {
    width: 250px;
    height: 100%;
    overflow-y: auto;
    position: fixed;
    background-color: #333;
    color: #fff;
}

.sidebar a {
    padding: 10px;
    display: block;
    color: #fff;
    text-decoration: none;
}

.sidebar a:hover {
    background-color: #555;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    background-color: #fff;
}

        </style>
</head>
<body>
<div class="container">
        <div class="sidebar">
            <h2>   PHMS | Owner</h2>
            <ul>
                <li><a href="pg_owner_dashboard.php">Home</a></li>
                <li><a href="addpgroom.php">Add Rooms</a></li>
                <li><a href="viewpgroom.php">View room</a></li>
                <li><a href="pgownerupdate.php">Update profile</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
        <!-- <div class="main-content">
            <h1>Welcome, PG Owner!</h1>
        </div>
    </div> -->
    <div class="main-content">
    <h2>Update PG Owner Profile</h2>
    <form method="post" action="">
        <!-- Include form fields for updating profile information -->
        <label for="pg_owner_name">PG Owner Name:</label>
        <input type="text" name="pg_owner_name" id="pg_owner_name" required><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <input type="submit" name="update_profile" id="update" value="Update Profile">
    </form>
    </div>

</body>
</html>
