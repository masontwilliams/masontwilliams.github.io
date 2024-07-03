<?php
// Load data from a JSON file
function loadData($filename) {
    if (file_exists($filename)) {
        return json_decode(file_get_contents($filename), true);
    }
    return [];
}

// Save data to a JSON file
function saveData($filename, $data) {
    file_put_contents($filename, json_encode($data));
}

// Determine the winner of a "Rock, Paper, Scissors" match
function determineWinner($player1Move, $player2Move) {
    if ($player1Move === $player2Move) {
        return "tie";
    }

    $winningMoves = [
        "rock" => "scissors",
        "scissors" => "paper",
        "paper" => "rock"
    ];

    if ($winningMoves[$player1Move] === $player2Move) {
        return "player";
    } else {
        return "opponent";
    }
}

// Advance the winner to the next round
function advanceWinner(&$brackets, $winner) {
    foreach ($brackets as &$round) {
        foreach ($round as &$match) {
            if ($match['player1'] === $winner || $match['player2'] === $winner) {
                $match['winner'] = $winner;
                return;
            }
        }
    }
}
?>
