<?php
$servername = "vuoto-mysql";
$username = "vuotodb";
$password = "kyberlinna";
$database = "vuotodb";

// Luo tietokantayhteys
$conn = new mysqli($servername, $username, $password, $database);

// Tarkista yhteys
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}
?>
