<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Controlla se è stato fornito un ID di assistenza
	if(isset($_POST['lavorazione_id'])) {
		$lavorazioneId = $_POST['lavorazione_id'];

		// Prepara e esegui la query di eliminazione
		$sql = "DELETE FROM lavorazioni WHERE id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "i", $lavorazioneId);
		mysqli_stmt_execute($stmt);

		// Controlla se l'eliminazione è avvenuta con successo
		if(mysqli_affected_rows($conn) > 0) {
			echo "success";
		} else {
			echo "Errore durante l'eliminazione della lavorazione";
		}

		// Chiudi lo statement e la connessione
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	} else {
		echo "ID lavorazione non fornito";
	}
}
?>