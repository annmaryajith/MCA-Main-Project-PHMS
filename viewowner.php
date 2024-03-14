<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add your CSS styles here -->
    <style>
        body {
            margin: 0;
            font-family: Verdana, sans-serif;
        }

        .sidebar {
    height: 100vh;
    width: 300px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: black; /* Change to black background color */
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

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
            font-family: Arial, sans-serif;
        }

        .container {
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        </style>
    </head>
    <body>
    <div class="container">
    <h2>Hostel Owners</h2>
        <table>
            <tr>
                <th>Hostel name</th>
                <th>Username</th>
                <!-- <th>Password</th> -->
            </tr>
            <?php
            // Include database connection code
            include('conn.php');

            if (isset($_GET['success'])) {
                echo "<div style='color:green;'>" . $_GET['success'] . "</div>";
            } elseif (isset($_GET['error'])) {
                echo "<div style='color:red;'>" . $_GET['error'] . "</div>";
            }

            // SQL query to fetch all users
            $sql = "SELECT hostel_name,username FROM hostel_owners1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["hostel_name"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    // echo "<td>" . $row["password"] . "</td>";
                    // echo "<td>
                    //      <a href='deleteuser.php?id=" . $row["name"] . "'>Delete</a>
                    //      </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            

            $conn->close();
            ?>
    </table>    
    </div>  
    </body>
</html>

