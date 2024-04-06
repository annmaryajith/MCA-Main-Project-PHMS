<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Available Rooms</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex; /* Use flex display for the body */
        }

        .sidebar {
            width: 250px;
            height: 100vh; /* Set sidebar height to full viewport height */
            overflow-y: auto;
            background-color: #001f3f; /* Dark blue background color */
            color: #fff;
            padding-top: 20px; /* Add padding to the top */
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px; /* Adjust spacing */
        }

        .sidebar a {
            padding: 10px;
            display: block;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #003366; /* Slightly lighter shade of blue on hover */
        }

        .main-content {
            flex: 1; /* Fill remaining space */
            padding: 20px;
            background-color: #fff;
            display: flex;
            justify-content: center; /* Center the form horizontally */
            align-items: center; /* Center the form vertically */
        }

        /* Validation styles */
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px; /* Add margin to separate error messages */
        }

        .form-container {
            width: 70%;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Adjust form styles */
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        select, input[type="number"], input[type="submit"], input[type="checkbox"], .price-input {
            width: 100%; /* Set width to 100% for consistency */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #001f3f; /* Dark blue button color */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #003366; /* Darker shade of blue on hover */
        }

        .price-options {
            margin-bottom: 20px;
        }

        .price-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .price-option label {
            margin-right: 10px;
        }

        .price-input {
            /* pointer-events: none;  */
            background-color: #f2f2f2; /* Gray out the input field */
        }

        .price-checkbox:checked + .price-input {
            pointer-events: auto; /* Enable input field when checkbox is checked */
            background-color: #fff; /* Restore background color */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>PHMS | Hostel Owner</h2>
        <ul>
            <li><a href="hostelowner_dashboard.php">Home</a></li>
            <li><a href="owner_interface.php">Add Rooms</a></li>
            <li><a href="viewhostelroom.php">View Rooms</a></li>
            <li><a href="add_hostel_details.php">Add Hostel details</a></li>
            <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
            <li><a href="add_hostelowner_details.php">Add contact details</a></li>
            <li><a href="hostelownerupdate.php">Update profile</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-container">
            <h2 style="text-align: center;">Add Rooms</h2>
            <form action="insert_available_rooms.php" method="post" onsubmit="return validateForm()">
                <label for="room_type">Room Type:</label>
                <select name="room_type" id="room_type">
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <!-- Add options for other room types -->
                </select>

                <label for="total_rooms">Total Rooms:</label>
                <input type="number" id="total_rooms" name="total_rooms" required>
                <div id="totalRoomsError" class="error-message"></div>

                <label for="available_rooms">Available Rooms:</label>
                <input type="number" id="available_rooms" name="available_rooms" required>
                <div id="availableRoomsError" class="error-message"></div>

                <div class="price-options">
    <div class="price-option">
        <input type="checkbox" id="per_day" class="price-checkbox" name="price_option" value="per_day">
        <label for="per_day">Per Day Price:</label>
        <input type="number" id="price_per_day" class="price-input" name="price_per_day" placeholder="Enter per day price">
    </div>

    <div class="price-option">
        <input type="checkbox" id="per_month" class="price-checkbox" name="price_option" value="per_month">
        <label for="per_month">Per Month Price:</label>
        <input type="number" id="price_per_month" class="price-input" name="price_per_month" placeholder="Enter per month price" >
    </div>
</div>

                <input type="submit" value="Insert">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('per_day').addEventListener('change', function() {
        var pricePerDayInput = document.getElementById('price_per_day');
        pricePerDayInput.disabled = !this.checked;
        if (!this.checked) {
            pricePerDayInput.value = ''; // Clear input if checkbox is unchecked
        }
    });

    document.getElementById('per_month').addEventListener('change', function() {
        var pricePerMonthInput = document.getElementById('price_per_month');
        pricePerMonthInput.disabled = !this.checked;
        if (!this.checked) {
            pricePerMonthInput.value = ''; // Clear input if checkbox is unchecked
        }
    });
        function validateForm() {
            document.getElementById('totalRoomsError').innerHTML = '';
            document.getElementById('availableRoomsError').innerHTML = '';

            var totalRooms = parseInt(document.getElementById('total_rooms').value); // Parse as integer
            var availableRooms = parseInt(document.getElementById('available_rooms').value); // Parse as integer

            if (totalRooms <= 0) {
                document.getElementById('totalRoomsError').innerHTML = 'Total rooms must be greater than 0.';
                return false;
            }

            if (availableRooms < 0 || availableRooms > totalRooms) {
                document.getElementById('availableRoomsError').innerHTML = 'Available rooms must be between 0 and the total rooms.';
                return false;
            }

            var perDayChecked = document.getElementById('per_day').checked;
            var perMonthChecked = document.getElementById('per_month').checked;

            if (!perDayChecked && !perMonthChecked) {
                alert('Please select at least one price option.');
                return false;
            }

            // Validate price input if respective option is selected
            if (perDayChecked) {
                var perDayPrice = parseFloat(document.getElementById('price_per_day').value);
                if (isNaN(perDayPrice) || perDayPrice <= 0) {
                    alert('Please enter a valid per day price.');
                    return false;
                }
            }

            if (perMonthChecked) {
                var perMonthPrice = parseFloat(document.getElementById('price_per_month').value);
                if (isNaN(perMonthPrice) || perMonthPrice <= 0) {
                    alert('Please enter a valid per month price.');
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>


















<!-- php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Include your database connection file
include('conn.php');

// Initialize variables to store form data
$room_type = "";
$total_rooms = "";
$available_rooms = "";

// Fetch hostelowner_id based on the logged-in username
$owner_username = $_SESSION['username'];
$get_owner_id_query = "SELECT hostelowner_id FROM hostel_owners1 WHERE username = ?";
$stmt = $conn->prepare($get_owner_id_query);
$stmt->bind_param("s", $owner_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hostelowner_id = $row['hostelowner_id'];
} else {
    // Handle the case where hostelowner_id is not found
    exit("Hostel owner ID not found for the logged-in user.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $room_type = ucfirst($_POST['room_type']);
    $total_rooms = $_POST['total_rooms'];
    $available_rooms = $_POST['available_rooms'];

    // Insert room details into the database
    $insert_query = "INSERT INTO rooms (hostelowner_id, room_type, total_rooms, available_rooms) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isii", $hostelowner_id, $room_type, $total_rooms, $available_rooms);

    if ($stmt->execute()) {
        // Room added successfully
        $success_message = "Room details added successfully.";
    } else {
        // Error occurred
        $error_message = "Error adding room details: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Close database connection
$conn->close();
?> -->

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room Details</title>
</head>
<body>
    <h2>Add Room Details</h2>
    php if(isset($success_message)) { ?>
        <div><?php echo $success_message; ?></div>
    php } ?>
    php if(isset($error_message)) { ?>
        <div><?php echo $error_message; ?></div>
    php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="room_type">Room Type:</label>
        <select name="room_type" id="room_type">
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            // Add options for other room types 
        </select><br>

        <label for="total_rooms">Total Rooms:</label>
        <input type="number" id="total_rooms" name="total_rooms" required><br>

        <label for="available_rooms">Available Rooms:</label>
        <input type="number" id="available_rooms" name="available_rooms" required><br>

        <input type="submit" value="Add Room">
    </form>
</body>
</html> -->
