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

// Retrieve form data
$room_type = $_POST['room_type'];
$total_rooms = $_POST['total_rooms'];
$available_rooms = $_POST['available_rooms'];

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

        // Check if the room already exists for the specified hostel
        $checkExistingQuery = "SELECT * FROM room_types WHERE hostel_id = ? AND room_type_name = ?";
        $stmt = $conn->prepare($checkExistingQuery);
        $stmt->bind_param("is", $hostelId, $room_type);
        $stmt->execute();
        $existingResult = $stmt->get_result();

        if ($existingResult->num_rows == 1) {
            // If the room already exists, display a message and then redirect
            echo '<script>alert("Room already exists. Updating...");';
            echo 'window.location.href = "updateroom_hostelowner.php?room_type=' . urlencode($room_type) . '&total_rooms=' . urlencode($total_rooms) . '&available_rooms=' . urlencode($available_rooms) . '";</script>';
            exit();
        } else {
            // If the room doesn't exist, insert a new entry
            $insertQuery = "INSERT INTO room_types (hostel_id, room_type_name, total_rooms, available_rooms) 
                            VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("issi", $hostelId, $room_type, $total_rooms, $available_rooms);
            if ($stmt->execute()) {
                echo '<script>alert("Room inserted successfully."); window.location.href = "owner_interface.php";</script>';
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: Hostel ID not found.";
    }
} else {
    echo "Error: Hostel name not found.";
}

$stmt->close();
$conn->close();
?>
