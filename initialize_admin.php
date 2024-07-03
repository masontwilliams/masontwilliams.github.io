<?php
// This function checks if the admin user already exists and creates one if not.
function initializeAdmin() {
    $participantsFile = 'participants.json'; // Path to the JSON file storing user data.
    if (file_exists($participantsFile)) {
        $participants = json_decode(file_get_contents($participantsFile), true);
    } else {
        $participants = []; // Initialize empty array if file does not exist.
    }

    if (!array_key_exists('Admin', $participants)) {
        // Setting up predefined admin credentials.
        $participants['Admin'] = [
            'password' => password_hash('Mason', PASSWORD_DEFAULT), // Securely hash the password.
            'role' => 'admin' // Assigning the role of 'admin'.
        ];
        file_put_contents($participantsFile, json_encode($participants)); // Save the updated participants data.
        echo "Admin account initialized successfully.\n";
    } else {
        echo "Admin account already exists.\n";
    }
}

initializeAdmin(); // Execute the function to ensure admin is set up.
?>
