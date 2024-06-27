<?php
// List of preregistered users with their passwords
$users = [
    'user1' => 'password1',
    'user2' => 'password2',
    'user3' => 'password3',
    'user4' => 'password4',
    // Add more users as needed
];

// Initial tournament matchups
$tournament_bracket = [
    ['user1', 'user2'],
    ['user3', 'user4'],
    // Add more matchups as needed
];

// Function to save tournament data to a file
function saveTournamentData($bracket) {
    file_put_contents('tournament_bracket.json', json_encode($bracket));
}

// Function to load tournament data from a file
function loadTournamentData() {
    if (file_exists('tournament_bracket.json')) {
        return json_decode(file_get_contents('tournament_bracket.json'), true);
    }
    return [];
}

// Save the initial bracket if it doesn't already exist
if (!file_exists('tournament_bracket.json')) {
    saveTournamentData($tournament_bracket);
}
?>