<?php
session_start();
include('conn.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    echo "Username not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
       
       
    
        /* Style the sidebar */
   .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 76px;
            left: -250px;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            text-align: left;
            padding-top: 60px;
            color: #fff;
        }

        .sidebar a {
            padding: 8px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
            margin: 15px 0;
        }

        .sidebar a:hover {
            background-color: #00D2FC;
            color: #fff;
        }

        .openbtn {
            font-size: 30px;
            cursor: pointer;
            position: fixed;
            z-index: 1;
            top: 10px;
            left: 10px;
            color: #00d2fc;
        }

        .icon {
            margin-right: 10px;
            font-size: 20px;
        }

        /* Add a background color for the links */
        .sidebar a {
            background-color: #333;
        }

        /* On hover, the background color and text color change */
        .sidebar a:hover {
            background-color: #00D2FC;
            color: #fff;
        }
/*main */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
           

        }
        .dashboard-container {
            margin:-7px;
            
            padding-left: 388px;
        }

        .dashboard-box {
            max-width: 600px; /* Adjust the width as needed */
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 32px;
            color: #fff;
            text-align: center; /* Center the heading text */
        }
        a {
            text-decoration: none;
            color: #0074D9;
        }
        a.navbar-brand {
            color: black;  /* Set the text color to black */
            text-decoration: none;  /* Remove the underline */
            font-weight: bold;
            color: #fff;
            font-size: 24px;
            margin-left: 45px;
            padding: 0px;

        }
        img {
            width: 39px;
            height: 39px;
        }
    </style>
<body>

    <!-- <div class="openbtn" onclick="toggleSidebar()">&#9776;</div> -->

    <div id="container" class="dashboard-container">
    <div class="dashboard-box">
            <form id="paymentForm">
                <div class="mb-3">
                    <label for="amount" class="form-label">Payment Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount" required>
                </div>
                <!-- <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div> -->

                <?php
                // Get the client email from the URL
                $username = $_SESSION['username'];
                ?>

                <input type="hidden" id="username" value="<?php echo $username; ?>">

                <button type="button" class="btn btn-primary buynow">Pay Now</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    $(".buynow").click(function () {
        var amount = $("#amount").val();
        // var description = $("#description").val();
        var username = $("#username").val();

        var options = {
            key: 'rzp_test_GS4kcv9UkVl9bJ', // Replace with your actual Razorpay key
            amount: amount * 100,
            currency: 'INR',
            name: 'PHMS',
            handler: function (response) {
                var paymentid = response.razorpay_payment_id;

                $.ajax({
                    url: "payment-process.php?username=" + username, // Fix: Use "email" as the parameter
                    type: "POST",
                    data: { payment_id: paymentid, amount: amount},
                    success: function (finalresponse) {
                        if (finalresponse == 'done') {
                            window.location.href = "success.php";
                        } else {
                            alert('Please check console.log to find error');
                            console.log(finalresponse);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            },
            theme: {
                color: "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    });

    let sidebarOpen = false;

function toggleSidebar() {
    const sidebar = document.getElementById("mySidebar");
    if (sidebarOpen) {
        sidebar.style.left = "-250px";
    } else {
        sidebar.style.left = "0";
    }
    sidebarOpen = !sidebarOpen;
}

</script>

</body>

</html>
