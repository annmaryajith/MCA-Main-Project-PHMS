<?php
session_start();
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
    // Get the form data
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price = $_POST['price'];

    // Check if the room number already exists
    $check_query = "SELECT * FROM pg_room WHERE room_number = '$room_number'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Room already exists, update its information
        $update_query = "UPDATE pg_room SET room_type='$room_type', price='$price' WHERE room_number='$room_number'";

        if ($conn->query($update_query) === TRUE) {
            echo '<script>alert("Room information updated successfully!");</script>';
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "viewpgroom.php";
                    }, 1000); // Redirect after 1 second
                  </script>';
        } else {
            echo "Error updating room information: " . $conn->error;
        }
    } else {
        // Room does not exist, insert a new room
        $insert_query = "INSERT INTO pg_room (room_number, room_type, price) VALUES ('$room_number', '$room_type', '$price')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>alert("Room updated successfully!");</script>';
            header('Location: viewpgroom.php'); // Redirect to viewpgroom.php
            exit();
        } else {
            echo "Error updating room: " . $conn->error;
        }
    }
}

// Retrieve the room data for display or further processing
$room_data_query = "SELECT * FROM pg_room";
$room_data_result = $conn->query($room_data_query);

// Handle the retrieved room data as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (your head content remains the same) ... -->
</head>
<body>
    <h1><center>Room Management</center></h1>
    <form method="post" action="" id="addRoomForm">
    <input type="text" name="room_number" id="room_number" placeholder="Room Number" required>
    <span id="roomNumberError" class="error"></span>

    <input type="text" name="room_type" id="room_type" placeholder="Room Type" required>
    <span id="roomTypeError" class="error"></span>

    <input type="number" name="price" id="price" placeholder="Price" required>
    <span id="priceError" class="error"></span>

    <input type="submit" name="add_room" value="Update Room">
    </form>
    <br><br>
    <!-- Display or process the retrieved room data as needed -->
</body>
</html>
