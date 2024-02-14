<?php
include('conn.php'); // Include your database connection code

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (isset($data->username) && isset($data->newStatus)) {
        $username = $data->username;
        $newStatus = $data->newStatus;

        // Update the user's status in the database
        $updateStatusSql = "UPDATE users SET status = '$newStatus' WHERE name = '$username'";

        if ($conn->query($updateStatusSql) === TRUE) {
            // User status changed successfully
            echo json_encode(['success' => true]);
            exit();
        } else {
            // Error changing the user's status
            echo json_encode(['success' => false, 'error' => $conn->error]);
            exit();
        }
    } else {
        // Invalid request data
        echo json_encode(['success' => false, 'error' => 'Invalid request data']);
        exit();
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

// Close the database connection
$conn->close();
?>
