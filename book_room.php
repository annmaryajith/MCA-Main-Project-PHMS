<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>

    <link rel="shortcut icon" href="images/favicon.png" type="">
    <!-- bootstrap core css -->
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
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto; /* Center the container horizontally */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        select, input[type="date"], input[type="checkbox"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Adjust checkbox alignment */
        input[type="checkbox"] {
            display: inline-block;
            width: auto;
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
              <li class="nav-item">
                <a class="nav-link" href="logout.php"> <i class="fa fa-user" aria-hidden="true"></i> Logout</a>
              </li>
              </form>
            </ul>
          </div>
        </nav>
      </div>
      <div class="container">
        <h2>Book Room</h2>
        <form id="bookRoomForm" action="update_room.php" method="post" onsubmit="return validateForm()">
            <label for="booked_room_type">Select Room Type:</label>
            <select name="booked_room_type" id="booked_room_type" required>
                <option value="single">Single</option>
                <option value="double">Double</option>
                <option value="triple">Triple</option>
                <!-- Add options for other room types -->
            </select>

            <label for="check_in_date">Check-In Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" onchange="setCheckOutDate()" required>

            <label for="check_out_date">Check-Out Date:</label>
            <input type="date" id="check_out_date" name="check_out_date" required>
            <input type="hidden" id="hidden_check_out_date" name="check_out_date">

            <label for="advance_payment">
                <input type="checkbox" id="advance_payment" name="advance_payment" value="1">
                Advance Payment
            </label>

            <input type="hidden" name="hostel_id" value="<?php echo isset($_GET['hostel_id']) ? $_GET['hostel_id'] : ''; ?>">
            <input type="submit" value="Book Room">
        </form>
    </div>

    <script>
    function validateForm() {
        var currentDate = new Date(); // Get the current date

        var checkInDate = new Date(document.getElementById("check_in_date").value);
        var checkOutDate = new Date(document.getElementById("check_out_date").value);

        // Check if check-in date is before the current date
        if (checkInDate < currentDate) {
            alert("Check-in date cannot be before the current date");
            return false;
        }

        // Check if check-out date is before the check-in date
        if (checkOutDate < checkInDate) {
            alert("Check-out date cannot be before the check-in date");
            return false;
        }

        // Get the difference in days between check-in and check-out dates
        var timeDifference = checkOutDate.getTime() - checkInDate.getTime();
        var daysDifference = timeDifference / (1000 * 3600 * 24);

        // Check if the difference is more than a certain threshold (e.g., 30 days)
        if (daysDifference > 30) {
            alert("Maximum booking period is 30 days");
            return false;
        }

        var selectedRoomType = document.getElementById("booked_room_type").value;

        sessionStorage.setItem('selectedRoomType', selectedRoomType);
        document.getElementById("hidden_check_out_date").value = document.getElementById("check_out_date").value;

        return true;
    }
    function setCheckOutDate() {
    var checkInDate = new Date(document.getElementById("check_in_date").value);
    // Set the checkout date as the next day after one month from the check-in date
    var oneMonthLater = new Date(checkInDate.getFullYear(), checkInDate.getMonth() + 1, checkInDate.getDate() + 1);
    var formattedDate = oneMonthLater.toISOString().slice(0, 10);
    document.getElementById("check_out_date").value = formattedDate;
    document.getElementById("hidden_check_out_date").value = formattedDate;
    // Disable the checkout date input field after setting its value
    document.getElementById("check_out_date").disabled = true;
    }

</script>

</body>
</html>
