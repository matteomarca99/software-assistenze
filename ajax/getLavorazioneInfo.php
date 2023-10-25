<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lavorazioneId = $_POST["lavorazione_id"];

    $sql = "SELECT * FROM lavorazioni  WHERE id = $lavorazioneId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Lavorazione non trovata"]);
    }

    mysqli_close($conn);
}
?>