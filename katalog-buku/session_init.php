<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fitur Pergantian Bahasa via Session
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'id';
}

$lang_code = $_SESSION['lang'] ?? 'id';
$lang = require __DIR__ . "/lang/{$lang_code}.php";

// Fungsi Sanitasi Input untuk Pengamanan
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>