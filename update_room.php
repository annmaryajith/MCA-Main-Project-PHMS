<?php
session_start();
include('conn.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's username from the session
$username = $_SESSION['username'];

// Retrieve user ID based on the username
$user_query = "SELECT user_id FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows == 1) {
    // Fetch the user ID
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['user_id'];
} else {
    // Handle the case where user ID is not found
    echo "Error: User ID not found.";
    exit();
}

// Retrieve form data and perform input validation
$booked_room_type = isset($_POST['booked_room_type']) ? $_POST['booked_room_type'] : null;
$advance_payment = isset($_POST['advance_payment']) ? $_POST['advance_payment'] : 0;
$hostel_id = isset($_POST['hostel_id']) ? $_POST['hostel_id'] : null;
$check_in_date = isset($_POST['check_in_date']) ? $_POST['check_in_date'] : null;
$check_out_date = isset($_POST['check_out_date']) ? $_POST['check_out_date'] : null;

// if (!$booked_room_type || !$hostel_id || !$check_in_date || !$check_out_date) {
//     // Handle the case where required fields are not provided
//     echo "Error: Required fields are missing.";
//     exit();
// }

// // Check if the check-out date is before the check-in date
// if ($check_out_date < $check_in_date) {
//     echo "Error: Check-out date cannot be before check-in date.";
//     exit();
// }

// Check the availability of rooms for the selected room type
$availability_query = "SELECT available_rooms FROM room_types WHERE room_type_name = ?";
$stmt = $conn->prepare($availability_query);
$stmt->bind_param("s", $booked_room_type);
$stmt->execute();
$availability_result = $stmt->get_result();

if ($availability_result && $availability_result->num_rows > 0) {
    $row = $availability_result->fetch_assoc();
    $available_rooms = $row['available_rooms'];

    // Check if there are available rooms
    if ($available_rooms > 0) {
        // Decrement the available rooms count
        $updated_available_rooms = $available_rooms - 1;

        // Update the available rooms count in the database
        $update_query = "UPDATE room_types SET available_rooms = ? WHERE room_type_name = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("is", $updated_available_rooms, $booked_room_type);
        if ($stmt->execute()) {
            // Room booked successfully

            // Insert booking details into the database
            $insert_booking_query = "INSERT INTO book (user_id, hostel_id, booked_room_type, checkin_date, checkout_date, booking_date) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($insert_booking_query);
            $stmt->bind_param("iisss", $user_id, $hostel_id, $booked_room_type, $check_in_date, $check_out_date);
            if ($stmt->execute()) {
                // Booking details inserted successfully
                // After successfully inserting booking details into the database
                $book_id = $conn->insert_id; // Assuming $conn is your MySQLi connection object
                $_SESSION['book_id'] = $book_id;

                // Check if the user has opted for advance payment
                if ($advance_payment == 1) {
                    // Include payment processing logic
                    include('payment.php');
                    // This will execute the payment processing logic from payment.php
                } else {
                    // If no advance payment is made, display the booking confirmation message
                    // Use JavaScript to show an interactive message
                    echo '<script>alert("Booking Done. No advance payment made."); window.location.href = "user.php";</script>';
                }
            } else {
                echo "Error inserting booking: " . $stmt->error;
            }
        } else {
            echo "Error updating available rooms: " . $stmt->error;
        }
    } else {
        echo '<script>alert("No available rooms for the selected room type."); window.location.href = "book_room.php";</script>';

    }
} else {
    echo "Room type not found.";
}

$stmt->close(); // Close the prepared statement
$conn->close(); // Close the database connection
?>
