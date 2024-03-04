<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Available Rooms</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        select, input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Validation styles */
        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>Insert Available Rooms</h2>
    <form action="insert_available_rooms.php" method="post" onsubmit="return validateForm()">
        <label for="room_type">Room Type:</label>
        <select name="room_type" id="room_type">
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Triple">Triple</option>
             <!-- Add options for other room types -->
        </select>

        <label for="total_rooms">Total Rooms:</label>
        <input type="number" id="total_rooms" name="total_rooms" required>
        <div id="totalRoomsError" class="error-message"></div>

        <label for="available_rooms">Available Rooms:</label>
        <input type="number" id="available_rooms" name="available_rooms" required>
        <div id="availableRoomsError" class="error-message"></div>

        <input type="submit" value="Insert">
    </form>

    <script>
        function validateForm() {
            document.getElementById('totalRoomsError').innerHTML = '';
            document.getElementById('availableRoomsError').innerHTML = '';

            var totalRooms = parseInt(document.getElementById('total_rooms').value); // Parse as integer
            var availableRooms = parseInt(document.getElementById('available_rooms').value); // Parse as integer

            if (totalRooms <= 0) {
                document.getElementById('totalRoomsError').innerHTML = 'Total rooms must be greater than 0.';
                return false;
            }

            if (availableRooms < 0 || availableRooms > totalRooms) {
                document.getElementById('availableRoomsError').innerHTML = 'Available rooms must be between 0 and the total rooms.';
                return false;
            }
            return true;
        }

    </script>
</body>
</html>
















<!-- php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Include your database connection file
include('conn.php');

// Initialize variables to store form data
$room_type = "";
$total_rooms = "";
$available_rooms = "";

// Fetch hostelowner_id based on the logged-in username
$owner_username = $_SESSION['username'];
$get_owner_id_query = "SELECT hostelowner_id FROM hostel_owners1 WHERE username = ?";
$stmt = $conn->prepare($get_owner_id_query);
$stmt->bind_param("s", $owner_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hostelowner_id = $row['hostelowner_id'];
} else {
    // Handle the case where hostelowner_id is not found
    exit("Hostel owner ID not found for the logged-in user.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $room_type = ucfirst($_POST['room_type']);
    $total_rooms = $_POST['total_rooms'];
    $available_rooms = $_POST['available_rooms'];

    // Insert room details into the database
    $insert_query = "INSERT INTO rooms (hostelowner_id, room_type, total_rooms, available_rooms) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isii", $hostelowner_id, $room_type, $total_rooms, $available_rooms);

    if ($stmt->execute()) {
        // Room added successfully
        $success_message = "Room details added successfully.";
    } else {
        // Error occurred
        $error_message = "Error adding room details: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room Details</title>
</head>
<body>
    <h2>Add Room Details</h2>
    php if(isset($success_message)) { ?>
        <div><?php echo $success_message; ?></div>
    php } ?>
    php if(isset($error_message)) { ?>
        <div><?php echo $error_message; ?></div>
    php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="room_type">Room Type:</label>
        <select name="room_type" id="room_type">
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            // Add options for other room types 
        </select><br>

        <label for="total_rooms">Total Rooms:</label>
        <input type="number" id="total_rooms" name="total_rooms" required><br>

        <label for="available_rooms">Available Rooms:</label>
        <input type="number" id="available_rooms" name="available_rooms" required><br>

        <input type="submit" value="Add Room">
    </form>
</body>
</html> -->
