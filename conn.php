<?php
$host   = "";
$db     = "";
$userdb = "";
$passdb = "";

$mysqli = new mysqli($host, $userdb, $passdb, $db);

if ($mysqli->connect_errno) {
    http_response_code(500);
    die("Gagal koneksi MySQL: " . $mysqli->connect_error);
}
?>
