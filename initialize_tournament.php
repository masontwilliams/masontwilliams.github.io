<?php
session_start();
require 'functions.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Unauthorized access"; // Security check
    exit();
}

// Function to initialize or reset the tournament brackets
function initializeBrackets() {
    $participants = loadData('participants.json'); // Fetch all registered participants
    $bracket = [];
    $players = array_keys($participants);

    // Filter out admin from participants
    $players = array_filter($players, function($player) use ($participants) {
        return $participants[$player]['role'] === 'participant';
    });

    shuffle($players); // Randomize the bracket order for the tournament

    // Create first round matches
    for ($i = 0; $i < count($players); $i += 2) {
        $bracket[0][] = [
            'player1' => $players[$i],
            'player2' => isset($players[$i + 1]) ? $players[$i + 1] : null,
            'winner' => null
        ];
    }

    saveData('tournament_bracket.json', $bracket); // Save the newly initialized brackets
    echo "Tournament brackets initialized successfully.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    initializeBrackets();
}
?>
