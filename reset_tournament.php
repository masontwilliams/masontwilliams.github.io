<?php
session_start();
require 'functions.php';

if ($_SESSION['role'] !== 'admin') {
    echo "Unauthorized access"; // Security check
    exit();
}

// Clear participants, tournament, and match data
saveData('participants.json', []);
saveData('tournament_bracket.json', []);
saveData('current_match.json', []);

echo "Tournament and participants reset successfully.";
?>

