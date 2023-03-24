<?php
// Connect to database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "chatbot";

$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve user message
$message = $_POST["message"];

// Insert message into database
$sql = "INSERT INTO messages (message, sender) VALUES ('$message', 'user')";
$conn->query($sql);

// Generate chatbot response
$response = "I'm sorry, I don't understand. Please try again.";

// Insert chatbot response into database
$sql = "INSERT INTO messages (message, sender) VALUES ('$response', 'chatbot')";
$conn->query($sql);

// Return success message
echo "success";

// Close database connection
$conn->close();
?>
