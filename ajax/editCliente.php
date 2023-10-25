<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (
        isset($_POST['cliente_id']) &&
        isset($_POST['nome']) &&
        isset($_POST['cognome']) &&
        isset($_POST['email']) &&
        isset($_POST['telefono'])
    ) {
        $clienteId = $_POST['cliente_id'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
		$email = $_POST['email'];
        $telefono = $_POST['telefono'];

        // Prepara e esegui la query di modifica
        $sql = "UPDATE cliente 
                SET nome = ?, 
                    cognome = ?,
					email = ?,
					telefono = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $cognome, $email, $telefono, $clienteId);
        mysqli_stmt_execute($stmt);

        // Controlla se la modifica è avvenuta con successo
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Errore durante la modifica del cliente"]);
        }

        // Chiudi lo statement e la connessione
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
