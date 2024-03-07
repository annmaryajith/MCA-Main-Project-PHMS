<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
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

    <!-- Search form -->
    <form action="" method="POST">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search.." name="search">
            <button class="btn btn-dark btn-sm" name="submit" >Search</button>
        </div>
    </form>

    <!-- Add a container to display search results -->
    <div id="searchResultsContainer">
        <ul id="searchResults"></ul>
    </div>
    </form>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostels</title>
    <!-- Add your CSS styles here -->
    <style>
        /* Your CSS styles for hostels can go here */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .hostel-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .hostel {
        width: calc(50% - 10px); /* Adjust the width of each container */
        margin-bottom: 20px; /* Adjust the gap between rows */
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .hostel img {
        width: 100%;
        height: auto;
        max-height: 200px; /* Adjust the maximum height of the image */
        object-fit: cover; /* Ensure the image covers the container */
    }

    .hostel-content {
        padding: 20px;
    }

    .hostel-content h2 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333;
        font-size: 18px;
    }

    .hostel-content p {
        margin-bottom: 10px;
        font-size: 14px;
    }

    .book-button {
        display: block;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
    }

    .book-button:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>
<div class="hostel-container">
    <?php
    include('conn.php');

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch hostel data from the database along with corresponding price details
    $sql = "SELECT h.*, rt.room_type_name, hd.price_per_day, hd.price_per_month 
            FROM hostels h
            LEFT JOIN hostelprice_details hd ON h.hostel_id = hd.hostel_id
            LEFT JOIN room_types rt ON hd.room_type_id = rt.room_type_id";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Initialize an array to store hostel details
        $hostels = array();

        // Fetch and store hostel details along with room types and prices
        while ($row = mysqli_fetch_assoc($result)) {
            $hostel_id = $row['hostel_id'];

            // If the hostel entry doesn't exist in the array, create a new entry
            if (!isset($hostels[$hostel_id])) {
                $hostels[$hostel_id] = array(
                    'hostel_name' => $row['hostel_name'],
                    'hostel_location' => $row['hostel_location'],
                    'description' => $row['description'],
                    'image' => $row['image'],
                    'room_types' => array(),
                );
            }

            // Check if the room type has both prices available and add it only once
            if ($row['room_type_name'] != null && $row['price_per_day'] > 0 && $row['price_per_month'] > 0) {
                $room_type_name = $row['room_type_name'];
                if (!isset($hostels[$hostel_id]['room_types'][$room_type_name])) {
                    $hostels[$hostel_id]['room_types'][$room_type_name] = array(
                        'price_per_day' => $row['price_per_day'],
                        'price_per_month' => $row['price_per_month']
                    );
                }
            }

            // Check if the room type has only price per day or per month and add it
            if ($row['room_type_name'] != null && ($row['price_per_day'] > 0 || $row['price_per_month'] > 0)) {
                $hostels[$hostel_id]['room_types'][$row['room_type_name']] = array(
                    'price_per_day' => $row['price_per_day'],
                    'price_per_month' => $row['price_per_month']
                );
            }
        }

        // Display hostels and their details
        foreach ($hostels as $hostel_id => $hostel) {
            echo "<div class='hostel'>";
            echo "<img src='images/" . $hostel['image'] . "' alt='" . $hostel['hostel_name'] . "'>";
            echo "<div class='hostel-content'>";
            echo "<h2>" . $hostel['hostel_name'] . "</h2>";
            echo "<p><strong>Location:</strong> " . $hostel['hostel_location'] . "</p>";
            echo "<p>" . $hostel['description'] . "</p>";
        
            // Display room types and their respective prices
            if (!empty($hostel['room_types'])) {
                echo "<p><strong>Available Room Types:</strong></p>";
                echo "<ul>";
                foreach ($hostel['room_types'] as $room_type_name => $room_type) {
                    if ($room_type['price_per_day'] > 0 || $room_type['price_per_month'] > 0) {
                        echo "<li>" . $room_type_name . " - ";
                        if ($room_type['price_per_day'] > 0) {
                            echo "Price Per Day: Rs. " . $room_type['price_per_day'];
                        }
                        if ($room_type['price_per_month'] > 0) {
                            if ($room_type['price_per_day'] > 0) {
                                echo ", ";
                            }
                            echo "Price Per Month: Rs. " . $room_type['price_per_month'];
                        }
                        echo "</li>";
                    }
                }
                echo "</ul>";
            } else {
                echo "<p>No available room types for this hostel.</p>";
            }
            echo "<a href='book_room.php?hostel_id=" . $hostel_id . "'><button class='book-button'>Book Now</button></a>";
            echo "</div>";
            echo "</div>";
        }
        
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>


</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Hostels and Room Types</title> -->
    <!-- Add your CSS styles here -->
    <!-- <style> -->
        <!-- /* Your CSS styles for hostels can go here */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .hostel {
            border: 1px solid #ccc;
            margin: 20px;
            padding: 10px;
            display: flex;
        }
        .hostel img {
            max-width: 200px;
            max-height: 150px;
        }
        .hostel-content {
            margin-left: 20px;
        }
        .book-button {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Added */
        }
    </style>
</head>
<body>

php
// Include your database connection file
include('conn.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch hostel data along with available room types from the database
$sql = "SELECT hostels.*, GROUP_CONCAT(rooms.room_type) AS available_room_types
        FROM hostels
        INNER JOIN hostel_owners1 ON hostels.hostel_name = hostel_owners1.hostel_name
        INNER JOIN rooms ON hostel_owners1.hostelowner_id = rooms.hostelowner_id
        WHERE rooms.available_rooms > 0
        GROUP BY hostels.hostel_name";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Display hostels with available room types
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='hostel'>";
    echo "<img src='images/" . $row['image'] . "' alt='" . $row['hostel_name'] . "'>";
    echo "<div class='hostel-content'>";
    echo "<h2>" . $row['hostel_name'] . "</h2>";
    echo "<p><strong>Location:</strong> " . $row['hostel_location'] . "</p>";
    echo "<p><strong>Available Room Types:</strong> " . $row['available_room_types'] . "</p>";
    // echo "<p><strong>Amount:</strong> Rs." . $row['price'] . "</p>";
    echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
    echo "<a href='userbook.php?hostel_id=" . $row['hostel_id'] . "' class='book-button'>Book Now</a>";
    echo "</div>";
    echo "</div>";
}

// Close the database connection
mysqli_close($conn);
php


</body>
</html> -->



