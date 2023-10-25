<?php

	session_start();

	// Verifica se l'utente è loggato
	if (!isset($_SESSION['user_id'])) {
		header("Location: ../login.php");
		exit();
	}

	include("tcpdf/tcpdf.php");
	
	$assistenzaId = isset($_GET['assistenza_id']) ? $_GET['assistenza_id'] : null;

	if (!$assistenzaId) {
		die("ID dell'assistenza non fornito");
	}
	
	$pdf = new TCPDF("P","mm","A4");
	
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	$pdf->AddPage();
	
	$date = date('d/m/Y');
	
	// define some HTML content with style
$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
	.separator {

	}

</style>

<img src="../img/logo.jpg"  width="100" height="40" /> <br>
<span style="text-align:justify;"><h5>Condizioni Generali di Assistenza:</h5><br>
<h6>1) U-Game Srls può rifiutare la riparazione qualora il cliente abbia, volontariamente o per dimenticanza, omesso in fase di accettazione problemi o difetti noti ,poi riscontrati durante lo svolgimento, che potrebbero inficiare il risultato della riparazione oppure qualora il cliente rifiuti la sostituzione di parti o lavorazioni ritenute necessarie dal reparto tecnico in seguito ai test preliminari;<br>
2) Il cliente accetta sin d&#39;ora che il tempo di lavorazione potrebbe subire allungamenti per cause di forza maggiore e manleva U-Game Srls da qualsiasi responsabilità in merito ivi comprese eventuali perdite di opportunità produttive/lavorative;<br>
3) Il cliente dichiara di consegnare il dispositivo privo di dati personali, file immagini, documenti, video, e-mail e altri file la cui perdita potrebbe provocare danni e manleva U-Game Srls da qualsiasi responsabilità per la loro cancellazione anche nel caso di richiesta di salvataggio dati a causa di eventuali limiti tecnologici. Ilcliente è, in ogni caso, unico responsabile dei dati, delle informazioni e dei software contenuti in qualunque modo nei dispositivi oggetto dell&#39;assistenza con particolare riferimento alla leicità e alla titolarità degli stessi;<br>
4)) Il cliente, una volta avvisato, è tenuto a ritirare il prodotto recandosi presso il punto vendita U-Game entro e non oltre 30 giorni dalla comunicazione pena la facoltà di rivendita;<br>
5) L&#39;importo della riparazione va corrisposto in un&#39;unica soluzione e per intero al momento del ritiro altrimenti il dispositivo sarà detenuto dall&#39;azienda fino al totale pagamento dell&#39;importo comunicato;<br>
6) Il cliente riconosce espressamente sin d’ora, in caso di mancato ritiro o pagamento, a U-Game Srls la facoltà di esercitare il diritto di ritenzione sul prodotto ed eventualmente anche la facoltà di venderlo ai sensi e per gli effetti degli articoli 1152 e 2756 c.c.;<br>
7) Il cliente accetta che qualora non richieda espressamente al momento del ritiro di controllare il funzionamento del dispositivo riparato non potrà in nessun caso addebitare a U-Game Srls eventuali problematiche riscontrate successivamente o lamentare danni causati dall&#39;assistenza manlevando di conseguenza l&#39;azienda da qualsivoglia responsabilità in merito;<br>

<br>Firma per presa visione ed accettazione delle condizioni di Assistenza e per esplicita accettazione dei punti 1,2,3,4,5,6,7:</h6></span>

EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(150, 15);

$output = "<strong>ID assistenza: # $assistenzaId</strong>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 110);

$output = "<span><h5>Data: $date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma: ______________</h5></span>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 120);

$output = <<<EOF
<span style="text-align:justify;">
<h6>Ai sensi del GDPR (Regolamento Europeo sulla Privacy. 679/2016) e del Decreto Legislativo 30 Giugno 2003, n. 196, il cliente prende atto che i Dati Personali comunicati formeranno oggetto del trattamento. A tal fine il cliente, firmando la presente e lasciando i propri dispositivi in assistenza, dichiara di aver ricevuto lettura e approvare l'informativa sulla Privacy. Titolare del trattamento è U-Game Srls, Viale Alcide De Gasperi, 115 - 63076 Monteprandone (AP) - info@u-game.it
</h6></span>

EOF;

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 140);

$output = "<span><h5>Data: $date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma: ______________</h5></span>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 170);

$output = "<hr>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 180);

$output = <<<EOF

<img src="../img/logo.jpg"  width="100" height="40" /> <br>
<span style="text-align:justify;"><h6>
<br>1. Eventuali informazioni sullo stato dei lavori possono essere richieste solo via email a assistenza@u-game.it comunicando il numero di assistenza sopra riportato;
<br>2. Se non richiesto in fase di accettazione non sarà effettuato alcun backup dei dati;
<br>3. Eventuali problematiche aggiuntive comunicate dopo aver lasciato il dispositivo comporteranno inevitabilmente un allungamento dei tempi di lavorazione;
<br>4. In caso di DOA o RMA (Garanzia) il tempo medio di risoluzione è di circa 60 giorni;
<br>5. Una volta ricevuta la comunicazione del termine dei lavori è necessario ritirare il prodotto nei seguenti 14gg;
<br>6. In caso il ritiro del dispositivo venga effettuato da familiare o persona di fiducia è necessario avvisare l'assistenza via email a assistenza@u-game.it
</h6></span>

EOF;

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(20, 240);

$output = "<span><h5>Data: $date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Firma: ______________</h5></span>";

$pdf->writeHTML($output, true, false, false, false, '');

$pdf->SetXY(150, 183);

$output = "<strong>ID assistenza: # $assistenzaId</strong>";

$pdf->writeHTML($output, true, false, false, false, '');
	
$pdf->OutPut();
?>