<?php include('login_required.php'); ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dobby 3.0</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/cfa4634ae8.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
	
	include('pages/header.php');

	require_once "sql/getAssistenzaData.php";

	$assistenzaData = getAssistenzaData([0, 1, 2, 3, 4]);


	if (!empty($assistenzaData)) {
		echo '<div class="container mt-4">
				<h1 class="mb-3">Assistenze in corso</h1>
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Data inserimento</th>
							<th scope="col">ID assistenza</th>
							<th scope="col">Cliente</th>
							<th scope="col">Dispositivo</th>
							<th scope="col">Stato</th>
							<th scope="col">Azioni</th>
						</tr>
					</thead>
					<tbody>';

		foreach ($assistenzaData as $row) {
			$valid_date = date( 'd/m/Y H:i', strtotime($row["data_inserimento"]));
			echo '<tr>';
			if ($row["priorita"] == "ALTA") {
				echo '<th scope="row">
						<div class="position-relative">
							<i class="fa-solid fa-square-parking fa-beat-fade alta-priority" style="color: #ff0000;"></i>
							'.$valid_date.'
						</div>
					  </th>';
			} else {
				echo '<th scope="row">'.$valid_date.'</th>';
			}
			echo '<th scope="row"><span class="badge rounded-pill ' . ($row["priorita"] == "ALTA" ? 'bg-danger' : 'bg-primary') . '" id="id_assistenza"># ' . $row["id_assistenza"] . '</span></th>
				  <th scope="row">'.$row["nominativo"].'</th>
				  <td>'.$row["tipo_dispositivo"].'</td>
				  <td> '. ($row['stato'] == 0 ? '<span class="badge rounded-pill bg-warning badge-stato">ATTESA PREVENTIVO <i class="fa-solid fa-spinner fa-spin"></i></span>' :
							 ($row['stato'] == 1 ? '<span class="badge rounded-pill bg-primary badge-stato">CONTATTARE CLIENTE <i class="fa-solid fa-phone-flip"></i></span>' :
							  ($row['stato'] == 2 ? '<span class="badge rounded-pill bg-secondary badge-stato">IN LAVORAZIONE <i class="fa-solid fa-spinner fa-spin"></i></span>' :
							  ($row['stato'] == 3 ? '<span class="badge rounded-pill bg-primary badge-stato">CONTATTARE PER CONSEGNA <i class="fa-solid fa-phone-flip"></i></span>' :
							   ($row['stato'] == 4 ? '<span class="badge rounded-pill bg-info badge-stato">ATTESA RITIRO <i class="fa-solid fa-box-archive"></i></span>' :
								($row['stato'] == 5 ? '<span class="badge rounded-pill bg-success badge-stato">COMPLETATO <i class="fa-solid fa-circle-check"></i></span>' :
									'<span class="badge rounded-pill bg-primary badge-stato">STATO SCONOSCIUTO</span>'
								   )
								  )
								 )
								)
							   )
							 ).'</td>
				  <td>
				  <div class="row g-1">
				  <div class="col">
					<a class="btn btn-primary btn-action btn-dettagli" role="button" data-bs-toggle="modal" data-bs-target="#modal_dettagli_assistenza" data-button="'.$row['id'].'" data-nominativo="'.$row['nominativo'].'"><i class="fa-solid fa-eye"></i></a>
				  </div>
				  <div class="col">
					<a class="btn btn-warning btn-action btn-modifica" role="button" data-bs-toggle="modal" data-bs-target="#modal_modifica_assistenza" data-button="'.$row['id'].'"><i class="fa-solid fa-pen-to-square"></i></a>
				  </div>';
				  
				  // Verifica se $_SESSION['privilegio'] è uguale a "0"
				  if ($_SESSION['privilegio'] == "0") {
					  echo '<div class="col"><a class="btn btn-danger btn-action btn-elimina" role="button" onclick="confirmDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></a></div>';
				  }

				  echo '<div class="col">
					<a class="btn btn-secondary btn-action btn-stampa" href="plugins/print_modulistica.php?assistenza_id='.$row['id_assistenza'].'" id="print_modulistica" data-id="'.$row['id_assistenza'].'" target="_blank"><i class="fa-solid fa-print"></i></a>
				  </div>';
				  
				if (!($_SESSION['privilegio'] == '1' && ($row['stato'] == '0' || $row['stato'] == '2'))) {
					echo '<div class="col">
							  <a class="btn btn-success btn-action btn-esegui" role="button" data-bs-toggle="modal" data-bs-target="#modal_esegui_diagnosi" data-button="'.$row['id'].'" data-psw="'.$row['account_microsoft'].'" data-stato="'.$row['stato'].'"><i class="fa-solid fa-file-invoice-dollar"></i></a>
						  </div>';
				} else {
					echo '<div class="col">
					
						  </div>';
				}
				  
				  echo '<div class="col">
					<a class="btn btn-secondary btn-action" href="plugins/print_diagnosi.php?assistenza_id='.$row['id'].'" id="print_diagnosi" data-id="'.$row['id'].'" target="_blank"><i class="fa-solid fa-print"></i></a>
				  </div>
			  </td>
			  </tr>';
		}

		echo '      </tbody>
				</table>
			</div>';
	} else {
		echo '<div class="container mt-4">
				<h1 class="mt-5 text-center">Nessuna assistenza in lavorazione.</h1>
				</div>';
	}

	if(isset($_GET['printModulistica'])) {
		$id = $_GET["printModulistica"];
		echo '<script>
				window.onload = function() {
					printPDF("' . $id . '");
				};
			  </script>';
	}


	// Modal dettagli assistenza
	include('pages/modal_dettagli_assistenza.php');

	// Modal modifica assistenza
	include('pages/modal_modifica_assistenza.php');

	// Modal esegui diagnosi
	include('pages/modal_esegui_diagnosi.php');
	
	// Toast alert
	include('pages/toastAlert.php');
?>

	
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>

/*var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, option)
})*/

$('#modal_dettagli_assistenza').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var assistenzaId = idBtn.data('button');
	var nominativo = idBtn.data('nominativo');

    $.ajax({
        url: 'ajax/getAssistenzaInfo.php',
        type: 'POST',
        data: { assistenza_id: assistenzaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_dettagli_assistenza').find('#id_assistenza_badge').text("# " + data.id_assistenza);
			
			if (data.priorita == "ALTA") {
				$('#modal_dettagli_assistenza').find('#id_assistenza_badge').removeClass('bg-primary').addClass('bg-danger');
			} else {
				$('#modal_dettagli_assistenza').find('#id_assistenza_badge').removeClass('bg-danger').addClass('bg-primary');
			}
			
            $('#modal_dettagli_assistenza').find('#nome').text(nominativo);
            $('#modal_dettagli_assistenza').find('#email').text(data.email);
            $('#modal_dettagli_assistenza').find('#telefono').text(data.telefono);
			$('#modal_dettagli_assistenza').find('#tipo_dispositivo').text(data.tipo_dispositivo);
            $('#modal_dettagli_assistenza').find('#salvataggio_dati').text(data.salvataggio_dati);
            $('#modal_dettagli_assistenza').find('#account_microsoft').text(data.account_microsoft);
            $('#modal_dettagli_assistenza').find('#materiale_aggiuntivo').text(data.materiale_aggiuntivo);
			$('#modal_dettagli_assistenza').find('#descrizione_problemi').text(data.descrizione_problemi);
			$('#modal_dettagli_assistenza').find('#dettagliModalLabel').text("Dettagli assistenza " + data.data_inserimento);
        }
    });
});

$('#modal_modifica_assistenza').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var assistenzaId = idBtn.data('button');
	
	$('#modal_modifica_assistenza').find('#modifica_assistenza').attr('data-id', idBtn.data('button'));

    $.ajax({
        url: 'ajax/getAssistenzaInfo.php',
        type: 'POST',
        data: { assistenza_id: assistenzaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_modifica_assistenza').find('#id_assistenza_badge').text("# " + data.id_assistenza);
			
			if (data.priorita == "ALTA") {
				$('#modal_modifica_assistenza').find('#id_assistenza_badge').removeClass('bg-primary').addClass('bg-danger');
			} else {
				$('#modal_modifica_assistenza').find('#id_assistenza_badge').removeClass('bg-danger').addClass('bg-primary');
			}
			
			$('#modal_modifica_assistenza').find('#priorita').val(data.priorita);
            $('#modal_modifica_assistenza').find('#nome').text("");
            $('#modal_modifica_assistenza').find('#email').text(data.email);
            $('#modal_modifica_assistenza').find('#telefono').text(data.telefono);
			$('#modal_modifica_assistenza').find('#tipo_dispositivo').val(data.tipo_dispositivo);
            $('#modal_modifica_assistenza').find('#salvataggio_dati').val(data.salvataggio_dati);
            $('#modal_modifica_assistenza').find('#account_microsoft').text(data.account_microsoft);
            $('#modal_modifica_assistenza').find('#materiale_aggiuntivo').text(data.materiale_aggiuntivo);
			$('#modal_modifica_assistenza').find('#descrizione_problemi').text(data.descrizione_problemi);
			$('#modal_modifica_assistenza').find('#dettagliModalLabel').text("Modifica assistenza " + data.data_inserimento);
        }
    });
});

$('#modal_esegui_diagnosi').on('show.bs.modal', function (e) {
	
	//Pulisci tutte le tabelle
	clearPreventiviTable();
	clearLavorazioniTable();
	
    var idBtn = $(e.relatedTarget);
    var assistenzaId = idBtn.data('button');
	var statoAss = idBtn.data('stato');
	var psw = idBtn.data('psw');
	
	$('#modal_esegui_diagnosi').find('#completa_assistenza').attr('data-id', idBtn.data('button'));
	$('#modal_esegui_diagnosi').find('#salva_assistenza').attr('data-id', idBtn.data('button'));
	$('#modal_esegui_diagnosi').find('#salva_assistenza').attr('data-stato', idBtn.data('stato'));
	
	    $.ajax({
        url: 'ajax/getDiagnosiInfo.php',
        type: 'POST',
        data: { assistenza_id: assistenzaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);

			$('#modal_esegui_diagnosi').find('#id_assistenza_badge').text("# " + data.id_assistenza);
			
			if (data.priorita == "ALTA") {
				$('#modal_esegui_diagnosi').find('#id_assistenza_badge').removeClass('bg-primary').addClass('bg-danger');
			} else {
				$('#modal_esegui_diagnosi').find('#id_assistenza_badge').removeClass('bg-danger').addClass('bg-primary');
			}
			
			$('#modal_esegui_diagnosi').find('#p_n').val(data.p_n);
            $('#modal_esegui_diagnosi').find('#s_n').val(data.s_n);
            $('#modal_esegui_diagnosi').find('#note_diagnosi').val(data.note);
			
			autoAddPreventiviFromString(data.preventivo);
			
			autoAddLavorazioniFromString(data.lavorazioni);
			
			switch (statoAss) {
				case 0: // ATTESA PREVENTIVO
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').addClass('d-flex').show();
					$('#modal_esegui_diagnosi').find('#account_password_text').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#account_password_text').val(psw);
					
					
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').hide();
					$('#modal_esegui_diagnosi').find('#tabellaLavorazioni').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi_label').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').hide();
					$('#modal_esegui_diagnosi').find('#salva_assistenza').show();
					$('#modal_esegui_diagnosi').find('#totalePreventiviRow').show();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').addClass('d-flex').show();
					$('#modal_esegui_diagnosi').find('#salva_assistenza').show();
					
					var btnCompletaPreventivo = $('<button>', {
						type: 'button',
						class: 'btn btn-success',
						id: 'completa_assistenza',
						name: 'completa_assistenza',
						text: 'Completa preventivo',
						click: function() {
							salvaAssistenza(1,0,0,1);
						}
					});
					// Trova il padre del bottone esistente e sostituiscilo con il nuovo bottone
					$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
					$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
					break;
				case 1: // CONTATTARE CLIENTE
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').show();
					$('#modal_esegui_diagnosi').find('#p_n').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#s_n').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivo').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').hide();
					$('#modal_esegui_diagnosi').find('#tabellaLavorazioni').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi_label').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').hide();
					$('#modal_esegui_diagnosi').find('#totalePreventiviRow').show();
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
					
					
					$('#tabellaPreventivi input').prop('readonly', true);
					$('#tabellaPreventivi .rimuoviPreventivo').remove();
					
					$('#modal_esegui_diagnosi').find('#salva_assistenza').hide();
					
					var btnCompletaPreventivo = $('<button>', {
						type: 'button',
						class: 'btn btn-success',
						id: 'completa_assistenza',
						name: 'completa_assistenza',
						text: 'Cliente contattato',
						click: function() {
							salvaAssistenza(2,0,1,1);
						}
					});
					// Trova il padre del bottone esistente e sostituiscilo con il nuovo bottone
					$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
					$('#modal_esegui_diagnosi').find('#completa_assistenza').hide();
					break;
				case 2: // IN LAVORAZIONE
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
					$('#tabellaPreventivi input').prop('readonly', true);
					//$('#tabellaLavorazioni input').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#totalePreventiviRow').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
					
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').addClass('d-flex').show();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
					$('#tabellaPreventivi .rimuoviPreventivo').remove();
					$('#modal_esegui_diagnosi').find('#salva_assistenza').show();
					
					var btnCompletaPreventivo = $('<button>', {
						type: 'button',
						class: 'btn btn-success',
						id: 'completa_assistenza',
						name: 'completa_assistenza',
						text: 'Completa lavorazione',
						click: function() {
							salvaAssistenza(3,0,1,1);
						}
					});
					// Trova il padre del bottone esistente e sostituiscilo con il nuovo bottone
					$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
					$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
					break;
					
				case 3: // CONTATTARE PER CONSEGNA
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
					$('#modal_esegui_diagnosi').find('#p_n').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#s_n').prop('readonly', true);
					$('#tabellaPreventivi input').prop('readonly', true);
					$('#tabellaPreventivi .rimuoviPreventivo').remove();
					$('#tabellaLavorazioni input').prop('readonly', true);
					$('#tabellaLavorazioni .rimuoviLavorazione').remove();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivo').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').hide();
					$('#modal_esegui_diagnosi').find('#totalePreventiviRow').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
					
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
					
					$('#modal_esegui_diagnosi').find('#salva_assistenza').hide();
					
					var btnCompletaPreventivo = $('<button>', {
						type: 'button',
						class: 'btn btn-success',
						id: 'completa_assistenza',
						name: 'completa_assistenza',
						text: 'Cliente contattato',
						click: function() {
							salvaAssistenza(4,0,1,1);
						}
					});
					// Trova il padre del bottone esistente e sostituiscilo con il nuovo bottone
					$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
					$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
					break;

				case 4: // ATTESA RITIRO
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
					$('#modal_esegui_diagnosi').find('#p_n').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#s_n').prop('readonly', true);
					$('#tabellaPreventivi input').prop('readonly', true);
					$('#tabellaPreventivi .rimuoviPreventivo').remove();
					$('#tabellaLavorazioni input').prop('readonly', true);
					$('#tabellaLavorazioni .rimuoviLavorazione').remove();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivo').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').hide();
					$('#modal_esegui_diagnosi').find('#totalePreventiviRow').hide();
					$('#modal_esegui_diagnosi').find('#note_diagnosi').prop('readonly', true);
					$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
					
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
					
					$('#modal_esegui_diagnosi').find('#salva_assistenza').hide();
					
					var btnCompletaPreventivo = $('<button>', {
						type: 'button',
						class: 'btn btn-success',
						id: 'completa_assistenza',
						name: 'completa_assistenza',
						text: 'Completa assistenza',
						click: function() {
							salvaAssistenza(5,1,1,1);
						}
					});
					// Trova il padre del bottone esistente e sostituiscilo con il nuovo bottone
					$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
					$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
					break;
				case 5: // COMPLETATO
					$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
					$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
					$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
					
					$('#modal_esegui_diagnosi').find('#salva_assistenza').hide();
					break;
				default:
					console.error('statoAss non gestito:', statoAss);
					break;
			}
        }
    });
});

$('#rifiutaPreventivo').on('click', function() {
	addDefaultLavorazione();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').show();
	$('#modal_esegui_diagnosi').find('#tabellaLavorazioni').show();
	$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
	$('#modal_esegui_diagnosi').find('#totalePreventiviRow').hide();
	$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
	
	var btnCompletaPreventivo = $('<button>', {
		type: 'button',
		class: 'btn btn-success',
		id: 'completa_assistenza',
		name: 'completa_assistenza',
		text: 'Completa assistenza',
		click: function() {
			salvaAssistenza(4,0,1,1);
		}
	});
	
	$('#completa_assistenza').replaceWith(btnCompletaPreventivo);
	$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').addClass('d-flex').show();
});

$('#accettaPreventivo').on('click', function() {
	addLavorazioniFromPreventivi();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').show();
	$('#modal_esegui_diagnosi').find('#tabellaLavorazioni').show();
	$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
	$('#modal_esegui_diagnosi').find('#totalePreventiviRow').hide();
	$('#modal_esegui_diagnosi').find('#completa_assistenza').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').addClass('d-flex').show();
});

// Aggiungi un gestore per l'evento hidden.bs.modal
$('#modal_esegui_diagnosi').on('hidden.bs.modal', function () {
	// Ripristina gli stati dei campi del modal quando viene chiuso
	$('#modal_esegui_diagnosi').find('#p_n').prop('readonly', false);
	$('#modal_esegui_diagnosi').find('#s_n').prop('readonly', false);
	$('#modal_esegui_diagnosi').find('#note_diagnosi').prop('readonly', false);
	$('#modal_esegui_diagnosi').find('#aggiungiPreventivo').show();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazione').show();
	$('#modal_esegui_diagnosi').find('#tabellaLavorazioni').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi_label').show();
	$('#modal_esegui_diagnosi').find('#note_diagnosi').show();
	
	$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').hide();
	$('#modal_esegui_diagnosi').find('#btnAccettazionePreventivo').hide();
	$('#modal_esegui_diagnosi').find('#account_password_esegui_diagnosi').removeClass('d-flex').hide();
	$('#modal_esegui_diagnosi').find('#aggiungiLavorazioneRow').removeClass('d-flex').hide();
	$('#modal_esegui_diagnosi').find('#aggiungiPreventivoRow').removeClass('d-flex').hide();
	
	// Rimuovi il gestore per l'evento hidden.bs.modal in modo da non ripristinare più volte
	//$('#modal_esegui_diagnosi').off('hidden.bs.modal');
});

$('#salva_assistenza').on('click', function() {
	var stato = $('#modal_esegui_diagnosi').find('#salva_assistenza').data('stato');
	salvaAssistenza(stato, 0, 0, 0);
});

function salvaAssistenza(statoAss, stampa, inserisciData, alertFlag){
	var assistenzaId = $('#salva_assistenza').data('id');
	var pn = $('#modal_esegui_diagnosi').find('#p_n').val();
	var sn = $('#modal_esegui_diagnosi').find('#s_n').val();
	var preventivoAss = getPreventiviAsString();
	var lavorazioniAss = getLavorazioniAsString();
	var noteAss = $('#modal_esegui_diagnosi').find('#note_diagnosi').val();
	var costoTotale = $('#modal_esegui_diagnosi').find('#totaleCosti').text();

	$.ajax({
		url: 'ajax/editDiagnosi.php',
		type: 'POST',
	    data: {
		  assistenza_id: assistenzaId,
		  p_n: pn,
		  s_n: sn,
		  preventivi: preventivoAss,
		  lavorazioni: lavorazioniAss,
		  note: noteAss,
		  costo_totale: costoTotale,
		  stato: statoAss,
		  inserisci_data: inserisciData
	    },
		dataType: 'html',
		success: function(data) {
			console.log(data);
			
			// Cookie per l'alert
			if(alertFlag == 0){
				document.cookie = "displayToast=salvataggio-assistenza";
			} else {
				document.cookie = "displayToast=cambio-stato";
			}
			
			if(stampa==0){
				location.reload();
			}else{
				$('a#print_diagnosi[data-id="' + assistenzaId + '"]')[0].click();
				location.reload();
			}
		},
		error: function(xhr, status, error) {
			console.log(data);
			console.error(error);
	    }
    });
}

$('#modifica_assistenza').on('click', function() {
	var assistenzaId = $('#modifica_assistenza').data('id');
	var prioritaAss = $('#modal_modifica_assistenza').find('#priorita').val();
	var tipoDispositivo = $('#modal_modifica_assistenza').find('#tipo_dispositivo').val();
	var salvataggioDati = $('#modal_modifica_assistenza').find('#salvataggio_dati').val();
	var accountMicrosoft = $('#modal_modifica_assistenza').find('#account_microsoft').val();
	var materialeAggiuntivo = $('#modal_modifica_assistenza').find('#materiale_aggiuntivo').val();
	var descrizioneProblemi = $('#modal_modifica_assistenza').find('#descrizione_problemi').val();
	
	$.ajax({
	url: 'ajax/editAssistenza.php',
	type: 'POST',
    data: {
	  assistenza_id: assistenzaId,
	  priorita: prioritaAss,
	  tipo_dispositivo: tipoDispositivo,
	  salvataggio_dati: salvataggioDati,
	  account_microsoft: accountMicrosoft,
	  materiale_aggiuntivo: materialeAggiuntivo,
	  descrizione_problemi: descrizioneProblemi
    },
	dataType: 'json',
	success: function(data) {
			console.log(data);
			
			// Cookie per l'alert
			document.cookie = "displayToast=modifica";
			
			location.reload();
		}
    });
});

function confirmDelete(assistenzaId) {
    var result = confirm("Sei sicuro di voler eliminare questa assistenza?");
    if (result) {
        // Se l'utente conferma, esegui l'eliminazione
        deleteAssistenza(assistenzaId);
    }
}

function deleteAssistenza(assistenzaId) {
   $.ajax({
      url: 'ajax/deleteAssistenza.php',
      type: 'POST',
      data: { assistenza_id: assistenzaId },
      success: function(response) {
		  
			// Cookie per l'alert
			document.cookie = "displayToast=eliminazione";
		  
		  location.reload();
      },
      error: function(error) {
         console.error('Errore durante l\'eliminazione dell\'assistenza:', error);
      }
   });
}

function printPDF(assistenzaId) {
	var nuovaURL = window.location.href.split('?')[0];
	history.replaceState({}, document.title, nuovaURL);
	
	$('a#print_modulistica[data-id="' + assistenzaId + '"]')[0].click();
}

tippy('.btn-dettagli', {
	content: 'Visualizza dettagli',
});

tippy('.btn-modifica', {
	content: 'Modifica assistenza',
});

tippy('.btn-elimina', {
	content: 'Elimina assistenza',
});

tippy('.btn-stampa', {
	content: 'Stampa modulistica',
});

tippy('.btn-esegui', {
	content: 'Esegui diagnosi',
});

</script>

</body>
</html>