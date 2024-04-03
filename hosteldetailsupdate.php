<?php
// Include necessary files and start session
session_start();
include('conn.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in owner's username
$owner_username = $_SESSION['username'];

// Fetch the owner's ID from the database based on the username
$owner_query = "SELECT hostel_name FROM hostel_owners1 WHERE username = '$owner_username'";
$owner_result = $conn->query($owner_query);

// Check if the owner exists
if ($owner_result->num_rows > 0) {
    $owner_row = $owner_result->fetch_assoc();
    $hostel_name = $owner_row['hostel_name'];

    // Fetch the hostel details associated with the owner from the database
    $hostel_query = "SELECT * FROM hostels WHERE hostel_name = '$hostel_name'";
    $hostel_result = $conn->query($hostel_query);

    // Check if the hostel exists
    if ($hostel_result->num_rows > 0) {
        $hostel_row = $hostel_result->fetch_assoc();
        $hostel_id = $hostel_row['hostel_id'];
        $hostel_name = $hostel_row['hostel_name'];
        $description = $hostel_row['description'];
        $hostel_location = $hostel_row['hostel_location']; // Add this line to fetch hostel location
        // Fetch other details as needed
    } else {
        // Handle the case where the hostel does not exist
        echo "Hostel not found.";
        exit();
    }
} else {
    // Handle the case where the owner does not exist
    echo "Owner not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $new_hostel_name = $_POST['hostel_name'];
    $new_description = $_POST['description'];
    $new_hostel_location = $_POST['hostel_location']; // Add this line to retrieve the updated hostel location

    // Update hostel details in the database
    $update_query = "UPDATE hostels SET hostel_name = '$new_hostel_name', description = '$new_description', hostel_location = '$new_hostel_location' WHERE hostel_id = $hostel_id";
    if ($conn->query($update_query) === TRUE) {
        // Display success message using JavaScript alert
        echo "<script>alert('Hostel details updated successfully.');</script>";

        // Re-fetch the updated hostel details from the database
        $hostel_query = "SELECT * FROM hostels WHERE hostel_id = $hostel_id";
        $hostel_result = $conn->query($hostel_query);

        // Check if the hostel exists and update the variables with the new values
        if ($hostel_result->num_rows > 0) {
            $hostel_row = $hostel_result->fetch_assoc();
            $hostel_name = $hostel_row['hostel_name'];
            $description = $hostel_row['description'];
            $hostel_location = $hostel_row['hostel_location'];
            // Update other variables as needed
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hostel Details</title>
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
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #001f3f; /* Dark blue background matching sidebar */
            color: #fff; /* White text */
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #003366; /* Slightly lighter shade of blue on hover */
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
            <li><a href="hostelownerupdate.php">Update profile</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1><center>Update Hostel Details</center></h1>
        <div class="form-container">
            <form method="post" action="" id="updateHostelForm">
                <label for="hostel_name">Hostel Name:</label>
                <input type="text" id="hostel_name" name="hostel_name" value="<?php echo $hostel_name; ?>" required>
                <br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required><?php echo $description; ?></textarea>
                <br>

                <label for="hostel_location">Location:</label> <!-- Change this label to Location -->
                <input type="text" id="hostel_location" name="hostel_location" value="<?php echo $hostel_location; ?>" required> <!-- Add value attribute to populate the field with existing value -->
                <br>

                <!-- Other form fields can be added here -->

                <input type="submit" value="Update Hostel">
            </form>
        </div>
    </div>
</body>
</html>
