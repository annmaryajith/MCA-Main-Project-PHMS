<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
</head>
<body>
    <h2>Book Room</h2>
    <form action="update_room.php" method="post">
        <label for="booked_room_type">Room Type:</label>
        <select name="booked_room_type" id="booked_room_type">
            <option value="single">Single</option>
            <option value="double">Double</option>
            <option value="triple">Triple</option>
             <!-- Add options for other room types -->
        </select><br>

        <!-- <label for="user_id">User ID:</label> -->
        <!-- <input type="text" id="user_id" name="user_id" required><br> -->

        <input type="submit" value="Book Room">
    </form>
</body>
</html>
