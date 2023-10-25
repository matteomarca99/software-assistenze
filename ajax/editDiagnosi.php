<?php
require_once "../db/conn.php";

date_default_timezone_set('Europe/San_Marino');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati forniti tutti i parametri necessari
    if (
        isset($_POST['assistenza_id']) &&
        isset($_POST['p_n']) &&
        isset($_POST['s_n']) &&
        isset($_POST['preventivi']) &&
        isset($_POST['lavorazioni']) &&
        isset($_POST['note']) &&
        isset($_POST['costo_totale']) &&
        isset($_POST['stato'])
    ) {
        $assistenzaId = $_POST['assistenza_id'];
        $p_n = $_POST['p_n'];
        $s_n = $_POST['s_n'];
        $preventivi = $_POST['preventivi'];
        $lavorazioni = $_POST['lavorazioni'];
        $note = $_POST['note'];
        $costo_totale = $_POST['costo_totale'];
        $stato = $_POST['stato'];
        
        // Controlla se inserisci_data è diverso da 0 (1)
        if ($_POST['inserisci_data'] != 0) {
            $inserisci_data = date('Y-m-d H:i:s'); // Ottieni la data attuale
        } else {
			$inserisci_data = 0;
		}

        // Prepara e esegui la query di modifica per la tabella diagnosi
        $sqlDiagnosi = "UPDATE diagnosi 
                        SET p_n = ?, 
                            s_n = ?, 
                            preventivo = ?, 
                            lavorazioni = ?, 
                            note = ?,
                            costo_totale = ?";

        switch ($stato) {
            case 2: // IN LAVORAZIONE
                if ($inserisci_data != 0) {
                    $sqlDiagnosi .= ", data_inizio = ?";
                }
                break;
            case 3: // CONTATTARE PER CONSEGNA
                if ($inserisci_data != 0) {
                    $sqlDiagnosi .= ", data_conferma = ?";
                }
                break;
            case 4: // ATTESA RITIRO
                if ($inserisci_data != 0) {
                    $sqlDiagnosi .= ", data_conclusione = ?";
                }
                break;
            case 5: // COMPLETATO
                if ($inserisci_data != 0) {
                    $sqlDiagnosi .= ", data_consegna = ?";
                }
                break;
            default:
                break;
        }

        $sqlDiagnosi .= " WHERE id_assistenza = ?";
        $stmtDiagnosi = mysqli_prepare($conn, $sqlDiagnosi);

        // Aggiungi questa condizione per gestire inserisci_data
        if (isset($inserisci_data) && $inserisci_data != 0) {
            mysqli_stmt_bind_param($stmtDiagnosi, "sssssssi", $p_n, $s_n, $preventivi, $lavorazioni, $note, $costo_totale, $inserisci_data, $assistenzaId);
        } else {
            mysqli_stmt_bind_param($stmtDiagnosi, "ssssssi", $p_n, $s_n, $preventivi, $lavorazioni, $note, $costo_totale, $assistenzaId);
        }

        mysqli_stmt_execute($stmtDiagnosi);
        
        // Prepara e esegui la query di modifica per la tabella assistenza
        $sqlAssistenza = "UPDATE assistenza 
                          SET stato = ?
						  WHERE id = ?";
        $stmtAssistenza = mysqli_prepare($conn, $sqlAssistenza);
        mysqli_stmt_bind_param($stmtAssistenza, "ii", $stato, $assistenzaId);
        mysqli_stmt_execute($stmtAssistenza);

        // Chiudi lo statement per la tabella assistenza
        mysqli_stmt_close($stmtAssistenza);
        // Chiudi lo statement per la tabella diagnosi e la connessione
        mysqli_stmt_close($stmtDiagnosi);
        mysqli_close($conn);
    } else {
        echo json_encode(["status" => "error", "message" => "Parametri mancanti"]);
    }
}
?>
