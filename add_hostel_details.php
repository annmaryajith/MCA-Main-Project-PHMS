<?php
session_start();
include('conn.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$owner_username = $_SESSION['username'];
$owner_query = "SELECT hostelowner_id, hostel_name FROM hostel_owners1 WHERE username = ?";
$stmt_owner = $conn->prepare($owner_query);

if (!$stmt_owner) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt_owner->bind_param("s", $owner_username);
$stmt_owner->execute();
$owner_result = $stmt_owner->get_result();

if ($owner_result->num_rows > 0) {
    $owner_row = $owner_result->fetch_assoc();
    $owner_id = $owner_row['hostelowner_id'];
    $hostel_name = $owner_row['hostel_name'];
} else {
    echo "Owner not found.";
    exit();
}

$stmt_owner->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $hostel_location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $facilities = mysqli_real_escape_string($conn, $_POST['facilities'] ?? '');
    
    // Handle file upload
    $image_path = ''; // Initialize variable to store image path

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $temp_name = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $destination = 'images/' . $file_name; // Destination directory

        if (move_uploaded_file($temp_name, $destination)) {
            $image_path = $destination; // Store the file path
        } else {
            echo "Failed to move uploaded file.";
            exit();
        }
    } else {
        echo "Error uploading file.";
        exit();
    }

    // No need to insert hostel name, as it's already fetched from the session

    $insert_hostel_query = "INSERT INTO hostels (hostel_name, description, hostel_location, address, image) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_hostel = $conn->prepare($insert_hostel_query);

    if (!$stmt_insert_hostel) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt_insert_hostel->bind_param("sssss", $hostel_name, $description, $hostel_location, $address, $image_path);

    if ($stmt_insert_hostel->execute()) {
        $hostel_id = $stmt_insert_hostel->insert_id;

        $facility_list = explode(",", $facilities);

        foreach ($facility_list as $facility) {
            $facility_query = "SELECT facility_id FROM hostel_facilities WHERE name = ?";
            $stmt_facility = $conn->prepare($facility_query);
            $stmt_facility->bind_param("s", $facility);
            $stmt_facility->execute();
            $facility_result = $stmt_facility->get_result();

            if ($facility_result->num_rows > 0) {
                $facility_row = $facility_result->fetch_assoc();
                $facility_id = $facility_row['facility_id'];
            } else {
                $insert_facility_query = "INSERT INTO hostel_facilities (name) VALUES (?)";
                $stmt_insert_facility = $conn->prepare($insert_facility_query);
                $stmt_insert_facility->bind_param("s", $facility);
                $stmt_insert_facility->execute();

                $facility_id = $stmt_insert_facility->insert_id;
            }

            $insert_bridge_query = "INSERT INTO hostel_facilities_relationship (hostel_id, facility_id) VALUES (?, ?)";
            $stmt_insert_bridge = $conn->prepare($insert_bridge_query);
            $stmt_insert_bridge->bind_param("ii", $hostel_id, $facility_id);
            $stmt_insert_bridge->execute();
        }

        echo "<script>alert('Hostel details added successfully.');</script>";
    } else {
        echo "Error inserting hostel details: " . $stmt_insert_hostel->error;
    }

    $stmt_insert_hostel->close();
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hostel Details</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            height: 100%;
            overflow-y: auto;
            position: fixed;
            background-color: #001f3f; /* Dark blue background color */
            color: #fff;
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
            flex: 1;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #001f3f; /* Dark blue background matching sidebar */
            color: #fff; /* White text */
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #003366; /* Slightly lighter shade of blue on hover */
        }

    </style>
</head>
<body>
<div class="sidebar">
        <h2>Hostel Owner Dashboard</h2>
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
    </div>
    <div class="main-content">
        <h1><center>Add Hostel Details</center></h1>
        <div class="form-container">
            <!-- Owner form to add additional details -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="addHostelDetailsForm" enctype="multipart/form-data">
                <label for="hostel_name">Hostel Name:</label>
                <input type="text" id="hostel_name" name="hostel_name" value="<?php echo htmlspecialchars($hostel_name); ?>" readonly>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="image">Upload Profile Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <label for="facilities">Facilities:</label>
                <input type="text" id="facilities" name="facilities" placeholder="Facility 1, Facility 2, ..." required>

                <input type="submit" value="Add Hostel">
            </form>
        </div>
    </div>
</body>
</html>
