<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PG Owner Dashboard</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        } */

        h2 {
            /* text-align: center; */
            color: #333;
        }

        /* form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        } */

        /* label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        } */

        /* input[type="text"],
        input[type="number"] {
            width: 50%;
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
        } */

        /* input[type="submit"]:hover {
            background-color: #222;
        } */

        /* Add this CSS to center-align the error message */
        .error {
            color: red;
            font-size: 14px;
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

<?php
include('conn.php'); // Include your database connection code
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // echo "Welcome, $username! Manage your pg rooms here.";

    // Retrieve the hostel owner's details from the database
    $owner_query = "SELECT * FROM pg_owners WHERE username = '$username'";
    $owner_result = $conn->query($owner_query);

    if ($owner_result->num_rows > 0) {
        $owner_row = $owner_result->fetch_assoc();
        $pg_owner_id = $owner_row['pgowner_id'];
        $pg_owner = $owner_row['pg_name'];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
            $room_number = $_POST['room_number'];
            $room_type = $_POST['room_type'];
            $price = $_POST['price'];

            // Insert room details into the hostel_rooms table
            $insert_room_sql = "INSERT INTO pg_room (pgowner_id,pg_name, room_number, room_type, price) VALUES ('$pg_owner_id','$pg_owner', '$room_number', '$room_type', $price)";

            if ($conn->query($insert_room_sql) === TRUE) {
                echo '<script>alert("Room added successfully!");</script>';
            } else {
                echo "Error adding room: " . $conn->error;
            }
        }

        // Display Add Room Form
        echo '
        <div class="main-content">
        <h2>Add Room</h2>
        <form method="post" action="" id="addRoomForm">
    <input type="text" name="room_number" id="room_number" placeholder="Room Number" required>
    <span id="roomNumberError" class="error"></span><br><br>

    <input type="text" name="room_type" id="room_type" placeholder="Room Type" required>
    <span id="roomTypeError" class="error"></span><br><br>

    <input type="number" name="price" id="price" placeholder="Price" required>
    <span id="priceError" class="error"></span><br><br>

    <input type="submit" name="add_room" value="Add Room">
</form>
<script>
    const addRoomForm = document.getElementById("addRoomForm");
    const roomNumber = document.getElementById("room_number");
    const roomType = document.getElementById("room_type");
    const price = document.getElementById("price");
    const roomNumberError = document.getElementById("roomNumberError");
    const roomTypeError = document.getElementById("roomTypeError");
    const priceError = document.getElementById("priceError");

    addRoomForm.addEventListener("submit", function (event) {
        let isValid = true;

        if (roomNumber.value.trim() === "") {
            roomNumberError.textContent = "Room Number is required.";
            isValid = false;
        } else {
            roomNumberError.textContent = "";
        }

        if (roomType.value.trim() === "") {
            roomTypeError.textContent = "Room Type is required.";
            isValid = false;
        } else {
            roomTypeError.textContent = "";
        }

        if (isNaN(price.value) || price.value <= 0) {
            priceError.textContent = "Price must be a valid positive number.";
            isValid = false;
        } else {
            priceError.textContent = "";
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are validation errors.
        }
    });
</script>
</div>
        ';
    } else {
        echo "Pg owner details not found.";
    }
} else {
    echo "Please log in as a pg owner.";
}
?>
</body>
</html>
