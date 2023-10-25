<?php
function getAllData($id_assistenza) {
    require_once "../db/conn.php";
    
    $sql = "SELECT diagnosi.*, cliente.*, assistenza.id_assistenza as codice_assistenza FROM diagnosi INNER JOIN assistenza ON diagnosi.id_assistenza = assistenza.id INNER JOIN cliente ON assistenza.id_cliente = cliente.id WHERE diagnosi.id_assistenza = $id_assistenza";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    } else {
        return [];
    }

    mysqli_close($conn);
}

?>
