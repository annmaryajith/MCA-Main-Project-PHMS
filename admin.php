<!DOCTYPE html>
<html lang="en">

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

        .sub-options {
        margin-left: 10px; /* Adjust the margin to move it to the right */
        padding: 10px; /* Add padding for spacing */
        }

        .sidebar {
        width: 250px; /* Set the width of the sidebar */
        height: 100%; /* Set the fixed height for the sidebar */
        overflow-y: auto; /* Enable vertical scrolling if content overflows */
        position: fixed; /* Fixed position to keep the sidebar in view */
        background-color: #000; /* Change the background color to black */
        color: #fff;
    }
         
    </style>
</head>

<body>
<div class="container">
    <div class="sidebar">
        <h2>PHMS | Admin </h2>
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

        <div class="content">
            <h2>Welcome, Admin!</h2>
        </div>
        <!-- <a href="logout.php" class="logout">Logout</a>    -->
        </table>
    <!-- </div> -->
</body>
</html>
