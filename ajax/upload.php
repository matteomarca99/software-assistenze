<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_diagnosi = $_POST['id_diagnosi'];
    $nome_file = $_FILES['file']['name'];
    $tipo_file = $_FILES['file']['type'];
    $dati_file = file_get_contents($_FILES['file']['tmp_name']);

    $sql = "INSERT INTO allegato (nome, tipo, dati, id_diagnosi) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $nome_file, $tipo_file, $dati_file, $id_diagnosi);
    mysqli_stmt_execute($stmt);

    if(mysqli_affected_rows($conn) > 0) {
        echo "success";
    } else {
        echo "Errore durante il caricamento del file";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
