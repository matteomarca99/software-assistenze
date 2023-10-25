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

	require_once "sql/getNumAssistenzeByStato.php";
	
	require_once "sql/getNoteAziendali.php";
	
	// Modal modifica note
	include('pages/modal_modifica_note.php');
	
	$note = getNoteAziendali();

	$assistenze = getNumAssistenzeByStato();
	
	echo '<div class="container mt-4 text-center">
			<h1 class="mb-5">Home</h1>';
	
	foreach ($assistenze as $row) {

    $stato = $row['stato'];
    $numeroAssistenze = $row['numero_assistenze'];

    switch ($stato) {
        case 0:
            $nomeStato = '<span class="badge rounded-pill bg-warning badge-stato"> ATTESA PREVENTIVO </span>';
            break;
        case 1:
            $nomeStato = '<span class="badge rounded-pill bg-primary badge-stato"> CONTATTARE CLIENTE </span>';
            break;
        case 2:
            $nomeStato = '<span class="badge rounded-pill bg-secondary badge-stato"> IN LAVORAZIONE </span>';
            break;
        case 3:
            $nomeStato = '<span class="badge rounded-pill bg-primary badge-stato"> CONTATTARE PER CONSEGNA </span>';
            break;
        case 4:
            $nomeStato = '<span class="badge rounded-pill bg-info badge-stato"> ATTESA RITIRO </span>';
            break;
        case 5:
            $nomeStato = 'COMPLETATO';
            break;
        default:
            $nomeStato = 'STATO SCONOSCIUTO';
            break;
    }

    echo '
	
	
	
	<h5> Hai ' . $numeroAssistenze . ' assistenze in ' . $nomeStato . '</h5><br>
	
	
	';
}
	
?>

<a class="btn btn-success" role="button" href="lista_assistenze.php"> Gestisci assistenze <i class="fa-regular fa-rectangle-list"></i></a>

<h1 class="mt-5 mb-5">Note aziendali</h1>

<?php

	foreach ($note as $row) {

		echo '<h5 style="white-space: pre-wrap;"> ' . $row["testo"] . '</h5><br>';

    }
	
	if ($_SESSION['privilegio'] == "0"){
		echo '<a class="btn btn-success" role="button" data-bs-toggle="modal" data-bs-target="#modal_modifica_note" data-id="' . $row["id"] . '" id="btnModificaNota" name="btnModificaNota"> Modifica nota <i class="fa-solid fa-pen-to-square"></i></a>';
	}
?>
</div>

	
	
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script>

$('#modal_modifica_note').on('show.bs.modal', function (e) {
    var idBtn = $(e.relatedTarget);
    var notaId = idBtn.data('id');

    $.ajax({
        url: 'ajax/getNota.php',
        type: 'POST',
        data: { nota_id: notaId },
		dataType: 'json',
        success: function(data) {
			console.log(data);
			$('#modal_modifica_note').find('#testo_note').text(data.testo);
        }
    });
});

$('#modifica_nota').on('click', function() {
	var notaId = $('#btnModificaNota').data('id');
	var testoNota = $('#modal_modifica_note').find('#testo_note').val();
	
	$.ajax({
	url: 'ajax/editNota.php',
	type: 'POST',
    data: {
	  nota_id: notaId,
	  testo: testoNota
    },
	dataType: 'json',
	success: function(data) {
			console.log(data);
			location.reload();
		}
    });
});

</script>

</body>
</html>