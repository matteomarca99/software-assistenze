<?php
	session_start();

	// Verifica se l'utente è loggato
	if (!isset($_SESSION['user_id'])) {
		header("Location: login.php");
		exit();
	}
?>
