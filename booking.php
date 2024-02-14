<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Include your database connection file
include('conn.php');

// Initialize a variable to store the alert message
$alert_message = "";

// Retrieve user details from the session
$username = $_SESSION['username'];

// Retrieve booking details from the form
if (isset($_GET['pg_id'])) {
    $pg_id = mysqli_real_escape_string($conn, $_GET['pg_id']);

    // Check if the PG is available
    $pg_status_query = "SELECT status FROM pg WHERE pg_id = '$pg_id' AND status = 'available'";

    $pg_status_result = $conn->query($pg_status_query);

    if ($pg_status_result->num_rows == 1) {
        // The PG is available, proceed with the booking

        // Get user_id using the username
        $user_query = "SELECT user_id FROM users WHERE username = '$username'";
        $user_result = $conn->query($user_query);

        if ($user_result->num_rows == 1) {
            $user_data = $user_result->fetch_assoc();
            $user_id = $user_data['user_id'];

            // Insert the booking into the database
            $insert_query = "INSERT INTO bookings (user_id, pg_id, booking_date, status) 
                             VALUES ('$user_id', '$pg_id', NOW(), 'booked')";

            if ($conn->query($insert_query) === TRUE) {
                // Set the alert message
                $alert_message = "Booking successful!";
            } else {
                // Set the alert message with an error
                $alert_message = "Error: " . $insert_query . "<br>" . $conn->error;
            }
        }
    } else {
        // The PG is not available, set an error message
        $alert_message = "Error: The selected PG is not available for booking.";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PG Booking</title>
</head>
<body>
    <h2>PG Booking Form</h2>
    <form action="payment.php" method="get" >  
        

        <input type="hidden" name="pg_id" value="<?php echo $row['pg_id']; ?>">

        <label for="check_in">Booking Date:</label>
        <input type="date" id="check_in" name="check_in" value="<?php echo date('Y-m-d'); ?>" required>
        
        <input type="submit" value="Pay Now">
    </form>
</body>
</html>
