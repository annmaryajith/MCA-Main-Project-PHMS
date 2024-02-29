<?php
// Start session to access user data
session_start();

// Check if username is set in session
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Include database connection
include('conn.php');

// Check if booking ID is set in the POST request
if (isset($_POST['booking_id'])) {
    // Sanitize the input to prevent SQL injection
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);

    // Get username from session
    $username = $_SESSION['username'];

    // Fetch user ID based on the username
    $sql_user_id = "SELECT user_id FROM users WHERE username = '$username'";
    $result_user_id = mysqli_query($conn, $sql_user_id);

    // Check if user exists
    if (mysqli_num_rows($result_user_id) > 0) {
        $row = mysqli_fetch_assoc($result_user_id);
        $user_id = $row['user_id'];

        // Check if the booking belongs to the current user
        $sql_check_booking = "SELECT * FROM book WHERE user_id = '$user_id' AND book_id = '$booking_id'";
        $result_check_booking = mysqli_query($conn, $sql_check_booking);

        if (mysqli_num_rows($result_check_booking) > 0) {
            // Booking belongs to the current user, proceed with cancellation
            $sql_cancel_booking = "DELETE FROM book WHERE book_id = '$booking_id'";
            if (mysqli_query($conn, $sql_cancel_booking)) {
                // Booking canceled successfully
                header("Location: view_booking.php");
                exit();
            } else {
                // Handle error if cancellation fails
                echo "Error canceling booking: " . mysqli_error($conn);
            }
        } else {
            // Booking does not belong to the current user
            echo "Unauthorized access to booking.";
        }
    } else {
        // Handle case where user ID is not found
        echo "User not found.";
    }
} else {
    // Redirect to view bookings page if booking ID is not set
    header("Location: view_booking.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>
