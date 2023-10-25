<?php
function getNumAssistenzeByStato() {
    require "db/conn.php";

    $sql = "SELECT stato, COUNT(*) as numero_assistenze FROM assistenza WHERE stato <> 5 GROUP BY stato;";
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
