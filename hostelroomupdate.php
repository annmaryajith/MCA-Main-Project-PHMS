<?php
session_start();
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
    // Get the form data
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];

    // Check if the room number already exists
    $check_query = "SELECT * FROM hostel_rooms WHERE room_number = '$room_number'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Room already exists, update its information
        $update_query = "UPDATE hostel_rooms SET room_type='$room_type', price='$price' WHERE room_number='$room_number'";

        if ($conn->query($update_query) === TRUE) {
            echo '<script>alert("Room information updated successfully!");</script>';
        } else {
            echo "Error updating room information: " . $conn->error;
        }
    } else {
        // Room does not exist, insert a new room
        $insert_query = "INSERT INTO hostel_rooms (room_number, room_type, price) VALUES ('$room_number', '$room_type', '$price')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>alert("Room updated successfully!");</script>';
        } else {
            echo "Error updating room: " . $conn->error;
        }
    }
}

// Retrieve the room data for display or further processing
$room_data_query = "SELECT * FROM hostel_rooms";
$room_data_result = $conn->query($room_data_query);

// Handle the retrieved room data as needed
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        form {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #fff;
    width: 100%; /* Adjust the width percentage as needed */
    max-width: 600px; /* Optionally, set a maximum width */
    margin: 0 auto; /* Center the form horizontally */
}

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
input[type="number"],
select {
    box-sizing: border-box; /* Include padding and border in the element's total width */
    width: calc(100% - 18px); /* Adjust width to accommodate padding and border */
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}


        .error {
            color: red;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #000;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
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

h2 {
    text-align: center; /* Center the heading */
}

.main-content {
    padding: 20px;
    background-color: #fff;
    width: calc(100% - 250px); /* Adjust the width dynamically based on the sidebar width */
}
    </style>
</head>

<body>
<div class="container">
        <div class="sidebar">
            <h2>PG Owner Dashboard</h2>
            <ul>
            <li><a href="hostelowner_dashboard.php">Home</a></li>
                <li><a href="addhostelroom.php">Add Rooms</a></li>
                <li><a href="viewhostelroom.php">View Rooms</a></li>
                <!-- <li><a href="hostelroomupdate.php">Update room</a></li> -->
                <li><a href="hostelownerupdate.php">Update</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
    <?php
    if (isset($_SESSION['username'])) {
        // Check if the room number is provided for updating
        if (isset($_GET['room_number'])) {
            $room_number = $_GET['room_number'];

            // Fetch room details based on the room number
            $room_query = "SELECT * FROM hostel_rooms WHERE room_number = '$room_number'";
            $room_result = $conn->query($room_query);

            if ($room_result->num_rows > 0) {
                $row = $room_result->fetch_assoc();
                // Pre-fill the form fields with existing values
                $room_number = $row['room_number'];
                $room_type = $row['room_type'];
                $price = $row['price'];
            }
        }
        echo '<h2>Update Room</h2>';
            echo '<form method="post" action="" id="addRoomForm">';
            echo '<label for="room_number">Room Number:</label>';
            echo '<input type="text" name="room_number" id="room_number" placeholder="Room Number" required>';
            echo '<span id="roomNumberError" class="error"></span><br>';

            echo '<label for="room_type">Room Type:</label>';
            echo '<select name="room_type" id="room_type" required>';
            echo "<option value=''>Select Room Type</option>"; // Placeholder
            // Fetching room types from the database
            $sql = "SELECT DISTINCT hostel_roomtype FROM hostel_roomtype"; // Modify this query based on your database structure
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['hostel_roomtype'] . "'>" . $row['hostel_roomtype'] . "</option>";
                }
            }
            echo '</select>';
            echo '<span id="roomTypeError" class="error"></span><br>';

            echo '<label for="price">Price:</label>';
            echo '<input type="number" name="price" id="price" placeholder="Price" required>';
            echo '<span id="priceError" class="error"></span><br>';

            echo '<input type="submit" name="add_room" value="Update Room">';
            echo '</form>';
        } else {
            echo "Please log in as a hostel owner.";
        }
            ?>
    </div>
    <!-- Display or process the retrieved room data as needed -->
</body>
</html>
