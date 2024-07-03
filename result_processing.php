<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Authentication required"]);
    exit;
}

$playerUsername = $_SESSION['username'];
$playerMove = $_POST['choice'];

$brackets = loadData('tournament_bracket.json'); // Load tournament brackets

// Find the current match for this player
$currentMatch = null;
foreach ($brackets as &$round) {
    foreach ($round as &$match) {
        if ($match['player1'] === $playerUsername || $match['player2'] === $playerUsername) {
            $currentMatch = &$match;
            break 2;
        }
    }
}

if ($currentMatch === null) {
    echo json_encode(["error" => "Match not found"]);
    exit;
}

// Save the player's move
$currentMatch['moves'][$playerUsername] = $playerMove;

// Check if both players have made their moves
if (isset($currentMatch['moves'][$currentMatch['player1']]) && isset($currentMatch['moves'][$currentMatch['player2']])) {
    $player1Move = $currentMatch['moves'][$currentMatch['player1']];
    $player2Move = $currentMatch['moves'][$currentMatch['player2']];
    $result = determineWinner($player1Move, $player2Move);

    if ($result === 'player') {
        $winner = $currentMatch['player1'];
    } elseif ($result === 'opponent') {
        $winner = $currentMatch['player2'];
    } else {
        // In case of a tie, clear both players' moves and prompt for rematch
        unset($currentMatch['moves'][$currentMatch['player1']]);
        unset($currentMatch['moves'][$currentMatch['player2']]);
        saveData('tournament_bracket.json', $brackets);
        echo json_encode(["result" => "tie", "message" => "It's a tie! Please make your selection again."]);
        exit;
    }

    $currentMatch['winner'] = $winner;
    advanceWinner($brackets, $winner);
    saveData('tournament_bracket.json', $brackets);
    $opponentMove = ($winner === $currentMatch['player1']) ? $player2Move : $player1Move;
    echo json_encode([
        "result" => $winner === $playerUsername ? "win" : "lose",
        "yourMove" => $playerMove,
        "opponentMove" => $opponentMove
    ]);
} else {
    saveData('tournament_bracket.json', $brackets);
    echo json_encode(["result" => "waiting", "message" => "Waiting for opponent's move..."]);
}
?>


