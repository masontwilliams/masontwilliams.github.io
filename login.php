<?php
session_start();
include 'tournament_data.php'; // Include the tournament data

// Get the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the username exists and the password matches
if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['username'] = $username; // Store the username in the session
    header("Location: game.html"); // Redirect to the game page
    exit();
} else {
    echo "Invalid username or password"; // Display error message
}
?>