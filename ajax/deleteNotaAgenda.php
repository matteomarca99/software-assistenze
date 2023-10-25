<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Controlla se è stato fornito un ID di assistenza
	if(isset($_POST['nota_id'])) {
		$notaId = $_POST['nota_id'];
		
		// Altrimenti, procedi con l'eliminazione
		$sql = "DELETE FROM agenda WHERE id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "i", $notaId);
		mysqli_stmt_execute($stmt);

		// Controlla se l'eliminazione è avvenuta con successo
		if(mysqli_affected_rows($conn) > 0) {
			echo "success";
		} else {
			echo "Errore durante l'eliminazione della nota";
		}

		// Chiudi lo statement e la connessione
		mysqli_stmt_close($stmt);
	}
}
?>
