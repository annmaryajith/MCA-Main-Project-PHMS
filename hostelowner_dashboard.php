<!DOCTYPE html>
<html>
<head>
    <title>Hostel Owner Dashboard</title>
    <!-- <link rel="stylesheet" type="text/css" href="styles.css"> -->
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.container {
    display: flex;
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
    margin-left: 250px;
    padding: 20px;
    background-color: #fff;
}

        </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>PHMS | Hostel Owner</h2>
            <ul>
                <li><a href="hostelowner_dashboard.php">Home</a></li>
                <li><a href="owner_interface.php">Add Rooms</a></li>
                <li><a href="viewhostelroom.php">View Rooms</a></li>
                <!-- <li><a href="hostelroomupdate.php">Update room</a></li> -->
                <li><a href="add_hostel_details.php">Add Hostel details</a></li>
                <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
                <li><a href="add_hostelowner_details.php">Add contact details</a></li>
                <li><a href="hostelownerupdate.php">Update profile</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Welcome, Hostel Owner!</h1>
        </div>
    </div>
</body>
</html>
