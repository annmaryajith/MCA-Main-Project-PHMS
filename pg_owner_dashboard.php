<!DOCTYPE html>
<html>
<head>
    <title>PG Owner Dashboard</title>
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
    background-color: #333;
    color: #fff;
}

.sidebar a {
    padding: 10px;
    display: block;
    color: #fff;
    text-decoration: none;
}

.sidebar a:hover {
    background-color: #555;
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
            <h2>   PHMS | Owner</h2>
            <ul>
                <li><a href="pg_owner_dashboard.php">Home</a></li>
                <li><a href="addpgroom.php">Add Rooms</a></li>
                <li><a href="viewpgroom.php">View room</a></li>
                <li><a href="pgownerupdate.php">Update profile</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Welcome, PG Owner!</h1>
        </div>
    </div>
</body>
</html>
