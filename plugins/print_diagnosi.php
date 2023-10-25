<?php

session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
	header("Location: ../login.php");
	exit();
}

require 'tcpdf/tcpdf.php';

require_once "../sql/getAllData.php";

$dati_tabella_preventivi;
$dati_tabella_lavorazioni;

if (isset($_GET['assistenza_id'])) {
    $assistenzaId = $_GET["assistenza_id"];
    $allData = getAllData($assistenzaId);
    
    if (!empty($allData)) {
        foreach ($allData as $row) {
			
            // Gestione dei preventivi
            $preventivi_data = explode("\n", $row["preventivo"]);
            $dati_tabella_preventivi = array();

            foreach ($preventivi_data as $preventivo) {
                $parts = array_map('trim', explode(',', $preventivo));

                if (count($parts) >= 3) {
                    $quantita = isset($parts[1]) ? substr($parts[1], strpos($parts[1], ':') + 1) : '';
                    $nome = isset($parts[0]) ? substr($parts[0], strpos($parts[0], ':') + 1) : '';
                    $costo = isset($parts[2]) ? substr($parts[2], strpos($parts[2], ':') + 1) : '';
					
					$costoDecimal = number_format(floatval($costo), 2);

                    $dati_tabella_preventivi[] = array($quantita, $nome, $costoDecimal);
                }
            }

            // Gestione delle lavorazioni
            $lavorazioni_data = explode("\n", $row["lavorazioni"]);
            $dati_tabella_lavorazioni = array();

            foreach ($lavorazioni_data as $lavorazione) {
                $parts = array_map('trim', explode(',', $lavorazione));

                if (count($parts) >= 3) {
                    $quantita = isset($parts[1]) ? substr($parts[1], strpos($parts[1], ':') + 1) : '';
                    $nome = isset($parts[0]) ? substr($parts[0], strpos($parts[0], ':') + 1) : '';
                    $costo = isset($parts[2]) ? substr($parts[2], strpos($parts[2], ':') + 1) : '';
					
					$costoDecimal = number_format(floatval($costo), 2);

                    $dati_tabella_lavorazioni[] = array($quantita, $nome, $costoDecimal);
                }
            }
        }
    } else {
		die("Nessun dato trovato per l'ID di assistenza specificato.");
	}
}


// Estendi la classe TCPDF
class MioPDF extends TCPDF {

    // Override del metodo Header
    public function Header() {
        // Intestazione personalizzata
        //$this->SetFont('helvetica', 'B', 12);
        //$this->Cell(0, 10, 'Esempio di Tabella TCPDF', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        //$this->Ln(10);
    }

    // Override del metodo Footer
    public function Footer() {
        // Footer personalizzato
        $this->SetY(-15);
		//$pdf->SetFont('', 'B');
		//$pdf->MultiCell(0, 10, 'Firma ritiro: ____________________', 0, 'R', 0, 1, '', '', true);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Firma Ritiro: ____________________', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// Crea una nuova istanza di TCPDF
$pdf = new MioPDF();

// Aggiungi una nuova pagina
$pdf->AddPage();

// Imposta il font
$pdf->SetFont('helvetica', '', 12);

// Definisci l'header della tabella
$header = array('Quantità', 'Descrizione', 'Prezzo', 'Prezzo totale');

$pdf->Image('../img/logo.jpg', $x=10, $y=10, $w=35, $h=14, 'jpg');

$pdf->Ln(20);

// Costruisci la tabella
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 10, 'Riepilogo Assistenza', 0, 'C', 0, 1, '', '', true);
$pdf->Ln(10);

// DATI CLIENTE

$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 10, 'Dati Cliente', 0, 'L', 0, 1, '', '', true);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(40, 5, 'Nominativo', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $row["nome"] . ' ' . $row["cognome"], 1, 1, 'C', 1);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(40, 5, 'Telefono', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $row["telefono"], 1, 1, 'C', 1);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(40, 5, 'Email', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $row["email"], 1, 1, 'C', 1);

$pdf->Ln();

$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 10, 'Dati Dispositivo', 0, 'L', 0, 1, '', '', true);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(40, 5, 'P/N', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $row["p_n"], 1, 1, 'C', 1);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(40, 5, 'S/N', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $row["s_n"], 1, 0, 'C', 1);

$pdf->Ln(10);

// TABELLA PREVENTIVO

$pdf->SetFont('', 'B');
$pdf->MultiCell(0, 10, 'Preventivo', 0, 'L', 0, 1, '', '', true);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

$larghezze_colonne = array(20, 100, 30, 0);
$altezza_riga = 5;

// Stampa l'header

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($larghezze_colonne[$i], $altezza_riga, $header[$i], 1, 0, 'C', 1);
}

$pdf->Ln();

// Stampa i dati
$pdf->SetFont('');
$pdf->SetFillColor(255, 255, 255);

foreach ($dati_tabella_preventivi as $riga) {
    for ($i = 0; $i < count($riga); $i++) {
        $pdf->Cell($larghezze_colonne[$i], $altezza_riga, $riga[$i], 'TBL', 0, 'C', 1);
    }
	$tot = strval(number_format((float)$riga[0] * $riga[2], 2, '.', ''));
    $pdf->Cell(0, $altezza_riga, $tot, 1, 1, 'C', 1);
}

// Calcola e stampa il totale
$totale = 0;
foreach ($dati_tabella_preventivi as $riga) {
    $totale += $riga[0] * $riga[2];
}
$pdf->SetFont('', 'B');
$s = 'Totale: ' . strval(number_format((float)$totale, 2, '.', '')) . ' €';
$pdf->Cell(150, $altezza_riga, '', 'TR', 0, 'C', 1);
$pdf->SetFillColor(221, 255, 153);
$pdf->Cell(0, $altezza_riga, $s, 1, 0, 'C', 1);

// TABELLA LAVORZIONI

$pdf->Ln(10);
$pdf->MultiCell(0, 10, 'Lavorazioni Eseguite', 0, 'L', 0, 1, '', '', true);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

// Stampa l'header

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($larghezze_colonne[$i], $altezza_riga, $header[$i], 1, 0, 'C', 1);
}

$pdf->Ln();

// Stampa i dati
$pdf->SetFont('');
$pdf->SetFillColor(255, 255, 255);

foreach ($dati_tabella_lavorazioni as $riga) {
    for ($i = 0; $i < count($riga); $i++) {
        $pdf->Cell($larghezze_colonne[$i], $altezza_riga, $riga[$i], 'TBL', 0, 'C', 1);
    }
	$tot = strval(number_format((float)$riga[0] * $riga[2], 2, '.', ''));
    $pdf->Cell(0, $altezza_riga, $tot, 1, 1, 'C', 1);
}

// Calcola e stampa il totale
$totale = 0;
foreach ($dati_tabella_lavorazioni as $riga) {
    $totale += $riga[0] * $riga[2];
}
$pdf->SetFont('', 'B');
$s = 'Totale: ' . strval(number_format((float)$totale, 2, '.', '')) . ' €';
$pdf->Cell(150, $altezza_riga, '', 'TR', 0, 'C', 1);
$pdf->SetFillColor(221, 255, 153);
$pdf->Cell(0, $altezza_riga, $s, 1, 0, 'C', 1);

$pdf->Ln(10);

// NOTE

if($row["note"] != ''){
	$pdf->SetFont('', 'B');
	$pdf->MultiCell(0, 10, 'Note', 0, 'L', 0, 1, '', '', true);
	$pdf->SetFont('');
	$pdf->SetFillColor(230, 230, 230);

	$pdf->MultiCell(0, 0, $row["note"], 1, 'L', 1, 1, '', '', true);
}

$pdf->Ln(15);

// DATE

$dataInizio = date( 'd/m/Y H:i', strtotime($row["data_inizio"]));
$dataConferma = date( 'd/m/Y H:i', strtotime($row["data_conferma"]));
$dataConclusione = date( 'd/m/Y H:i', strtotime($row["data_conclusione"]));
$dataConsegna = date( 'd/m/Y H:i', strtotime($row["data_consegna"]));

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(70, 5, 'Data inizio', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');

if($row["data_inizio"] == '0000-00-00 00:00:00'){
	$pdf->Cell(70, 5, $dataConclusione, 1, 1, 'C', 1);
} else {
	$pdf->Cell(70, 5, $dataInizio, 1, 1, 'C', 1);
}

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');

if($row["data_conferma"] == '0000-00-00 00:00:00'){
	$pdf->Cell(70, 5, 'Preventivo rifiutato il', 1, 0, 'C', 1);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('');
	$pdf->Cell(70, 5, $dataConclusione, 1, 1, 'C', 1);
} else {
	$pdf->Cell(70, 5, 'Preventivo confermato il', 1, 0, 'C', 1);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('');
	$pdf->Cell(70, 5, $dataConferma, 1, 1, 'C', 1);
}

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(70, 5, 'Data conclusione', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $dataConclusione, 1, 1, 'C', 1);

$pdf->SetFillColor(224, 235, 255);
$pdf->SetFont('', 'B');
$pdf->Cell(70, 5, 'Data consegna', 1, 0, 'C', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('');
$pdf->Cell(70, 5, $dataConsegna, 1, 1, 'C', 1);

// ID assistenza in alto a destra

$pdf->SetXY(150, 15);

$output = "<strong>ID Assistenza: # " . $row["codice_assistenza"] . "</strong>";

$pdf->writeHTML($output, true, false, false, false, '');

// Output del PDF
$pdf->OutPut();
