<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <style>
        /* Your CSS styles here */
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

        select, input[type="date"], input[type="checkbox"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Adjust checkbox alignment */
        input[type="checkbox"] {
            display: inline-block;
            width: auto;
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
        <form action="update_room.php" method="post" onsubmit="return validateForm()">
            <label for="booked_room_type">Select Room Type:</label>
            <select name="booked_room_type" id="booked_room_type" required>
                <option value="single">Single</option>
                <option value="double">Double</option>
                <option value="triple">Triple</option>
                <!-- Add options for other room types -->
            </select>

            <label for="check_in_date">Check-In Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" required>

            <label for="check_out_date">Check-Out Date:</label>
            <input type="date" id="check_out_date" name="check_out_date" required>

            <!-- Adjust checkbox alignment -->
            <label for="advance_payment">
                <input type="checkbox" id="advance_payment" name="advance_payment" value="1">
                Advance Payment
            </label>

            <!-- Retrieve hostel ID from the URL -->
            <input type="hidden" name="hostel_id" value="<?php echo isset($_GET['hostel_id']) ? $_GET['hostel_id'] : ''; ?>">
            <input type="submit" value="Book Room">
        </form>
    </div>

    <script>
        function validateForm() {
            var checkInDate = document.getElementById("check_in_date").value;
            var checkOutDate = document.getElementById("check_out_date").value;

            if (checkOutDate < checkInDate) {
                alert("Check-out date cannot be before check-in date");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
