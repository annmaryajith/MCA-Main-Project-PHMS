


// session_start();

// Unset or destroy the session variables
// session_unset(); // Unset all session variables
// session_destroy(); // Destroy the session

// Redirect to a page after logout (e.g., login page)
// header('Location: login.php'); // Change 'login.php' to your login page URL
// exit();


<!-- <script type="text/javascript">
    // Disable the back button to prevent going back after logout
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>  -->

<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect to the login page or any other page after logout
header('Location: login.php');
exit();
?>
