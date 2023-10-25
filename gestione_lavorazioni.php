<?php include('login_required.php'); ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dobby 3.0</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://kit.fontawesome.com/cfa4634ae8.js" crossorigin="anonymous"></script>
</head>
<body>

<?php

	include('pages/header.php');

	require_once "sql/getLavorazioniData.php";
	
	$lavorazioniData = getLavorazioniData();
	
	echo '<div class="container mt-4">
			<h1 class="mb-3">Gestione lavorazioni</h1>
			<a class="btn btn-success btn-action" role="button" data-bs-toggle="modal" data-bs-target="#modal_aggiungi_lavorazione">Aggiungi lavorazione <i class="fa-regular fa-square-plus"></i></a>';

	if (!empty($lavorazioniData)) {
		echo '
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Nome</th>
							<th scope="col">Costo</th>
							<th scope="col">Azioni</th>
						</tr>
					</thead>
					<tbody>';

		foreach ($lavorazioniData as $row) {
			echo '<tr>';
			echo '<th scope="row">'. $row["nome"] . '</th>
				  <th scope="row">'.$row["costo"].'</th>
				  <th scope="row">
					<a class="btn btn-danger btn-action btn-elimina" role="button" onclick="confirmDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></a>
					<a class="btn btn-warning btn-action btn-modifica" role="button" data-bs-toggle="modal" data-bs-target="#modal_modifica_lavorazione" data-button="'.$row['id'].'"><i class="fa-solid fa-pen-to-square"></i></a>
				  </th>
				  </tr>';
		}

		echo '      </tbody>
				</table>';
	} else {
		echo '<h1 class="mt-5 text-center">Nessuna lavorazione.</h1>';
	}
	
	echo '</div>';
	
	// Modal aggiungi lavorazione
	include('pages/modal_aggiungi_lavorazione.php');
	
	// Modal aggiungi lavorazione
	include('pages/modal_modifica_lavorazione.php');
	
	// Toast alert
	include('pages/toastAlert.php');
?>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$('#aggiungi_lavorazione').on('click', function() {
	var nome = $('#add_nome_lavorazione').val();
	var costo = $('#add_costo_lavorazione').val();
	
	$.ajax({
	url: 'ajax/addLavorazione.php',
	type: 'POST',
    data: {
	  nome_lavorazione: nome,
	  costo_lavorazione: costo
    },
	dataType: 'html',
	success: function(data) {
			console.log(data);
			
			// Cookie per l'alert
			document.cookie = "displayToast=aggiungere";
			
			location.reload();
		}
    });
});

function confirmDelete(lavorazioneId) {
    var result = confirm("Sei sicuro di voler eliminare questa lavorazione?");
    if (result) {
        // Se l'utente conferma, esegui l'eliminazione
        deleteLavorazione(lavorazioneId);
    }
}

function deleteLavorazione(lavorazioneId) {
   $.ajax({
      url: 'ajax/deleteLavorazione.php',
      type: 'POST',
      data: { lavorazione_id: lavorazioneId },
      success: function(response) {
		// Cookie per l'alert
		document.cookie = "displayToast=eliminazione";
			
		location.reload();
      },
      error: function(error) {
         console.error('Errore durante l\'eliminazione della lavorazione:', error);
      }
   });
}

$('#modal_modifica_lavorazione').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var lavorazioneId = idBtn.data('button');
	
	$('#modal_modifica_lavorazione').find('#update_lavorazione').attr('data-id', idBtn.data('button'));

    $.ajax({
        url: 'ajax/getLavorazioneInfo.php',
        type: 'POST',
        data: { lavorazione_id: lavorazioneId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_modifica_lavorazione').find('#edit_nome_lavorazione').val(data.nome);
			$('#modal_modifica_lavorazione').find('#edit_costo_lavorazione').val(data.costo);
        }
    });
});

$('#update_lavorazione').on('click', function() {
	var lavorazioneId = $('#update_lavorazione').data('id');
	var nomeLav = $('#modal_modifica_lavorazione').find('#edit_nome_lavorazione').val();
	var costoLav = $('#modal_modifica_lavorazione').find('#edit_costo_lavorazione').val();
	
	$.ajax({
	url: 'ajax/editLavorazione.php',
	type: 'POST',
    data: {
	  lavorazione_id: lavorazioneId,
	  nome: nomeLav,
	  costo: costoLav
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

tippy('.btn-elimina', {
	content: 'Elimina lavorazione',
});

tippy('.btn-modifica', {
	content: 'Modifica lavorazione',
});

</script>

</body>
</html>