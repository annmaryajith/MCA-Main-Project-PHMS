<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('conn.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Retrieve form data using POST method
$room_type = $_POST['room_type'];
$total_rooms = $_POST['total_rooms'];
$available_rooms = $_POST['available_rooms'];
$price_per_day = isset($_POST['price_per_day']) ? $_POST['price_per_day'] : null;
$price_per_month = isset($_POST['price_per_month']) ? $_POST['price_per_month'] : null;

// Check if the database connection is established successfully
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Query to get the hostel ID based on username
$hostelNameQuery = "SELECT hostel_name FROM hostel_owners1 WHERE username = ?";
$stmt = $conn->prepare($hostelNameQuery);

if ($stmt === false) {
    die("ERROR: Failed to prepare statement. " . $conn->error);
}

$stmt->bind_param("s", $username);

if ($stmt->execute() === false) {
    die("ERROR: Execution failed: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result === false) {
    die("ERROR: Failed to get result set. " . $stmt->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hostelName = $row['hostel_name'];

    // Query to get the hostel ID based on hostel name
    $hostelIdQuery = "SELECT hostel_id FROM hostels WHERE hostel_name = ?";
    $stmt = $conn->prepare($hostelIdQuery);

    if ($stmt === false) {
        die("ERROR: Failed to prepare statement. " . $conn->error);
    }

    $stmt->bind_param("s", $hostelName);

    if ($stmt->execute() === false) {
        die("ERROR: Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result === false) {
        die("ERROR: Failed to get result set. " . $stmt->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hostelId = $row['hostel_id'];

        // Check if the room already exists for the specified hostel
        $checkExistingQuery = "SELECT * FROM room_types WHERE hostel_id = ? AND room_type_name = ?";
        $stmt = $conn->prepare($checkExistingQuery);

        if ($stmt === false) {
            die("ERROR: Failed to prepare statement. " . $conn->error);
        }

        $stmt->bind_param("is", $hostelId, $room_type);

        if ($stmt->execute() === false) {
            die("ERROR: Execution failed: " . $stmt->error);
        }

        $existingResult = $stmt->get_result();

        if ($existingResult === false) {
            die("ERROR: Failed to get result set. " . $stmt->error);
        }

        if ($existingResult->num_rows == 1) {
            // If the room already exists, update the details
            $updateQuery = "UPDATE room_types SET total_rooms = ?, available_rooms = ? WHERE hostel_id = ? AND room_type_name = ?";
            $stmt = $conn->prepare($updateQuery);

            if ($stmt === false) {
                die("ERROR: Failed to prepare statement. " . $conn->error);
            }

            $stmt->bind_param("iiis", $total_rooms, $available_rooms, $hostelId, $room_type);

            if ($stmt->execute() === false) {
                die("ERROR: Execution failed: " . $stmt->error);
            }

            // Update price details
            if ($price_per_day !== null || $price_per_month !== null) {
                // Get room type ID
                $getRoomTypeIdQuery = "SELECT room_type_id FROM room_types WHERE hostel_id = ? AND room_type_name = ?";
                $stmt = $conn->prepare($getRoomTypeIdQuery);

                if ($stmt === false) {
                    die("ERROR: Failed to prepare statement. " . $conn->error);
                }

                $stmt->bind_param("is", $hostelId, $room_type);

                if ($stmt->execute() === false) {
                    die("ERROR: Execution failed: " . $stmt->error);
                }

                $result = $stmt->get_result();

                if ($result === false) {
                    die("ERROR: Failed to get result set. " . $stmt->error);
                }

                $row = $result->fetch_assoc();
                $room_type_id = $row['room_type_id'];

                $updatePriceQuery = "UPDATE hostelprice_details SET price_per_day = ?, price_per_month = ? WHERE hostel_id = ? AND room_type_id = ?";
                $stmt = $conn->prepare($updatePriceQuery);

                if ($stmt === false) {
                    die("ERROR: Failed to prepare statement. " . $conn->error);
                }

                $stmt->bind_param("diis", $price_per_day, $price_per_month, $hostelId, $room_type_id);

                if ($stmt->execute() === false) {
                    die("ERROR: Execution failed: " . $stmt->error);
                }
            }

            echo '<script>alert("Room details updated successfully."); window.location.href = "owner_interface.php";</script>';
        } else {
            // If the room doesn't exist, insert a new entry
            $insertQuery = "INSERT INTO room_types (hostel_id, room_type_name, total_rooms, available_rooms) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);

            if ($stmt === false) {
                die("ERROR: Failed to prepare statement. " . $conn->error);
            }

            $stmt->bind_param("isii", $hostelId, $room_type, $total_rooms, $available_rooms);

            if ($stmt->execute() === false) {
                die("ERROR: Execution failed: " . $stmt->error);
            }

            // Insert price details if provided
            if ($price_per_day !== null || $price_per_month !== null) {
                // Get room type ID
                $getRoomTypeIdQuery = "SELECT room_type_id FROM room_types WHERE hostel_id = ? AND room_type_name = ?";
                $stmt = $conn->prepare($getRoomTypeIdQuery);

                if ($stmt === false) {
                    die("ERROR: Failed to prepare statement. " . $conn->error);
                }

                $stmt->bind_param("is", $hostelId, $room_type);

                if ($stmt->execute() === false) {
                    die("ERROR: Execution failed: " . $stmt->error);
                }

                $result = $stmt->get_result();

                if ($result === false) {
                    die("ERROR: Failed to get result set. " . $stmt->error);
                }

                $row = $result->fetch_assoc();
                $room_type_id = $row['room_type_id'];

                $insertPriceQuery = "INSERT INTO hostelprice_details (hostel_id, room_type_id, price_per_day, price_per_month) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertPriceQuery);

                if ($stmt === false) {
                    die("ERROR: Failed to prepare statement. " . $conn->error);
                }

                $stmt->bind_param("iidi", $hostelId, $room_type_id, $price_per_day, $price_per_month);

                if ($stmt->execute() === false) {
                    die("ERROR: Execution failed: " . $stmt->error);
                }
            }

            echo '<script>alert("Room details inserted successfully."); window.location.href = "owner_interface.php";</script>';
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
