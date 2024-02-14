<?php
// change_status.php

// Validate request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Invalid request method."));
    exit;
}

// Check if required parameters are present
if (!isset($_POST['roomNumber']) || !isset($_POST['newStatus'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => "Missing required parameters."));
    exit;
}

// Get the room number and new status
$roomNumber = $_POST['roomNumber'];
$newStatus = $_POST['newStatus'];

// Perform necessary actions (e.g., update room status in the database)
// Replace this with your logic to update the status in the database

// Example response indicating success
http_response_code(200); // OK
echo json_encode(array("success" => true));
?>
