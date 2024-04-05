<?php
date_default_timezone_set('Asia/Kolkata');
include('conn.php');

// Get the user input
$txt = mysqli_real_escape_string($conn, $_POST['txt']);

// Check if the user query is asking for hostel suggestions near a specific location
if (strpos($txt, "suggest a hostel in") !== false) {
    // Extract the location from the user query
    $location = substr($txt, strpos($txt, "in") + 3);

    // Construct the SQL query to find hostels in the specified location
    $sql = "SELECT * FROM hostels WHERE hostel_location LIKE '%$location%'";

    // Query the database to find hostels in the specified location
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        // Format the bot response with details of hostels in the specified location
        $html = "Sure! Here are some hostels in $location that you can consider:<br><br>";
        while ($row = mysqli_fetch_assoc($res)) {
            $html .= "<b>Hostel Name:</b> " . $row['hostel_name'] . "<br>";
            $html .= "<b>Location:</b> " . $row['hostel_location'] . "<br>";
            $html .= "<b>Description:</b> " . $row['description'] . "<br><br>";
        }
    } else {
        // If no hostels are found in the specified location, provide an appropriate response
        $html = "Sorry, I couldn't find any hostels in $location.";
    }
} else {
    // If the user query does not match the specified pattern, retrieve response from the chatbot hints table
    $sql = "SELECT reply FROM chatbot_hints WHERE question LIKE '%$txt%'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $html = $row['reply'];
    } else {
        $html = "Sorry, I'm not sure how to respond to that.";
    }
}

// Save the user query and bot response in the database
$added_on = date('Y-m-d h:i:s');
mysqli_query($conn, "INSERT INTO message(message, added_on, type) VALUES ('$txt', '$added_on', 'user')");
$added_on = date('Y-m-d h:i:s');
mysqli_query($conn, "INSERT INTO message(message, added_on, type) VALUES ('$html', '$added_on', 'bot')");

echo $html;
?>
