<?php
// Define intents and responses
$intents = array(
    "greeting" => "Hello! How can I assist you today?",
    "farewell" => "Goodbye! Have a great day.",
    "default" => "I'm sorry, I didn't understand that. Can you please rephrase?"
);

// Get user input
$user_input = isset($_POST['message']) ? $_POST['message'] : "";

// Detect intent
$intent = detect_intent($user_input);

// Generate response
$response = generate_response($intent);

// Return response
echo $response;

// Function to detect intent based on user input
function detect_intent($user_input) {
    if (stripos($user_input, 'hello') !== false || stripos($user_input, 'hi') !== false) {
        return "greeting";
    } elseif (stripos($user_input, 'bye') !== false || stripos($user_input, 'goodbye') !== false) {
        return "farewell";
    } else {
        return "default";
    }
}

// Function to generate response based on detected intent
function generate_response($intent) {
    global $intents;
    return isset($intents[$intent]) ? $intents[$intent] : $intents['default'];
}
?>
