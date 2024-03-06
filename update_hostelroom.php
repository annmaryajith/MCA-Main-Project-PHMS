<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room Details</title>
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
        <h2>Update Room Details</h2>
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

        // Check if room type name is provided in the URL
        if (!isset($_GET['room_type_name'])) {
            // Redirect back to the viewhostelroom page if room type name is not provided
            header("Location: viewhostelroom.php");
            exit();
        }

        // Get the room type name from the URL
        $room_type_name = $_GET['room_type_name'];

        // Retrieve room details based on the provided room type name
        $room_query = "SELECT rt.*, hd.price_per_day, hd.price_per_month 
                        FROM room_types rt
                        LEFT JOIN hostelprice_details hd ON rt.room_type_id = hd.room_type_id
                        WHERE rt.room_type_name = '$room_type_name'";
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
            $room_type_name = $_POST['room_type_name'];
            $total_rooms = $_POST['total_rooms'];
            $available_rooms = $_POST['available_rooms'];
            $price_per_day = $_POST['price_per_day'];
            $price_per_month = $_POST['price_per_month'];

            // Validate input
            if (!is_numeric($total_rooms) || !is_numeric($available_rooms) || !is_numeric($price_per_day) || !is_numeric($price_per_month) || $total_rooms < 0 || $available_rooms < 0 || $price_per_day < 0 || $price_per_month < 0) {
                $update_error = "Please enter valid numeric values for total rooms, available rooms, price per day, and price per month.";
            } elseif ($available_rooms > $total_rooms) {
                $update_error = "Available rooms cannot be greater than total rooms.";
            } else {
                // Update the room details in the database
                $update_query = "UPDATE room_types rt
                    LEFT JOIN hostelprice_details hd ON rt.room_type_id = hd.room_type_id
                    SET rt.total_rooms = '$total_rooms',
                        rt.available_rooms = '$available_rooms',
                        hd.price_per_day = '$price_per_day', 
                        hd.price_per_month = '$price_per_month'
                    WHERE rt.room_type_name = '$room_type_name'";

                if ($conn->query($update_query) === TRUE) {
                    // Display success message and redirect to viewhostelroom page
                    echo "<script>alert('Room updated successfully.'); window.location.href = 'viewhostelroom.php';</script>";
                    exit();
                } else {
                    // Handle update error
                    $update_error = "Error updating room: " . $conn->error;
                }
            }
        }
        ?>

        <form method="post" action="" onsubmit="return validateForm()">
            <label for="room_type">Room Type:</label>
            <input type="text" name="room_type_name" id="room_type_name" value="<?php echo $room_data['room_type_name']; ?>" readonly>
            <label for="total_rooms">Total Rooms:</label>
            <input type="number" name="total_rooms" id="total_rooms" value="<?php echo $room_data['total_rooms']; ?>" required>
            <label for="available_rooms">Available Rooms:</label>
            <input type="number" name="available_rooms" id="available_rooms" value="<?php echo $room_data['available_rooms']; ?>" required>
            <label for="price_per_day">Price Per Day:</label>
            <input type="number" name="price_per_day" id="price_per_day" value="<?php echo $room_data['price_per_day']; ?>" required>
            <label for="price_per_month">Price Per Month:</label>
            <input type="number" name="price_per_month" id="price_per_month" value="<?php echo $room_data['price_per_month']; ?>" required>
            <input type="submit" name="update_room" value="Update Room">
        </form>
        <?php if (isset($update_error)) echo '<div class="error">' . $update_error . '</div>'; ?>

        <script>
            function validateForm() {
        var totalRooms = parseInt(document.getElementById("total_rooms").value);
        var availableRooms = parseInt(document.getElementById("available_rooms").value);

        if (isNaN(totalRooms) || isNaN(availableRooms) || totalRooms < 0 || availableRooms < 0) {
            alert("Please enter valid numeric values for total rooms and available rooms.");
            return false;
        }

        if (availableRooms > totalRooms) {
            alert("Available rooms cannot be greater than total rooms.");
            return false;
        }

        return true;
    }
        </script>
    </div>
</body>
</html>
