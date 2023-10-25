<?php
function addAssistenza($id_cliente, $tipo_dispositivo, $salvataggio_dati, $account_microsoft, $materiale_aggiuntivo, $descrizione_problemi, $stato, $priorita) {
    require "db/conn.php";

	date_default_timezone_set('Europe/San_Marino');

    $stmt = $conn->prepare("INSERT INTO assistenza (id_cliente, id_assistenza, tipo_dispositivo, salvataggio_dati, account_microsoft, materiale_aggiuntivo, descrizione_problemi, stato, data_inserimento, priorita) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssssss', $param_id_cliente, $param_id_assistenza, $param_tipo_dispositivo, $param_salvataggio_dati, $param_account_microsoft, $param_materiale_aggiuntivo, $param_descrizione_problemi, $param_stato, $param_data_inserimento, $param_priorita);
    
    $param_id_cliente = $id_cliente;
    
    $data_corrente = time();
    // Genera un hash univoco di 5 lettere per il numero di assistenza
    $param_id_assistenza = substr(hash('sha256', $data_corrente), 0, 5);

    $param_tipo_dispositivo = $tipo_dispositivo;
    $param_salvataggio_dati = $salvataggio_dati;
    $param_account_microsoft = $account_microsoft;
    $param_materiale_aggiuntivo = $materiale_aggiuntivo;
    $param_descrizione_problemi = $descrizione_problemi;
    $param_stato = $stato;
    $param_priorita = $priorita;
    
    $date = date('Y-m-d H:i:s');
    $param_data_inserimento = $date;
    
    $stmt->execute();
    
    // Esegui l'operazione di inserimento prima di ottenere l'ID appena inserito
    $last_id = $stmt->insert_id;

    // E aggiungiamo la diagnosi vuota
    $stmt = $conn->prepare("INSERT INTO diagnosi (id_assistenza, p_n, s_n, preventivo, lavorazioni, note, costo_totale, data_inizio, data_conferma, data_conclusione, data_consegna) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssssss', $last_id, $param_p_n, $param_s_n, $param_preventivo, $param_lavorazioni, $param_note, $param_costo_totale, $param_data_inizio, $data_conferma, $data_conclusione, $data_consegna);

    $param_p_n = '';  // o un valore di default
    $param_s_n = '';  // o un valore di default
    $param_preventivo = '';  // o un valore di default
    $param_lavorazioni = '';  // o un valore di default
    $param_note = '';  // o un valore di default
	$param_costo_totale = ''; // o un valore di default
	$param_data_inizio = ''; // o un valore di default
	$data_conferma = ''; // o un valore di default
	$data_conclusione = ''; // o un valore di default
	$data_consegna = ''; // o un valore di default

    $stmt->execute();

    mysqli_close($conn);
    
    return $param_id_assistenza;
}
?>
