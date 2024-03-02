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
    $sql_user_id = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql_user_id);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result_user_id = $stmt->get_result();

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        $user_id = $row['user_id'];

        // Fetch booking details to check the start date
        $sql_booking_details = "SELECT hostel_id, booking_date FROM book WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($sql_booking_details);
        $stmt->bind_param("ii", $user_id, $booking_id);
        $stmt->execute();
        $result_booking_details = $stmt->get_result();

        if ($result_booking_details->num_rows > 0) {
            $booking_row = $result_booking_details->fetch_assoc();
            $hostel_id = $booking_row['hostel_id'];
            $booking_date = strtotime($booking_row['booking_date']);

            // Calculate the difference between the current date and the booked start date
            $current_date = strtotime(date('Y-m-d'));
            $date_difference = $booking_date - $current_date;

            // Check if the difference is greater than or equal to 5 days before the start date
            if ($date_difference >= (5 * 24 * 60 * 60)) { // 5 days in seconds
                // Proceed with cancellation
                $sql_cancel_booking = "DELETE FROM book WHERE book_id = ?";
                $stmt = $conn->prepare($sql_cancel_booking);
                $stmt->bind_param("i", $booking_id);
                if ($stmt->execute()) {
                    // Booking canceled successfully
                    header("Location: view_booking.php");
                    exit();
                } else {
                    // Handle error if cancellation fails
                    echo "Error canceling booking: " . $stmt->error;
                }
            } else {
                // Display error message indicating cancellation is not allowed
                echo '<script>alert("Cancellation is only allowed up to 5 days before the booked start date."); window.location.href = "view_booking.php";</script>';

            }
        } else {
            // Booking details not found or do not belong to the current user
            echo "Invalid booking ID.";
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

// Close prepared statements and database connection
$stmt->close();
$conn->close();
?>
