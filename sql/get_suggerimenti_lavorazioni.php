<?php
require_once "../db/conn.php";

// Recupera il termine di ricerca inviato dalla richiesta AJAX
$searchTerm = $_GET['searchTerm'];

// Esegui una query per ottenere i suggerimenti
$sql = "SELECT nome, costo FROM lavorazioni WHERE nome LIKE '%$searchTerm%'";
$result = $conn->query($sql);

$suggerimenti = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $suggerimento = [
            'nome' => $row['nome'],
            'costo' => $row['costo']
        ];
        $suggerimenti[] = $suggerimento;
    }
}

// Chiudi la connessione al database
$conn->close();

// Restituisci i suggerimenti in formato JSON
header('Content-Type: application/json');
echo json_encode($suggerimenti);
?>
