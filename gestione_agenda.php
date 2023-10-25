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

	require_once "sql/getAgendaData.php";
	
	$agendaData = getAgendaData();
	
	echo '<div class="container mt-4">
			<h1 class="mb-3">Gestione Agenda</h1>
			<a class="btn btn-success btn-action" role="button" data-bs-toggle="modal" data-bs-target="#modal_aggiungi_nota">Aggiungi nota <i class="fa-regular fa-square-plus"></i></a>';

	if (!empty($agendaData)) {
		echo '
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Nome</th>
							<th scope="col">Azioni</th>
						</tr>
					</thead>
					<tbody>';

		foreach ($agendaData as $row) {
			echo '<tr>';
			echo '<th scope="row">'. $row["nome"] . '</th>
				  <th scope="row">
					<a class="btn btn-primary btn-action btn-dettagli" role="button" data-bs-toggle="modal" data-bs-target="#modal_visualizza_nota_agenda" data-button="'.$row['id'].'"><i class="fa-solid fa-eye"></i></a>
					';
					if($_SESSION['privilegio'] == "0") {
						echo '<a class="btn btn-danger btn-action btn-elimina" role="button" onclick="confirmDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></a>
							 <a class="btn btn-warning btn-action btn-modifica" role="button" data-bs-toggle="modal" data-bs-target="#modal_modifica_nota_agenda" data-button="'.$row['id'].'"><i class="fa-solid fa-pen-to-square"></i></a>';
					}
				  echo '</th>
				  </tr>';
		}

		echo '      </tbody>
				</table>';
	} else {
		echo '<h1 class="mt-5 text-center">Nessuna nota.</h1>';
	}
	
	echo '</div>';
	
	// Modal visulizza nota
	include('pages/modal_visualizza_nota_agenda.php');
	
	// Modal aggiungi nota
	include('pages/modal_aggiungi_nota.php');
	
	// Modal modifica nota
	include('pages/modal_modifica_nota_agenda.php');
	
	// Toast alert
	include('pages/toastAlert.php');
?>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$('#aggiungi_nota').on('click', function() {
	var nome = $('#add_nome_nota').val();
	var testo = $('#add_testo_nota').val();
	
	$.ajax({
	url: 'ajax/addNotaAgenda.php',
	type: 'POST',
    data: {
	  nome_nota: nome,
	  testo_nota: testo
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

function confirmDelete(notaId) {
    var result = confirm("Sei sicuro di voler eliminare questa nota?");
    if (result) {
        // Se l'utente conferma, esegui l'eliminazione
        deleteNota(notaId);
    }
}

function deleteNota(notaId) {
    $.ajax({
        url: 'ajax/deleteNotaAgenda.php',
        type: 'POST',
        data: { nota_id: notaId },
        success: function(response) {
			document.cookie = "displayToast=eliminazione";
            location.reload();
        },
        error: function(error) {
            console.error('Errore durante l\'eliminazione della nota:', error);
        }
    });
}

$('#modal_visualizza_nota_agenda').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var notaId = idBtn.data('button');

    $.ajax({
        url: 'ajax/getNotaAgendaInfo.php',
        type: 'POST',
        data: { nota_id: notaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_visualizza_nota_agenda').find('#show_nome_nota').val(data.nome);
			$('#modal_visualizza_nota_agenda').find('#show_testo_nota').val(data.testo);
        }
    });
});

$('#modal_modifica_nota_agenda').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var notaId = idBtn.data('button');
	
	$('#modal_modifica_nota_agenda').find('#update_nota').attr('data-id', idBtn.data('button'));

    $.ajax({
        url: 'ajax/getNotaAgendaInfo.php',
        type: 'POST',
        data: { nota_id: notaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_modifica_nota_agenda').find('#edit_nome_nota').val(data.nome);
			$('#modal_modifica_nota_agenda').find('#edit_testo_nota').val(data.testo);
        }
    });
});

$('#update_nota').on('click', function() {
	var notaId = $('#update_nota').data('id');
	var nomeNota = $('#modal_modifica_nota_agenda').find('#edit_nome_nota').val();
	var testoNota = $('#modal_modifica_nota_agenda').find('#edit_testo_nota').val();
	
	$.ajax({
	url: 'ajax/editNotaAgenda.php',
	type: 'POST',
    data: {
	  nota_id: notaId,
	  nome: nomeNota,
	  testo: testoNota
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

tippy('.btn-dettagli', {
	content: 'Visulizza nota',
});

tippy('.btn-elimina', {
	content: 'Elimina nota',
});

tippy('.btn-modifica', {
	content: 'Modifica nota',
});

</script>

</body>
</html>