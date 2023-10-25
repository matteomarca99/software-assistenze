<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (isset($_POST['nome_cliente']) && isset($_POST['cognome_cliente'])) {
		
		$nome = $_POST['nome_cliente'];
		$cognome = $_POST['cognome_cliente'];
		$email = $_POST['email_cliente'];
		$telefono = $_POST['telefono_cliente'];

        // Prepara e esegui la query di modifica per la tabella diagnosi
        $sqlAdd = "INSERT INTO cliente(nome, cognome, email, telefono) VALUES (?, ?, ?, ?)";
		
        $stmtDiagnosi = mysqli_prepare($conn, $sqlAdd);

		mysqli_stmt_bind_param($stmtDiagnosi, "ssss", $nome, $cognome, $email, $telefono);

        mysqli_stmt_execute($stmtDiagnosi);

        // Chiudi lo statement per la tabella diagnosi e la connessione
        mysqli_stmt_close($stmtDiagnosi);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
