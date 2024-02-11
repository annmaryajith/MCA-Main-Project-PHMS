<?php
include('conn.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostel_name = $_POST["hostel_name"];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $image = $_POST["image"];

    // Insert data into the database
    if (empty($hostel_name) || empty($description) || empty($location) || empty($image)) {
        echo "Please fill out all the fields.";
    } else {
        $sql = "INSERT INTO hostels (hostel_name, description, hostel_location,image) VALUES ('$hostel_name', '$description', '$location', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Pg added successfully!");</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }

        .sidebar {
            height: 100vh;
            width: 300px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: black;
            padding-top: 20px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }

        ul li a:hover {
            background-color: black;
        }

        .content {
            margin-left: 350px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
            }
        }

        ul li a.active {
            background-color: #3949ab;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="userview.php">Users</a></li>
            <li>
                <a href="javascript:void(0);" onclick="toggleSubmenu('pgSubmenu')">Pg</a>
                <div id="pgSubmenu" class="sub-options" style="display: none;">
                    <ul>
                        <li><a href="viewpg.php">View Pg</a></li>
                        <li><a href="addpg.php">Add Pg</a></li>
                        <li><a href="viewpgowner.php">View Owner</a></li>
                        <li><a href="addpgowner.php">Add Owner</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="toggleSubmenu('hostelSubmenu')">Hostel</a>
                <div id="hostelSubmenu" class="sub-options" style="display: none;">
                    <ul>
                        <li><a href="viewhostel.php">View Hostel</a></li>
                        <li><a href="addhostel.php">Add Hostel</a></li>
                        <li><a href="viewowner.php">View Owner</a></li>
                        <li><a href="addowner.php">Add Owner</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>
</div>

<script>
    function toggleSubmenu(submenuId) {
        var submenu = document.getElementById(submenuId);
        if (submenu.style.display === "none" || submenu.style.display === "") {
            submenu.style.display = "block";
        } else {
            submenu.style.display = "none";
        }
    }
</script>
    <h1>Add Hostel</h1>
    <form method="post" action="" id="addHostelForm">
    <label for="hostel_name">Hostel Name:</label>
    <input type="text" id="hostel_name" name="hostel_name" required>
    <span id="hostelNameError" class="error"></span><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>
    <span id="descriptionError" class="error"></span><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required>
    <span id="locationError" class="error"></span><br>

    <label for="image">Upload Profile Image:</label>
    <input type="file" id="image" name="image" accept="image/*"><br><br>

    <input type="submit" value="Add Hostel">
</form>

<script>
    const addHostelForm = document.getElementById("addHostelForm");
    const hostelName = document.getElementById("hostel_name");
    const description = document.getElementById("description");
    const location = document.getElementById("location");
    const hostelNameError = document.getElementById("hostelNameError");
    const descriptionError = document.getElementById("descriptionError");
    const locationError = document.getElementById("locationError");

    hostelName.addEventListener("input", validateHostelName);
    description.addEventListener("input", validateDescription);
    location.addEventListener("input", validateLocation);

    function validateHostelName() {
        const hostelNameValue = hostelName.value.trim();
        if (hostelNameValue === "") {
            hostelNameError.textContent = "Hostel Name is required.";
        } else if (hostelNameValue.length < 5) {
            hostelNameError.textContent = "Hostel Name must be at least 5 characters.";
        } else {
            hostelNameError.textContent = "";
        }
    }

    function validateDescription() {
        const descriptionValue = description.value.trim();
        if (descriptionValue === "") {
            descriptionError.textContent = "Description is required.";
        } else {
            descriptionError.textContent = "";
        }
    }

    function validateLocation() {
        const locationValue = location.value.trim();
        if (locationValue === "") {
            locationError.textContent = "Location is required.";
        } else if (locationValue.length < 5) {
            locationError.textContent = "Location must be at least 5 characters.";
        } else {
            locationError.textContent = "";
        }
    }

    addHostelForm.addEventListener("submit", function (event) {
        validateHostelName();
        validateDescription();
        validateLocation();

        if (
            hostelNameError.textContent !== "" ||
            descriptionError.textContent !== "" ||
            locationError.textContent !== ""
        ) {
            event.preventDefault(); // Prevent form submission if there are validation errors.
        }
    });
</script>
</body>
</html>
