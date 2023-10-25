<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notaId = $_POST["nota_id"];

    $sql = "SELECT * FROM agenda WHERE id = $notaId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Nota non trovata"]);
    }

    mysqli_close($conn);
}
?>