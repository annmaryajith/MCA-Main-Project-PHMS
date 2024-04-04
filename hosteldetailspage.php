<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Hostel Details</title>
    <style>
      body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap; /* Wrap boxes if container width is too small */
        }

        .box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            width: calc(50% - 20px); /* Adjust box width and margin */
            box-sizing: border-box;
        }

        h1, h2 {
            color: #333;
            margin-bottom: 10px;
            font-weight: 700; /* Make headings bold */
        }

        p {
            color: #666;
            margin-bottom: 15px;
            font-size: 16px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .booking-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px; /* Adjust button padding */
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s; /* Smooth hover transition */
            display: inline-block; /* Fix button width */
        }

        .booking-btn:hover {
            background-color: #0056b3;
        }

        .box h2 {
            border-bottom: 2px solid #007bff; /* Add underline to headings */
            padding-bottom: 10px; /* Add spacing between heading and content */
            margin-bottom: 20px; /* Add spacing between sections */
        }

        .owner-details p {
            margin-bottom: 8px; /* Reduce spacing between owner details */
        }

        .owner-details i {
            margin-right: 8px; /* Add spacing between icon and text */
        }

    </style>
</head>
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
<body>
    <?php
    // Include your connection file
    include('conn.php');

    // Check if hostel_id is provided in the URL
    if (isset($_GET['hostel_id'])) {
        // Retrieve hostel ID from the URL
        $hostel_id = $_GET['hostel_id'];

        // Prepare SQL query to fetch hostel details, room types, prices, and owner details
        $query = "SELECT h.hostel_name, h.description, h.address, h.hostel_location,
                         rt.room_type_name, hd.price_per_day, hd.price_per_month,
                         o.email AS owner_email, o.phno AS owner_phno
                  FROM hostels h
                  LEFT JOIN hostelprice_details hd ON h.hostel_id = hd.hostel_id
                  LEFT JOIN room_types rt ON hd.room_type_id = rt.room_type_id
                  LEFT JOIN hostel_owners1 o ON h.hostel_name = o.hostel_name
                  WHERE h.hostel_id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $hostel_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch hostel details
            $row = $result->fetch_assoc();
            $hostel_name = $row['hostel_name'];
            $description = $row['description'];
            $address = $row['address'];
            $hostel_location = $row['hostel_location'];
            $owner_email = $row['owner_email'];
            $owner_phno = $row['owner_phno'];

            // Display hostel details and owner details
            ?>
            <div class="container">
                <div class="box">
                    <h1><?php echo $hostel_name; ?></h1>
                    <h2>Description</h2>
                    <p><?php echo $description; ?></p>
                    <h2>Location</h2>
                    <p><?php echo $hostel_location; ?></p>
                    <h2>Address</h2>
                    <p><?php echo $address; ?></p>
                    <h2>Room Types and Prices</h2>
                    <ul>
                        <?php
                        // Display room types and prices
                        do {
                            $room_type_name = $row['room_type_name'];
                            $price_per_day = $row['price_per_day'];
                            $price_per_month = $row['price_per_month'];
                            ?>
                            <li>
                                <strong><?php echo $room_type_name; ?>:</strong><br>
                                Price Per Month: Rs. <?php echo $price_per_month; ?>
                            </li>
                            <?php
                        } while ($row = $result->fetch_assoc());
                        ?>
                    </ul>
                    <a href="book_room.php?hostel_id=<?php echo $hostel_id; ?>" class="booking-btn">Book Now</a>
                </div>
                <div class="box">
                    <h2>Owner Details</h2>
                    <p>Email: <?php echo $owner_email; ?></p>
                    <p>Phone Number: <?php echo $owner_phno; ?></p>
                </div>
            </div>
            <?php
        } else {
            // No hostel found with the given ID
            echo "<p>Hostel not found.</p>";
        }

        $stmt->close();
    } else {
        // Handle case when hostel_id is not provided in the URL
        echo "<p>Hostel ID is missing.</p>";
    }
    ?>
</body>
</html>
