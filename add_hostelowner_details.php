<?php
// Start the session to access session variables
session_start();

// Include the connection file
include('conn.php');

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    // Fetch the username from the session
    $username = $_SESSION['username'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize the input data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phno = filter_var($_POST['phno'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare and execute the SQL query to update owner details only for the logged-in user
        $query = "UPDATE hostel_owners1 SET email = ?, phno = ? WHERE username = ? AND username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $email, $phno, $username, $username);
        
        // Check if the query execution is successful
        if ($stmt->execute()) {
            echo "<script>alert('Owner details added successfully.');</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    }
} else {
    // Redirect to the login page if the username is not set in the session
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Owner Details</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>Add Owner Details</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phno">Phone Number:</label>
        <input type="tel" id="phno" name="phno" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
