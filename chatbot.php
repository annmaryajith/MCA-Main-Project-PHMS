<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        #chat-container {
            width: 350px;
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .message-container {
            overflow: hidden;
            margin-bottom: 10px;
        }
        .message-container.user .message {
            background-color: #4CAF50;
            color: white;
            float: right;
            border-radius: 20px 20px 0 20px;
        }
        .message-container.bot .message {
            background-color: #f0f0f0;
            color: black;
            float: left;
            border-radius: 20px 20px 20px 0;
        }
        .message {
            max-width: 70%;
            padding: 15px;
            border-radius: 20px;
            margin: 5px;
        }
        .timestamp {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
            text-align: right;
        }
        #input-container {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 0 0 10px 10px;
        }
        #message {
            flex: 1;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
            font-size: 16px;
            outline: none;
        }
        #sendBtn {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        #sendBtn:hover {
            background-color: #45a049;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div id="chat-container">
    <!-- Chat messages will be displayed here -->

    <div id="input-container">
        <input type="text" id="message" placeholder="Type a message..." autocomplete="off">
        <button id="sendBtn" onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
// Function to send user message to backend and display response
function sendMessage() {
    var message = document.getElementById("message").value;
    var chatbox = document.getElementById("chat-container");
    
    // Display user message with timestamp
    var userMessage = "<div class='message-container user'><div class='avatar'></div><div class='message'>" + message + "</div></div>";
    var userTimestamp = "<div class='timestamp'>" + getCurrentTime() + "</div>";
    chatbox.innerHTML += userMessage + userTimestamp;
    
    chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom of chatbox
    document.getElementById("message").value = ""; // Clear input field
    
    // Send user message to backend
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            // Display bot response with timestamp
            var botMessage = "<div class='message-container bot'><div class='avatar'><img src='images/icon.png' alt='Bot Avatar'></div><div class='message'>" + response + "</div></div>";
            var botTimestamp = "<div class='timestamp'>" + getCurrentTime() + "</div>";
            chatbox.innerHTML += botMessage + botTimestamp;
            chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom of chatbox
        }
    };
    xhttp.open("POST", "backend.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("message=" + message);
}

// Function to get current time in HH:MM format
function getCurrentTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    return hours + ":" + minutes;
}
</script>

</body>
</html>
