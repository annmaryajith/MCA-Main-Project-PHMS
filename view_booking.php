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

// Get username from session
$username = $_SESSION['username'];

// Fetch user ID based on the username
$sql_user_id = "SELECT user_id FROM users WHERE username = '$username'";
$result_user_id = mysqli_query($conn, $sql_user_id);

// Check if user exists
if (mysqli_num_rows($result_user_id) > 0) {
    $row = mysqli_fetch_assoc($result_user_id);
    $user_id = $row['user_id'];

    // Fetch bookings for the current user
    $sql_bookings = "SELECT book.book_id, hostels.hostel_name, book.booked_room_type, book.checkin_date, book.checkout_date, book.booking_date
                     FROM book
                     INNER JOIN hostels ON book.hostel_id = hostels.hostel_id
                     WHERE book.user_id = '$user_id'";
    $result_bookings = mysqli_query($conn, $sql_bookings);

    // Array to store booking details
    $bookings = [];

    // Check if bookings exist
    if ($result_bookings) {
        while ($row = mysqli_fetch_assoc($result_bookings)) {
            // Add booking details to the array
            $bookings[] = $row;
        }
    } else {
        // Handle case where there is an error in the SQL query execution
        die("Error in SQL query: " . mysqli_error($conn));
    }
} else {
    // Handle case where user ID is not found
    $bookings = []; // Empty array if user ID not found
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .cancel-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>View Bookings</h1>
    <?php if (!empty($bookings)) { ?>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Hostel Name</th>
                    <th>Booked Room Type</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Booking Date</th>
                    <th>Action</th> <!-- New column for cancellation button -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking) { ?>
                    <tr>
                        <td><?php echo $booking['book_id']; ?></td>
                        <td><?php echo $booking['hostel_name']; ?></td>
                        <td><?php echo $booking['booked_room_type']; ?></td>
                        <td><?php echo $booking['checkin_date']; ?></td> <!-- Display check-in date -->
                        <td><?php echo $booking['checkout_date']; ?></td> <!-- Display check-out date -->
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td>
                            <form action="cancel_booking.php" method="POST">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['book_id']; ?>">
                                <button type="submit" class="cancel-button">Cancel Booking</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>
</div>

</body>
</html>
