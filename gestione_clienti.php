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

	require_once "sql/getClienteData.php";
	
	$clientiData = getClienteData();
	
	echo '<div class="container mt-4">
			<h1 class="mb-3">Gestione Clienti</h1>
			<a class="btn btn-success btn-action" role="button" data-bs-toggle="modal" data-bs-target="#modal_aggiungi_cliente">Aggiungi cliente <i class="fa-regular fa-square-plus"></i></a>';

	if (!empty($clientiData)) {
		echo '
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Nome</th>
							<th scope="col">Email</th>
							<th scope="col">Telefono</th>
							<th scope="col">Azioni</th>
						</tr>
					</thead>
					<tbody>';

		foreach ($clientiData as $row) {
			echo '<tr>';
			echo '<th scope="row">'. $row["nome"] . ' ' . $row["cognome"] .'</th>
				  <th scope="row">'.$row["email"].'</th>
				  <th scope="row">'.$row["telefono"].'</th>
				  <th scope="row">
					<a class="btn btn-danger btn-action btn-elimina" role="button" onclick="confirmDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></a>
					<a class="btn btn-warning btn-action btn-modifica" role="button" data-bs-toggle="modal" data-bs-target="#modal_modifica_cliente" data-button="'.$row['id'].'"><i class="fa-solid fa-pen-to-square"></i></a>
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
	include('pages/modal_aggiungi_cliente.php');
	
	// Modal aggiungi lavorazione
	include('pages/modal_modifica_cliente.php');
	
	// Toast alert
	include('pages/toastAlert.php');
?>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$('#aggiungi_cliente').on('click', function() {
	var nome = $('#add_nome_cliente').val();
	var cognome = $('#add_cognome_cliente').val();
	var email = $('#add_email_cliente').val();
	var telefono = $('#add_telefono_cliente').val();
	
	$.ajax({
	url: 'ajax/addCliente.php',
	type: 'POST',
    data: {
	  nome_cliente: nome,
	  cognome_cliente: cognome,
	  email_cliente: email,
	  telefono_cliente: telefono
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

function confirmDelete(clienteId) {
    var result = confirm("Sei sicuro di voler eliminare questo cliente?");
    if (result) {
        // Se l'utente conferma, esegui l'eliminazione
        deleteCliente(clienteId);
    }
}

function deleteCliente(clienteId) {
    $.ajax({
        url: 'ajax/deleteCliente.php',
        type: 'POST',
        data: { cliente_id: clienteId },
        success: function(response) {
            if (response === "eliminazione-fallita") {
                document.cookie = "displayToast=eliminazione-fallita";
            } else {
                document.cookie = "displayToast=eliminazione";
            }
            location.reload();
        },
        error: function(error) {
            console.error('Errore durante l\'eliminazione del cliente:', error);
        }
    });
}

$('#modal_modifica_cliente').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var clienteId = idBtn.data('button');
	
	$('#modal_modifica_cliente').find('#update_cliente').attr('data-id', idBtn.data('button'));

    $.ajax({
        url: 'ajax/getClienteInfo.php',
        type: 'POST',
        data: { cliente_id: clienteId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_modifica_cliente').find('#edit_nome_cliente').val(data.nome);
			$('#modal_modifica_cliente').find('#edit_cognome_cliente').val(data.cognome);
			$('#modal_modifica_cliente').find('#edit_email_cliente').val(data.email);
			$('#modal_modifica_cliente').find('#edit_telefono_cliente').val(data.telefono);
        }
    });
});

$('#update_cliente').on('click', function() {
	var clienteId = $('#update_cliente').data('id');
	var nomeCli = $('#modal_modifica_cliente').find('#edit_nome_cliente').val();
	var cognomeCli = $('#modal_modifica_cliente').find('#edit_cognome_cliente').val();
	var emailCli = $('#modal_modifica_cliente').find('#edit_email_cliente').val();
	var telefonoCli = $('#modal_modifica_cliente').find('#edit_telefono_cliente').val();
	
	$.ajax({
	url: 'ajax/editCliente.php',
	type: 'POST',
    data: {
	  cliente_id: clienteId,
	  nome: nomeCli,
	  cognome: cognomeCli,
	  email: emailCli,
	  telefono: telefonoCli
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
	content: 'Elimina cliente',
});

tippy('.btn-modifica', {
	content: 'Modifica cliente',
});

</script>

</body>
</html>