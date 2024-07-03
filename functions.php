<?php
// Loads data from a JSON file
function loadData($filename) {
    if (file_exists($filename)) {
        return json_decode(file_get_contents($filename), true);
    }
    return [];  // Return an empty array if the file doesn't exist
}

// Saves data to a JSON file
function saveData($filename, $data) {
    file_put_contents($filename, json_encode($data));
}

// Determines the winner of a match based on moves
function determineWinner($playerMove, $opponentMove) {
    $rules = [
        'rock' => 'scissors',
        'scissors' => 'paper',
        'paper' => 'rock'
    ];
    if ($playerMove === $opponentMove) {
        return null;  // Tie
    } elseif ($rules[$playerMove] === $opponentMove) {
        return 'player';
    } else {
        return 'opponent';
    }
}

// Advances winners to the next round in a single-elimination tournament
function advanceWinner(&$brackets, $winnerUsername) {
    foreach ($brackets as $roundIndex => &$round) {
        foreach ($round as $matchIndex => &$match) {
            if (in_array($winnerUsername, $match)) {
                if (!isset($brackets[$roundIndex + 1])) {
                    $brackets[$roundIndex + 1] = [];  // Create next round if it doesn't exist
                }
                $nextMatchIndex = floor($matchIndex / 2);
                if (!isset($brackets[$roundIndex + 1][$nextMatchIndex])) {
                    $brackets[$roundIndex + 1][$nextMatchIndex] = [];
                }
                if (empty($brackets[$roundIndex + 1][$nextMatchIndex]['player1'])) {
                    $brackets[$roundIndex + 1][$nextMatchIndex]['player1'] = $winnerUsername;
                } else {
                    $brackets[$roundIndex + 1][$nextMatchIndex]['player2'] = $winnerUsername;
                }
                break 2;
            }
        }
    }
}
?>
