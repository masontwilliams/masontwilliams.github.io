<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Authentication required"]);
    exit;
}

// Assuming bracket data is stored in 'tournament_bracket.json'
$bracketData = loadData('tournament_bracket.json');
echo json_encode($bracketData);
?>
