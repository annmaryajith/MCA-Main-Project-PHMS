<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include your database connection file
include('conn.php');

// Retrieve the logged-in user's username from the session
$username = $_SESSION['username'];

// Retrieve user ID based on the username
$user_query = "SELECT user_id FROM users WHERE username = '$username'";
$user_result = $conn->query($user_query);

if ($user_result->num_rows == 1) {
    // Fetch the user ID
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['user_id'];
} else {
    // Handle the case where user ID is not found
    echo "Error: User ID not found.";
    exit();
}

// Retrieve form data
$booked_room_type = $_POST['booked_room_type'];

// Check the availability of rooms for the selected room type
$availability_query = "SELECT available_rooms FROM room_types WHERE room_type_name = '$booked_room_type'";
$availability_result = $conn->query($availability_query);

if ($availability_result && $availability_result->num_rows > 0) {
    $row = $availability_result->fetch_assoc();
    $available_rooms = $row['available_rooms'];

    // Debugging: Print the number of available rooms
    echo "Available rooms for $booked_room_type: $available_rooms<br>";

    // Check if there are available rooms
    if ($available_rooms > 0) {
        // Decrement the available rooms count
        $updated_available_rooms = $available_rooms - 1;

        // Debugging: Print the updated number of available rooms
        echo "Updated available rooms for $booked_room_type: $updated_available_rooms<br>";

        // Update the available rooms count in the database
        $update_query = "UPDATE room_types SET available_rooms = $updated_available_rooms WHERE room_type_name = '$booked_room_type'";
        if ($conn->query($update_query) === TRUE) {
            // Room booked successfully
            echo "Room booked successfully.";

            // Insert booking details into the database using 'room_type_name' column
            $insert_booking_query = "INSERT INTO book(user_id, booked_room_type, booking_date) VALUES ('$user_id', '$booked_room_type', NOW())";
            if ($conn->query($insert_booking_query) === TRUE) {
                echo " Booking details inserted successfully.";
            } else {
                echo "Error inserting booking: " . $conn->error;
            }
        } else {
            echo "Error updating available rooms: " . $conn->error;
        }
    } else {
        echo "No available rooms for the selected room type.";
    }
} else {
    echo "Room type not found.";
}

$conn->close();
?>
