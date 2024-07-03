<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Unauthorized access";  // Security check to ensure only admins can manage participants
    exit();
}

// Function to load and save participant data
function getParticipants() {
    $file = 'participants.json';
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function saveParticipants($data) {
    file_put_contents('participants.json', json_encode($data));
}

$action = $_POST['action'];
$username = $_POST['username']; // Username from POST data
$password = $_POST['password']; // Password from POST data

if ($action == 'add' && strtolower($username) != 'admin') { // Ensure that 'Admin' cannot be added as a participant
    $participants = getParticipants();
    if (!isset($participants[$username])) {
        $participants[$username] = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'participant'  // Explicitly set the role to 'participant'
        ];
        saveParticipants($participants);
        echo "Participant added successfully.";
    } else {
        echo "Participant already exists.";
    }
} elseif ($action == 'reset') {
    // Reset logic that ensures the admin is not added to the brackets
    saveParticipants([]);
    echo "Participants reset successfully.";
}
?>
