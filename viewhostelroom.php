<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
              body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
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
                <li><a href="owner_interface.php">Add Rooms</a></li>
                <li><a href="viewhostelroom.php">View Rooms</a></li>
                <!-- <li><a href="hostelroomupdate.php">Update room</a></li> -->
                <li><a href="add_hostel_details.php">Add Hostel details</a></li>
                <li><a href="hosteldetailsupdate.php">Update Hostel details</a></li>
                <li><a href="add_hostelowner_details.php">Add owner details</a></li>
                <li><a href="hostelownerupdate.php">Update profile</a></li>
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
    // Get the owner's username
    $owner_username = $_SESSION['username'];

    // Query to retrieve the hostel ID based on the owner's username
    $hostel_query = "SELECT h.hostel_id FROM hostels h
                     JOIN hostel_owners1 ho ON h.hostel_name = ho.hostel_name
                     WHERE ho.username = '$owner_username'";
    $hostel_result = $conn->query($hostel_query);

    if ($hostel_result->num_rows > 0) {
        // Fetch the hostel ID
        $hostel_row = $hostel_result->fetch_assoc();
        $hostel_id = $hostel_row['hostel_id'];

        // Query to retrieve room details and their corresponding price details
        $room_query = "SELECT rt.room_type_name, rt.total_rooms, rt.available_rooms, hd.price_per_day, hd.price_per_month
                       FROM room_types rt
                       LEFT JOIN hostelprice_details hd ON rt.room_type_id = hd.room_type_id AND hd.hostel_id = rt.hostel_id
                       WHERE rt.hostel_id = $hostel_id";
        $room_result = $conn->query($room_query);

        if ($room_result->num_rows > 0) {
            // Display the list of rooms and their prices
            echo '<h2>List of Hostel Rooms</h2>';
            echo '<table>';
            echo '<tr>';
            echo '<th>Room Type</th>';
            echo '<th>Total Rooms</th>';
            echo '<th>Available Rooms</th>';
            echo '<th>Price Per Day</th>';
            echo '<th>Price Per Month</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            while ($row = $room_result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['room_type_name'] . '</td>';
                echo '<td>' . $row['total_rooms'] . '</td>';
                echo '<td>' . $row['available_rooms'] . '</td>';
                echo '<td>' . ($row['price_per_day'] ?? 'N/A') . '</td>'; // Display 'N/A' if price is not available
                echo '<td>' . ($row['price_per_month'] ?? 'N/A') . '</td>'; // Display 'N/A' if price is not available
                echo '<td><a href="update_hostelroom.php?room_type_name=' . $row['room_type_name'] . '">Update</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No rooms available.';
        }
    } else {
        echo 'Hostel ID not found.';
    }
} else {
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
</html>