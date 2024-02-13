<?php
// Include necessary files and start session
session_start();
include('conn.php');

// Check if the owner is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if room number is provided in the URL
if (!isset($_GET['room_number'])) {
    // Redirect back to the viewhostelroom page if room number is not provided
    header("Location: viewhostelroom.php");
    exit();
}

// Get the room number from the URL
$room_number = $_GET['room_number'];

// Retrieve room details based on the provided room number
$room_query = "SELECT * FROM hostel_rooms WHERE room_number = '$room_number'";
$room_result = $conn->query($room_query);

// Check if room exists
if ($room_result->num_rows === 0) {
    // Redirect back to the viewhostelroom page if room does not exist
    header("Location: viewhostelroom.php");
    exit();
}

// Fetch room details
$room_data = $room_result->fetch_assoc();

// Check if form is submitted for updating the room
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_room'])) {
    // Get the form data
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];

    // Update the room details in the database
    $update_query = "UPDATE hostel_rooms SET room_type = '$room_type', price = '$price' WHERE room_number = '$room_number'";
    if ($conn->query($update_query) === TRUE) {
        // Display success message and redirect to viewhostelroom page
        echo "<script>alert('Room updated successfully.'); window.location.href = 'viewhostelroom.php';</script>";
        exit();
    } else {
        // Handle update error
        $update_error = "Error updating room: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Room</h2>
        <form method="post" action="">
            <label for="room_number">Room Number:</label>
            <input type="text" name="room_number" id="room_number" value="<?php echo $room_data['room_number']; ?>" readonly>
            <label for="room_type">Room Type:</label>
            <input type="text" name="room_type" id="room_type" value="<?php echo $room_data['room_type']; ?>" required>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo $room_data['price']; ?>" required>
            <input type="submit" name="update_room" value="Update Room">
        </form>
        <?php if (isset($update_error)) echo '<div class="error">' . $update_error . '</div>'; ?>
    </div>
</body>
</html>

