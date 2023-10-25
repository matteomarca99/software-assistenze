<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_diagnosi'])) {
        $diagnosiId = $_POST['id_diagnosi'];

        // Prepara la query per recuperare le immagini associate a una diagnosi
        $sql = "SELECT tipo, dati FROM allegato WHERE id_diagnosi = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $diagnosiId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $mime_type, $file_data);

        $result = array();

        while (mysqli_stmt_fetch($stmt)) {
            // Aggiungi i dati delle immagini all'array di risultati
            $result[] = array(
                'mime_type' => $mime_type,
                'file_data' => base64_encode($file_data)
            );
        }

        // Restituisci i dati delle immagini come JSON
        header('Content-Type: application/json');
        echo json_encode($result);

        // Chiudi lo statement e la connessione
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "ID diagnosi non fornito";
    }
}
?>
