<?php
session_start();

// Elimina tutte le variabili di sessione
$_SESSION = array();

// Cancella il cookie di sessione
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Distrugge la sessione
session_destroy();

// Reindirizza l'utente alla pagina di login (o a qualsiasi altra pagina)
header("Location: login.php");
exit;
?>
