<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Controlla se è stato fornito un ID di assistenza
	if(isset($_POST['id_diagnosi'])) {
		$dignosiId = $_POST['id_diagnosi'];

		// Prepara e esegui la query di eliminazione
		$sql = "DELETE FROM allegato WHERE id_diagnosi = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "i", $dignosiId);
		mysqli_stmt_execute($stmt);

		// Controlla se l'eliminazione è avvenuta con successo
		if(mysqli_affected_rows($conn) > 0) {
			echo "success";
		} else {
			echo "Errore durante l'eliminazione degli allegati";
		}

		// Chiudi lo statement e la connessione
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	} else {
		echo "ID diagnosi non fornito";
	}
}
?>