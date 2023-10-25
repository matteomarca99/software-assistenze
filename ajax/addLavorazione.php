<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (isset($_POST['nome_lavorazione']) && isset($_POST['costo_lavorazione'])) {
		
		$nome = $_POST['nome_lavorazione'];
		$costo = $_POST['costo_lavorazione'];

        // Prepara e esegui la query di modifica per la tabella diagnosi
        $sqlAdd = "INSERT INTO lavorazioni(nome, costo) VALUES (?, ?)";
		
        $stmtDiagnosi = mysqli_prepare($conn, $sqlAdd);

		mysqli_stmt_bind_param($stmtDiagnosi, "ss", $nome, $costo);

        mysqli_stmt_execute($stmtDiagnosi);

        // Chiudi lo statement per la tabella diagnosi e la connessione
        mysqli_stmt_close($stmtDiagnosi);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
