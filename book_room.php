<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 400px;
            margin: 50px auto; /* Center the container horizontally */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        select, input[type="number"], input[type="submit"] {
            width: calc(100% - 22px); /* Adjust for the border width */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Room</h2>
        <form action="update_room.php" method="post">
            <label for="booked_room_type">Select Room Type:</label>
            <select name="booked_room_type" id="booked_room_type">
                <option value="single">Single</option>
                <option value="double">Double</option>
                <option value="triple">Triple</option>
                <!-- Add options for other room types -->
            </select>

            <label for="advance_payment">
                <input type="checkbox" id="advance_payment" name="advance_payment" value="1">
                Advance Payment
            </label>

            <!-- <label for="advance_amount">Advance Amount:</label>
            <input type="number" id="advance_amount" name="advance_amount" min="0" step="0.01" placeholder="Enter advance amount"> -->

            <!-- Retrieve hostel ID from the URL -->
            <input type="hidden" name="hostel_id" value="<?php echo isset($_GET['hostel_id']) ? $_GET['hostel_id'] : ''; ?>">
            <input type="submit" value="Book Room">
        </form>
    </div>
</body>
</html>
