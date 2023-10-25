<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (
        isset($_POST['assistenza_id']) &&
        isset($_POST['priorita']) &&
        isset($_POST['tipo_dispositivo']) &&
        isset($_POST['salvataggio_dati']) &&
        isset($_POST['account_microsoft']) &&
        isset($_POST['materiale_aggiuntivo']) &&
        isset($_POST['descrizione_problemi'])
    ) {
        $assistenzaId = $_POST['assistenza_id'];
        $priorita = $_POST['priorita'];
        $tipoDispositivo = $_POST['tipo_dispositivo'];
        $salvataggioDati = $_POST['salvataggio_dati'];
        $accountMicrosoft = $_POST['account_microsoft'];
        $materialeAggiuntivo = $_POST['materiale_aggiuntivo'];
        $descrizioneProblemi = $_POST['descrizione_problemi'];

        // Prepara e esegui la query di modifica
        $sql = "UPDATE assistenza 
                SET priorita = ?, 
                    tipo_dispositivo = ?, 
                    salvataggio_dati = ?, 
                    account_microsoft = ?, 
                    materiale_aggiuntivo = ?, 
                    descrizione_problemi = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssi", $priorita, $tipoDispositivo, $salvataggioDati, $accountMicrosoft, $materialeAggiuntivo, $descrizioneProblemi, $assistenzaId);
        mysqli_stmt_execute($stmt);

        // Controlla se la modifica è avvenuta con successo
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Errore durante la modifica dell'assistenza"]);
        }

        // Chiudi lo statement e la connessione
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
