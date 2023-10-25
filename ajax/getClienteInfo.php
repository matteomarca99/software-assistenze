<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clienteId = $_POST["cliente_id"];

    $sql = "SELECT * FROM cliente  WHERE id = $clienteId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Cliente non trovato"]);
    }

    mysqli_close($conn);
}
?>