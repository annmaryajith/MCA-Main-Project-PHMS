<?php
// Include your connection file
include('conn.php');

// Check if hostel_id is provided in the URL
if (isset($_GET['hostel_id'])) {
    // Retrieve hostel ID from the URL
    $hostel_id = $_GET['hostel_id'];

    // Prepare SQL query to fetch hostel details, room types, and prices
    $query = "SELECT h.hostel_name, h.description, h.address, h.hostel_location,
                     rt.room_type_name, hd.price_per_day, hd.price_per_month
              FROM hostels h
              LEFT JOIN hostelprice_details hd ON h.hostel_id = hd.hostel_id
              LEFT JOIN room_types rt ON hd.room_type_id = rt.room_type_id
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

        // Start HTML layout
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $hostel_name; ?></title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 800px;
                    margin: 20px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1, h2 {
                    color: #333;
                    margin-bottom: 10px;
                }
                p {
                    color: #666;
                    margin-bottom: 15px;
                }
                ul {
                    list-style-type: none;
                    padding: 0;
                }
                ul li {
                    margin-bottom: 10px;
                }
                .room-type {
                    border-bottom: 1px solid #ccc;
                    padding-bottom: 10px;
                }
                .room-type:last-child {
                    border-bottom: none;
                }
                .booking-btn {
                    background-color: #007bff;
                    color: white;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin-top: 20px;
                    cursor: pointer;
                }
                .booking-btn:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
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
                        <li class="room-type">
                            <strong><?php echo $room_type_name; ?>:</strong><br>
                            <!-- Price Per Day: Rs. <?php echo $price_per_day; ?><br> -->
                            Price Per Month: Rs. <?php echo $price_per_month; ?>
                        </li>
                        <?php
                    } while ($row = $result->fetch_assoc());
                    ?>
                </ul>
                <a href="book_room.php?hostel_id=<?php echo $hostel_id; ?>" class="booking-btn">Book Now</a>
            </div>
        </body>
        </html>
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
