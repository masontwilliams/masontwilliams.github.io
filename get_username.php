<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

echo json_encode(["username" => $_SESSION['username']]);
?>
