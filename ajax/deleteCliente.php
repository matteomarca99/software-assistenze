<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Controlla se è stato fornito un ID di assistenza
	if(isset($_POST['cliente_id'])) {
		$clienteId = $_POST['cliente_id'];

		// Controlla se ci sono assistenze associate a questo cliente
		$sqlCheck = "SELECT COUNT(*) FROM assistenza WHERE id_cliente = ?";
		$stmtCheck = mysqli_prepare($conn, $sqlCheck);
		mysqli_stmt_bind_param($stmtCheck, "i", $clienteId);
		mysqli_stmt_execute($stmtCheck);
		mysqli_stmt_bind_result($stmtCheck, $count);
		mysqli_stmt_fetch($stmtCheck);
		mysqli_stmt_close($stmtCheck);

		if ($count > 0) {
			// Se ci sono assistenze associate, non effettuare l'eliminazione
			echo "eliminazione-fallita";
		} else {
			// Altrimenti, procedi con l'eliminazione
			$sql = "DELETE FROM cliente WHERE id = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "i", $clienteId);
			mysqli_stmt_execute($stmt);

			// Controlla se l'eliminazione è avvenuta con successo
			if(mysqli_affected_rows($conn) > 0) {
				echo "success";
			} else {
				echo "Errore durante l'eliminazione del cliente";
			}

			// Chiudi lo statement e la connessione
			mysqli_stmt_close($stmt);
		}

		mysqli_close($conn);
	} else {
		echo "ID cliente non fornito";
	}
}
?>
