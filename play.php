<?php
session_start();
include 'tournament_data.php'; // Include the tournament data

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You must be logged in to play.";
    exit();
}

$username = $_SESSION['username'];
$user_choice = $_POST['choice']; // Get the user's choice

// Load the current bracket
$bracket = loadTournamentData();

// Update the user's choice in the current match
foreach ($bracket as &$match) {
    if (in_array($username, $match)) {
        if ($match[0] === $username) {
            $match[2] = $user_choice; // Store player 1's choice
        } elseif ($match[1] === $username) {
            $match[3] = $user_choice; // Store player 2's choice
        }
        break;
    }
}

// Check if both players in a match have made their choices
foreach ($bracket as &$match) {
    if (isset($match[2]) && isset($match[3])) {
        $player1 = $match[0];
        $player2 = $match[1];
        $choice1 = $match[2];
        $choice2 = $match[3];

        // Determine the winner
        if ($choice1 === $choice2) {
            $winner = "It's a tie! Both chose $choice1.";
        } elseif (
            ($choice1 === 'rock' && $choice2 === 'scissors') ||
            ($choice1 === 'paper' && $choice2 === 'rock') ||
            ($choice1 === 'scissors' && $choice2 === 'paper')
        ) {
            $winner = "$player1 wins! $choice1 beats $choice2.";
            $winner_name = $player1;
        } else {
            $winner = "$player2 wins! $choice2 beats $choice1.";
            $winner_name = $player2;
        }

        // Update the bracket for the next round
        $match[0] = $winner_name;
        $match[1] = '';
        unset($match[2]);
        unset($match[3]);

        break;
    }
}

// Save the updated bracket
saveTournamentData($bracket);

// Return the result
echo $winner;
?>