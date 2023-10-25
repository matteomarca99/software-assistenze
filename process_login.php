<?php
session_start();
require_once "db/conn.php"; // Connessione al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $privilegio;

    // Esegue una query per ottenere la password hash associata all'utente
    $query = "SELECT id, username, password, privilegio FROM utenti WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password, $privilegio);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verifica se l'utente esiste e verifica la password
    if ($user_id && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['privilegio'] = $privilegio;
        header("Location: index.php"); // Reindirizza all'area riservata
    } else {
        header("Location: login.php?login=false");
    }
}

mysqli_close($conn);
?>
