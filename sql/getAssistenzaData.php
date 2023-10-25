<?php
function getAssistenzaData($stati) {
    require_once "db/conn.php";
    
    $statiString = implode(",", $stati);

    $sql = "SELECT assistenza.*, CONCAT(cliente.nome, ' ', cliente.cognome) AS nominativo, diagnosi.id AS idDiagnosi FROM assistenza INNER JOIN cliente ON assistenza.id_cliente = cliente.id
	INNER JOIN diagnosi ON diagnosi.id_assistenza = assistenza.id
	WHERE assistenza.stato IN ($statiString) ORDER BY assistenza.data_inserimento DESC";
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
