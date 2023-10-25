<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (isset($_POST['nome_nota']) && isset($_POST['testo_nota'])) {
		
		$nome = $_POST['nome_nota'];
		$testo = $_POST['testo_nota'];

        // Prepara e esegui la query di modifica per la tabella diagnosi
        $sqlAdd = "INSERT INTO agenda(nome, testo) VALUES (?, ?)";
		
        $stmtDiagnosi = mysqli_prepare($conn, $sqlAdd);

		mysqli_stmt_bind_param($stmtDiagnosi, "ss", $nome, $testo);

        mysqli_stmt_execute($stmtDiagnosi);

        // Chiudi lo statement per la tabella diagnosi e la connessione
        mysqli_stmt_close($stmtDiagnosi);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
