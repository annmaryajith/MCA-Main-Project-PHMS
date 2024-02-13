<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.containerr {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        /* .logout {
            float: right;
        } */

        table {
    width: 100%; /* Adjust the width percentage as needed */
    border-collapse: collapse;
    margin-top: 20px;
    height: 200px; /* Adjust the height as needed */
    overflow-y: auto;
}

th, td {
    border: 1px solid #ddd;
    padding: 15px; /* Increase padding for better spacing */
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

        </style>
    </head>
    <body>
    <div class="container">
        <div class="sidebar">
            <h2>   PHMS | Hostel Owner</h2>
            <ul>
                <li><a href="hostelowner_dashboard.php">Home</a></li>
                <li><a href="addhostelroom.php">Add Rooms</a></li>
                <li><a href="viewhostelroom.php">View Rooms</a></li>
                <!-- <li><a href="hostelroomupdate.php">Update room</a></li> -->
                <li><a href="hostelownerupdate.php">Update</a></li>
                <!-- <li><a href="manage_tenants.php">Manage Tenants</a></li>
                <li><a href="reports.php">Reports</a></li> -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>
    </head>
    <body>
    <div class="containerr">
    <!-- <h2>Rooms</h2> -->
<?php
// Include necessary files and start session
session_start();
include('conn.php');

// Check if the owner is logged in
if (isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    
    $owner_username = $_SESSION['username'];

    // Get the owner's ID from the owners table based on the username
    $owner_query = "SELECT hostelowner_id FROM hostel_owners1 WHERE username = '$owner_username'";
    $owner_result = $conn->query($owner_query);

    if ($owner_result->num_rows > 0) {
        $owner_row = $owner_result->fetch_assoc();
        $owner_id = $owner_row['hostelowner_id'];

        // Retrieve rooms associated with the owner
        $room_query = "SELECT status,room_number, room_type, price FROM hostel_rooms WHERE hostelowner_id = $owner_id";
        $room_result = $conn->query($room_query);
// Display the list of rooms
echo '<h2>List of Hostel Rooms</h2>';

if ($room_result->num_rows > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Room Number</th>';
    echo '<th>Room Type</th>';
    echo '<th>Price</th>';
    echo '<th>Status</th>';
    echo '<th>Action</th>';
    echo '</tr>';

    while ($row = $room_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['room_number'] . '</td>';
        echo '<td>' . $row['room_type'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>';
        if ($row['status'] == 1) {
            echo '<button onclick="changeStatus(\'' . $row['room_number'] . '\', 0);">Deactivate</button>';
        } else {
            echo '<button onclick="changeStatus(\'' . $row['room_number'] . '\', 1);">Activate</button>';
        }        
        echo '</td>';
        echo '<td><a href="update_hostelroom.php?room_number=' . $row['room_number'] . '">Update</a></td>';
        echo '</tr>';
    }

    echo '</table>';
}
}} else {
    echo 'No rooms available.';
}
?>
    <script>
     function changeStatus(roomNumber, currentStatus) {
        var newStatus = currentStatus === 1 ? 0 : 1; // Toggle status
        if (confirm(`Are you sure you want to ${newStatus === 1 ? 'activate' : 'deactivate'} this room?`)) {
            fetch('change_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ roomNumber: roomNumber, newStatus: newStatus }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(`Error: ${data.error}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>

</body>
</html