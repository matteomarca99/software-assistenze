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
		
		$assistenzaData = getAssistenzaData([5]);
		
		 if (!empty($assistenzaData)) {
			echo '<div class="container mt-4">
					<h1 class="mb-3">Storico assistenze</h1>
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
				echo '<tr>
						<th scope="row">'.$valid_date.'</th>
						<th scope="row"><span class="badge rounded-pill bg-primary" id="id_assistenza"># '.$row["id_assistenza"].'</span></th>
						<th scope="row">'.$row["nominativo"].'</th>
						<td>'.$row["tipo_dispositivo"].'</td>
						<td><span class="badge rounded-pill bg-success badge-stato">COMPLETATO <i class="fa-solid fa-circle-check"></i></span></td>
						<td>
							<a class="btn btn-primary btn-dettagli" href="#" role="button" data-bs-toggle="modal" data-bs-target="#dettagliModal" data-button="'.$row['id'].'" data-nominativo="'.$row['nominativo'].'"><i class="fa-solid fa-eye"></i></a>
							<a class="btn btn-secondary btn-stampa" href="plugins/print_diagnosi.php?assistenza_id='.$row['id'].'" id="print_diagnosi_completata" data-id="'.$row['id'].'" target="_blank"><i class="fa-solid fa-print"></i></a>
							<a class="btn btn-warning btn-aggiungi-allegato" href="#" role="button" data-bs-toggle="modal" data-bs-target="#aggiungiAllegatoModal" data-button="'.$row['idDiagnosi'].'"><i class="fa-solid fa-paperclip"></i></a>
						</td>
					  </tr>';
			}

			echo '      </tbody>
					</table>
				</div>';
		} else {
			echo '<div class="container mt-4">
					<h1 class="mt-5 text-center">Nessuna assistenza trovata.</h1>
					</div>';
					
		}
		
		if(isset($_GET['printModulistica']) && $_GET['printModulistica'] == 'true') {
			echo '<script>
					window.onload = function() {
						printPDF("print/modulo_stampa_1.pdf");
					};
				  </script>';
		}
    ?>
	
	<!-- Modal -->
	<div class="modal fade" id="dettagliModal" tabindex="-1" aria-labelledby="dettagliModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="dettagliModalLabel"></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body" style="word-wrap: break-word;">
			<!-- DATI CLIENTE -->
				<div class="container mt-2">
					<ul class="list-group mb-3">
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">ID assistenza</h6>
					  </div>
					  <span class="badge rounded-pill bg-primary" id="id_assistenza_badge"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Nome cliente</h6>
					  </div>
					  <span class="text-muted" id="nome"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Email</h6>
					  </div>
					  <span class="text-muted" id="email"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Telefono</h6>
					  </div>
					  <span class="text-muted" id="telefono"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Tipo dispositivo</h6>
					  </div>
					  <span class="text-muted" id="tipo_dispositivo"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Salvataggio dati</h6>
					  </div>
					  <span class="text-muted" id="salvataggio_dati"></span>
					</li>
					<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
					  <div>
						<h6 class="my-0">Account Microsoft</h6>
					  </div>
					  <span class="text-muted" id="account_microsoft"></span>
					</li>
				  </ul>
					<h6 class="p-3 text-center" id="materiale_aggiuntivo_label">Materiale aggiuntivo</h6>
					<div id="materiale_aggiuntivo" class="p-3"></div>
					<h6 class="p-3 text-center" id="descrizione_problemi_label">Descrizione problemi</h6>
					<div id="descrizione_problemi" class="p-3"></div>
				</div>
		  </div>
		  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- Modal Allegato -->
	<div class="modal fade" id="aggiungiAllegatoModal" tabindex="-1" aria-labelledby="allegatoModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="allegatoModalLabel">Allegato Diagnosi</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body" style="word-wrap: break-word;">
			<!-- ALLEGATO -->
				<div class="container mt-2">
					<form id="uploadForm" enctype="multipart/form-data" class="mb-3">
						<input type="hidden" name="id_diagnosi" value="VALORE_ID_DIAGNOSI">
						<input type="file" class="form-control" name="file" id="file">
						<input type="submit" class="btn btn-primary form-control" value="Carica File" name="submit">
					</form>
					<a class="btn btn-danger btn-action btn-elimina w-100" id="eliminaAllegati" name="eliminaAllegati" role="button">Elimina tutti gli allegati <i class="fa-solid fa-trash"></i></a>
				</div>
				<div id="immaginiContainer" class="container mt-2 immaginiContainer"></div>
		  </div>
		  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
		  </div>
		</div>
	  </div>
	</div>


<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>

$(document).ready(function() {
    $('#uploadForm').submit(function(e) {
        e.preventDefault();
		var idDiagnosi = $('[name="id_diagnosi"]').val();
        var formData = new FormData(this);
        formData.append('id_diagnosi', idDiagnosi);

        $.ajax({
            url: 'ajax/upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Gestisci la risposta dal server
                console.log(response);
				location.reload();
            },
            error: function(error) {
                console.error('Errore durante l\'upload del file:', error);
            }
        });
    });
});


$('#dettagliModal').on('show.bs.modal', function (e) {
    var dettagliBtn = $(e.relatedTarget);
    var assistenzaId = dettagliBtn.data('button');
	var nominativo = dettagliBtn.data('nominativo');

    $.ajax({
        url: 'ajax/getAssistenzaInfo.php',
        type: 'POST',
        data: { assistenza_id: assistenzaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
            $('#nome').text(nominativo);
			$('#id_assistenza_badge').text("# " + data.id_assistenza);
            $('#email').text(data.email);
            $('#telefono').text(data.telefono);
			$('#tipo_dispositivo').text(data.tipo_dispositivo);
            $('#salvataggio_dati').text(data.salvataggio_dati);
            $('#account_microsoft').text(data.account_microsoft);
            $('#materiale_aggiuntivo').text(data.materiale_aggiuntivo);
			$('#descrizione_problemi').text(data.descrizione_problemi);
			$('#dettagliModalLabel').text("Dettagli assistenza " + data.id_assistenza);
        }
    });
});

$('#aggiungiAllegatoModal').on('show.bs.modal', function (e) {
    var dettagliBtn = $(e.relatedTarget);
    var diagnosiId = dettagliBtn.data('button');
	
    var inputIdDiagnosi = document.querySelector('input[name="id_diagnosi"]');
	
	$('#eliminaAllegati').attr('data-id', diagnosiId);
	
    // Imposta il valore dell'input
    inputIdDiagnosi.value = diagnosiId;

    // Recupera le immagini associate alla diagnosi corrente
    $.ajax({
        url: 'ajax/recuperaAllegati.php',
        type: 'POST',
        data: { id_diagnosi: diagnosiId },
        success: function(response) {
            // Converti i dati BLOB in URL di immagini e aggiungili al DOM
            var container = $('.immaginiContainer');
			response.forEach(function(file) {
				if (file.mime_type === 'application/pdf') {
					var pdfUrl = 'data:application/pdf;base64,' + file.file_data;
					container.append('<embed src="' + pdfUrl + '" type="application/pdf" width="100%" height="600px"/>');
				} else {
					var imgUrl = 'data:image/' + file.mime_type + ';base64,' + file.file_data;
					container.append('<img src="' + imgUrl + '" class="img-fluid">');
				}
			});
        },
        error: function(error) {
            console.error('Errore durante il recupero delle immagini:', error);
        }
    });
});

$('#aggiungiAllegatoModal').on('hidden.bs.modal', function () {
    var container = document.getElementById('immaginiContainer');
    container.innerHTML = ''; // Svuota il contenitore delle immagini
});

$('#eliminaAllegati').on('click', function() {
	
    var idDiagnosi = $('#eliminaAllegati').data('id');
	
	confirmDelete(idDiagnosi);

});

function confirmDelete(diagnosiId) {
    var result = confirm("Sei sicuro di voler eliminare tutti gli allegati?");
    if (result) {
        // Se l'utente conferma, esegui l'eliminazione
        deleteAllegati(diagnosiId);
    }
}

function deleteAllegati(dignosiId){
	// Recupera le immagini associate alla diagnosi corrente
    $.ajax({
        url: 'ajax/eliminaAllegati.php',
        type: 'POST',
        data: { id_diagnosi: dignosiId },
        success: function(response) {
            location.reload();
        },
        error: function(error) {
            console.error('Errore durante il recupero delle immagini:', error);
        }
    });
}

var printIframe = null;

function printPDF(pdf_path) {
    if (printIframe === null) {
        printIframe = document.createElement('iframe');
        printIframe.style.display = 'none';
        document.body.appendChild(printIframe);
    }

    printIframe.src = pdf_path;

    printIframe.onload = function() {
        printIframe.contentWindow.print();
    };
	
	var nuovaURL = window.location.href.split('?')[0];
	history.replaceState({}, document.title, nuovaURL);
}

tippy('.btn-dettagli', {
	content: 'Visualizza dettagli',
});

tippy('.btn-stampa', {
	content: 'Stampa diagnosi',
});

tippy('.btn-aggiungi-allegato', {
	content: 'Aggiungi allegato',
});

</script>

</body>
</html>