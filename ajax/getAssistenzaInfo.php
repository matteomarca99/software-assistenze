<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistenzaId = $_POST["assistenza_id"];

    $sql = "SELECT assistenza.*, cliente.* FROM assistenza INNER JOIN cliente ON assistenza.id_cliente = cliente.id WHERE assistenza.id = $assistenzaId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Cliente non trovato"]);
    }

    mysqli_close($conn);
}
?>