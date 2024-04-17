<?php
include('conn.php');
session_start();

if (!isset($_SESSION['book_id'])) {
    echo "Book ID not found in session.";
    exit();
}

$payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$book_id = $_SESSION['book_id'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$status=1;

$clientQuery = "SELECT user_id FROM users WHERE username = ?";
$stmt = $conn->prepare($clientQuery);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$clientResult = $stmt->get_result();

if ($clientResult && $clientResult->num_rows > 0) {
    $clientRow = $clientResult->fetch_assoc();
    $clientid = $clientRow['user_id'];

    $sql = "INSERT INTO payment (book_id, user_id, amount, payment_id, status) 
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidss", $book_id, $clientid, $amount, $payment_id, $status);

    if ($stmt->execute()) {
        echo 'done';
        $_SESSION['payment_id'] = $payment_id;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error fetching user information.";
}

$stmt->close();
$conn->close();
?>
