<?php
require_once "../db/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistenzaId = $_POST["assistenza_id"];

    $sql = "SELECT diagnosi.*, assistenza.id_assistenza, assistenza.priorita FROM diagnosi INNER JOIN assistenza ON assistenza.id = diagnosi.id_assistenza WHERE assistenza.id = $assistenzaId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Diagnosi non trovata"]);
    }

    mysqli_close($conn);
}
?>