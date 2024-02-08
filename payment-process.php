<?php
include('conn.php'); 
session_start();
date_default_timezone_set("Asia/Calcutta");

$payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
//$description = isset($_POST['description']) ? $_POST['description'] : '';

// Fetch client email from the URL
$userid = $_SESSION['username'];

// Fetch client_id based on the email
$clientQuery = "SELECT user_id FROM users WHERE username = '$userid'";
$clientResult = mysqli_query($conn, $clientQuery);
// echo $clientQuery;

if ($clientResult && mysqli_num_rows($clientResult) > 0) {
    $clientRow = mysqli_fetch_assoc($clientResult);
    $clientid = $clientRow['user_id'];

    // Insert data into the payment table
    $sql = "INSERT INTO payment (user_id, amount, payment_id) 
            VALUES ('$clientid', '$amount', '$payment_id')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'done';
        $_SESSION['payment_id'] = $payment_id;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error fetching user information.";
}
?>
