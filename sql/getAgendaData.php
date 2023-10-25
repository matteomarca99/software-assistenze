<?php
function getAgendaData() {
    require_once "db/conn.php";

    $sql = "SELECT * FROM agenda";
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
