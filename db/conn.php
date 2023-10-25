<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbugame";

// Connessione al database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica la connessione
if (!$conn) {
    die("Connessione fallita: " . mysqli_connect_error());
}
?>
