<?php
// Start the session to access session variables
session_start();

// Include the connection file
include('conn.php');

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    // Fetch the username from the session
    $username = $_SESSION['username'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize the input data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phno = filter_var($_POST['phno'], FILTER_SANITIZE_NUMBER_INT); // Sanitize the phone number input

        // Prepare and execute the SQL query to update owner details only for the logged-in user
        $query = "UPDATE hostel_owners1 SET email = ?, phno = ? WHERE username = ? AND username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $email, $phno, $username, $username);
        
        // Check if the query execution is successful
        if ($stmt->execute()) {
            echo "<script>alert('Owner details added successfully.');</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
} else {
    // Redirect to the login page if the username is not set in the session
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Owner Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
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
            margin-left: 250px; /* Adjusted for sidebar width */
            padding: 20px;
            background-color: #fff;
            width: calc(100% - 250px); /* Adjusted for sidebar width */
        }

        form {
            max-width: 400px; /* Adjust form width */
            margin: 20px auto; /* Center align the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333; /* Label text color */
        }

        input[type="email"],
        input[type="tel"],
        input[type="submit"] {
            width: 100%;
            padding: 12px; /* Increased padding for better spacing */
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Border color */
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #001f3f; /* Dark blue button color */
            color: #fff;
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
<div class="container">
    <div class="sidebar">
        <h2>PHMS | Hostel Owner</h2>
        <ul>
            <li><a href="hostelowner_dashboard.php">Home</a></li>
            <li><a href="owner_interface.php">Add Rooms</a></li>
            <li><a href="viewhostelroom.php">View Rooms</a></li>
            <li><a href="add_hostel_details.php">Add Hostel details</a></li>
            <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
            <li><a href="add_hostelowner_details.php">Add owner details</a></li>
            <li><a href="hostelownerupdate.php">Update </a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1 style="margin-top: 20px; color: #333; text-align: center;">Add Owner Details</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phno">Phone Number:</label>
            <input type="tel" id="phno" name="phno" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" value="" required><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>
</body>
</html>
