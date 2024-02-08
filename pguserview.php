<?php
include('conn.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch hostel data from the database
$sql = "SELECT * FROM pg INNER JOIN pg_room ON pg.pg_name = pg_room.pg_name";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pg</title>
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

        .search-container input[type="text"] {
            padding-right: 100px; /* Add left padding to move the input to the right */
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
              <li class="nav-item">
                <a class="nav-link" href="useredit.php">PROFILE</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php"> <i class="fa fa-user" aria-hidden="true"></i> Logout</a>
              </li>
              </form>
            </ul>
          </div>
        </nav>
      </div>

    <!-- Search form -->
    <form action="" method="GET">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Add a container to display search results -->
    <div id="searchResultsContainer">
        <ul id="searchResults"></ul>
    </div>

    <!-- PGs listing -->
    <div class="pg-container">
    <?php
    // Display hostels
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='pg'>";
        echo "<img src='images/" . $row['pg_image'] . "' alt='" . $row['pg_name'] . "'>";
        echo "<div class='pg-content'>";
        echo "<h2>" . $row['pg_name'] . "</h2>";
        echo "<p><strong>Location:</strong> " . $row['pg_location'] . "</p>";
        echo "<p><strong>Room Type:</strong> " . $row['room_type'] . "</p>";
        echo "<p><strong>Amount:</strong> Rs." . $row['price'] . "</p>";

        // Add a form with a hidden input for pg_id
        echo "<form method='get' action='booking.php'>";
        echo "<input type='hidden' name='pg_id' value='" . $row['pg_id'] . "'>";
        echo "<input type='submit' name='book_now' class='book-button' value='Book'>";
        echo "</form>";

        echo "</div>";
        echo "</div>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
    </div>
</body>
</html>
