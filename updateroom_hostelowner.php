<?php
session_start();
// Include your database connection file
include('conn.php');

// Check if username is set in session
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Retrieve the hostel owner's username from the session
$username = $_SESSION['username'];

// Retrieve form data using GET method
$room_type = $_GET['room_type'];
$total_rooms = $_GET['total_rooms'];
$available_rooms = $_GET['available_rooms'];

// Query the hostel_owners1 table to get the hostel name
$hostelNameQuery = "SELECT hostel_name FROM hostel_owners1 WHERE username = ?";
$stmt = $conn->prepare($hostelNameQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$hostelNameResult = $stmt->get_result();

if ($hostelNameResult->num_rows == 1) {
    $row = $hostelNameResult->fetch_assoc();
    $hostelName = $row['hostel_name'];

    // Query the hostels table to get the hostel ID
    $hostelIdQuery = "SELECT hostel_id FROM hostels WHERE hostel_name = ?";
    $stmt = $conn->prepare($hostelIdQuery);
    $stmt->bind_param("s", $hostelName);
    $stmt->execute();
    $hostelIdResult = $stmt->get_result();

    if ($hostelIdResult->num_rows == 1) {
        $row = $hostelIdResult->fetch_assoc();
        $hostelId = $row['hostel_id'];

        // Execute the update query
        $updateQuery = "UPDATE room_types SET total_rooms = ?, available_rooms = ? WHERE hostel_id = ? AND room_type_name = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiss", $total_rooms, $available_rooms, $hostelId, $room_type);

        if ($stmt->execute()) {
            echo '<script>alert("Room updated successfully."); window.location.href = "owner_interface.php";</script>';
        } else {
            echo '<script>alert("Error updating room."); window.location.href = "owner_interface.php";</script>';
        }
    } else {
        echo '<script>alert("Error: Hostel ID not found."); window.location.href = "owner_interface.php";</script>';
    }
} else {
    echo '<script>alert("Error: Hostel name not found."); window.location.href = "owner_interface.php";</script>';
}

$stmt->close();
$conn->close();
?>
