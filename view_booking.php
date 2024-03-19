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
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
<!-- fonts style -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

<!--owl slider stylesheet -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

<!-- font awesome style -->
<link href="css/font-awesome.min.css" rel="stylesheet" />

<!-- Custom styles for this template -->
<link href="css/styleuser.css" rel="stylesheet" />
<!-- responsive style -->
<link href="css/responsive.css" rel="stylesheet" />
<style>
    .pg-container {
      display: flex;
      flex-direction: column; /* Stack items vertically */
      align-items: center; 
      justify-content: center;
      align-items: center;
     }
      .pg {
          border: 1px solid #ccc;
          margin: 50px;
          padding: 10px;
          display: flex;
          max-width: 600px; 
          align-items: center; /* Center items horizontally */
          width: 100%; /* Take up 100% width */
      }

      .pg img {
          max-width: 200px;
          max-height: 150px;
          margin-right: 20px; 
      }

      .pg-content {
        flex-grow: 1; 
      }

      .book-button {
          background-color: #000000;
          color: white;
          padding: 5px 10px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
      }

      .search-container {
          display: flex;
          align-items: center;
          padding: 20px;
          background-color: #fff;
          margin-left: 10px; /* Adjust the margin as needed */
      }

      .search-container input[type="text"] {
          width: 400px; /* Adjust the width of the text box */
          margin-right: 10px; /* Add space between the text box and the button */
      }
  </style>
</head>
<body>
<header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="">
          <span>
            PHMS
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <!-- <li class="nav-item active">
              <a class="nav-link" href="userhome.php">Home <span class="sr-only">(current)</span></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="pguserview.php"> PG</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user.php">HOSTEL</a>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Profile & Booking
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="useredit.php">Edit Profile</a>
                  <a class="dropdown-item" href="view_booking.php">View Booking</a>
              </div>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" href="useredit.php">PROFILE</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="logout.php"> <i class="fa fa-user" aria-hidden="true"></i> Logout</a>
            </li>
            </form>
          </ul>
        </div>
      </nav>
    </div>
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
                    <th>Serial no</th>
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
                        <td><?php echo $index + 1; ?></td> <!-- Display serial number -->
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
