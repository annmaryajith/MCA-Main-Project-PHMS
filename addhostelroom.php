<?php
include('conn.php'); // Include your database connection code
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        } */

        form {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            max-width: 600px;
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
            <h2>Hostel Owner Dashboard</h2>
            <ul>
            <li><a href="hostelowner_dashboard.php">Home</a></li>
                <li><a href="addhostelroom.php">Add Rooms</a></li>
                <li><a href="viewhostelroom.php">View Rooms</a></li>
                <!-- <li><a href="hostelroomupdate.php">Update room</a></li> -->
                <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
                <li><a href="hostelownerupdate.php">Update</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        // echo "Welcome, $username! Manage your hostels here.";

        // Retrieve the hostel owner's details from the database
        $owner_query = "SELECT * FROM hostel_owners1 WHERE username = '$username'";
        $owner_result = $conn->query($owner_query);

        if ($owner_result->num_rows > 0) {
            $owner_row = $owner_result->fetch_assoc();
            $hostel_owner = $owner_row['username'];
            $hostel_name = $owner_row['hostel_name'];

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
                $room_number = $_POST['room_number'];
                $room_type = $_POST['room_type'];
                $price = $_POST['price'];

                // Insert room details into the hostel_rooms table
                $insert_room_sql = "INSERT INTO hostel_rooms (hostel_name, room_number, room_type, price) VALUES ('$hostel_name', '$room_number', '$room_type', $price)";

                if ($conn->query($insert_room_sql) === TRUE) {
                    echo '<script>alert("Room added successfully!");</script>';
                } else {
                    echo "Error adding room: " . $conn->error;
                }
            }

            // Display Add Room Form
            
            echo '<h2>Add Room</h2>';
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

            echo '<input type="submit" name="add_room" value="Add Room">';
            echo '</form>';
        } else {
            echo "Hostel owner details not found.";
        }
    } else {
        echo "Please log in as a hostel owner.";
    }
    ?>
        </div>
</body>
</html>
