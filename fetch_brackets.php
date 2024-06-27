<?php
session_start();
include 'tournament_data.php'; // Include the tournament data

// Load the current bracket
$bracket = loadTournamentData();

ob_start(); // Start output buffering

echo '<div class="bracket">';
foreach ($bracket as $match) {
    echo '<div class="match">';
    echo '<p>' . htmlspecialchars($match[0]) . ' vs ' . htmlspecialchars($match[1]) . '</p>';
    echo '</div>';
}
echo '</div>';

$html_output = ob_get_clean(); // Get the contents of the output buffer and clean it

echo $html_output;
?>