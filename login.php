<?php
session_start();

// Load user credentials from a JSON file
function loadCredentials() {
    $file = 'participants.json';
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

$users = loadCredentials();
$username = $_POST['username'];
$password = $_POST['password'];

// Check credentials and set session
if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $users[$username]['role'];  // 'admin' or 'participant'
    // Redirect based on role
    header("Location: " . ($users[$username]['role'] === 'admin' ? 'admin.html' : 'game.html'));
    exit();
} else {
    header("Location: index.html?error=Invalid%20Credentials");
    exit();
}
?>
