<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (
        isset($_POST['nota_id']) &&
        isset($_POST['nome']) &&
        isset($_POST['testo'])
    ) {
        $notaId = $_POST['nota_id'];
        $nome = $_POST['nome'];
        $testo = $_POST['testo'];

        // Prepara e esegui la query di modifica
        $sql = "UPDATE agenda 
                SET nome = ?, 
                    testo = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nome, $testo, $notaId);
        mysqli_stmt_execute($stmt);

        // Controlla se la modifica è avvenuta con successo
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Errore durante la modifica della nota."]);
        }

        // Chiudi lo statement e la connessione
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
