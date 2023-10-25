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

	require_once "sql/addCliente.php";
	require_once "sql/addAssistenza.php";

	if (!empty($_POST["nome"]) || !empty($_POST["clienteEsistenteSelect"])) {
		
		$nome = $_POST['nome'];
		$cognome = $_POST['cognome'];
		$email = $_POST['email'];
		$telefono = $_POST['telefono'];
		
		$tipo_dispositivo = $_POST['tipo_dispositivo'];
		$formattazione_richiesta = $_POST['formattazione_richiesta'];
		$account_psw = $_POST['account_psw'];
		$priorita = $_POST['priorita'];
		
		$materiale_aggiuntivo = $_POST['materiale_aggiuntivo'];
		$descrizione_problemi = $_POST['descrizione_problemi'];

		// Se il cliente non esiste allora lo aggiungiamo
		if(empty($_POST["clienteEsistenteSelect"])) {
			$idCliente = addCliente($nome,$cognome,$email,$telefono);
		} else {
			// Altrimenti esiste già e ne prendiamo l'id
			$idCliente = $_POST['clienteEsistenteSelect'];
		}
		
		// Aggiunta dell'assistenza
		$param_id_assistenza = addAssistenza($idCliente, $tipo_dispositivo, $formattazione_richiesta, $account_psw, $materiale_aggiuntivo, $descrizione_problemi, "0", $priorita);
		
		header('Location: index.php?printModulistica=' . $param_id_assistenza);
		
	}
?>

<div class="container mt-5">
    <form method="post" id="assistenza">
	
		<?php
			if(isset($_GET['clienteEsistente']) && $_GET['clienteEsistente'] == 'false'){
				// STEP 1.a => DATI CLIENTE NON ESISTENTE
				echo '
					<div class="form-step" id="step1">
					<h1>Dati cliente</h1>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="nome" class="form-label">Nome<span style="color:red">*</label>
									<input type="text" class="form-control" id="nome" name="nome" required>
								</div>
							</div>
							<div class="col">
								<div class="mb-3">
									<label for="cognome" class="form-label">Cognome<span style="color:red">*</label>
									<input type="text" class="form-control" id="cognome" name="cognome" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="mb-3">
									<label for="email" class="form-label">Email</label>
									<input type="text" class="form-control" id="email" name="email">
								</div>
							</div>
							<div class="col">
								<div class="mb-3">
									<label for="telefono" class="form-label">Telefono<span style="color:red">*</label>
									<input type="text" class="form-control" id="telefono" name="telefono" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary w-100" onclick="nextStep()">Avanti</button>
						</div>
					</div>';
			} else {
				// STEP 1.b => DATI CLIENTE ESISTENTE
				echo '
					<div class="form-step" id="step1">
						<h1>Dati cliente</h1>
						<div class="row">
							<div class="col">
								<div class="mb-3">';

									require_once "sql/getClienteData.php";

									$clienteData = getClienteData();

									if (!empty($clienteData)) {
										echo '<label for="clienteEsistenteSelect">Seleziona Cliente:</label>';
										echo '<select id="clienteEsistenteSelect" name="clienteEsistenteSelect" class="form-select">';
										foreach ($clienteData as $cliente) {
											echo '<option value="'.$cliente['id'].'">'.$cliente['nome']." ".$cliente['cognome'].'</option>';
										}
										echo '</select>';
									} else {
										echo "Nessun risultato trovato";
									}
									
									echo '
									
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary w-100" onclick="nextStep()">Avanti</button>
						</div>
					</div>';
			}
		?>
				
		<!-- STEP 2 => DATI DISPOSITIVO -->
        <div class="form-step" id="step2" style="display: none;">
		<h1>Dati dispositivo</h1>
			<div class="row">
				<div class="col">
					<div class="mb-3">
						<label for="tipo_dispositivo" class="form-label">Tipo dispositivo<span style="color:red">*</label>
						<select class="form-select" aria-label="tipo_dispositivo" id="tipo_dispositivo" name="tipo_dispositivo">
						  <option selected value="U-RIG">U-RIG</option>
						  <option value="PC ASSEMBLATO">PC ASSEMBLATO</option>
						  <option value="NOTEBOOK">NOTEBOOK</option>
						  <option value="CONSOLE E ACCESSORI">CONSOLE E ACCESSORI</option>
						  <option value="SMARTPHONE O TABLET">SMARTPHONE O TABLET</option>
						  <option value="PERIFERICHE (spec.)">PERIFERICHE (spec.)</option>
						  <option value="STAMPANTE">STAMPANTE</option>
						  <option value="HDD ESTERNO">HDD ESTERNO</option>
						  <option value="ALTRO">ALTRO</option>
						</select>
					</div>
				</div>
				<div class="col">
					<div class="mb-3">
						<label for="formattazione_richiesta" class="form-label">Salvataggio dati richiesto dal cliente?</label>
						<select class="form-select" aria-label="formattazione_richiesta" id="formattazione_richiesta" name="formattazione_richiesta">
						  <option selected value="NO">NO</option>
						  <option value="SI">SI</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="mb-3">
						<label for="account_psw" class="form-label">Account Microsoft e password</label>
						<input type="text" class="form-control" id="account_psw" name="account_psw">
					</div>
				</div>
				<div class="col">
					<div class="mb-3">
						<label for="priorita" class="form-label">Priorita'</label>
						<select class="form-select" aria-label="priorita" id="priorita" name="priorita">
						  <option selected value="NORMALE">NORMALE</option>
						  <option value="ALTA">ALTA</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="mb-3">
					<label for="materiale_aggiuntivo" class="form-label">Materiale aggiuntivo</label>
					<textarea class="form-control" id="materiale_aggiuntivo" name="materiale_aggiuntivo"></textarea>
				</div>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary w-100" onclick="nextStep()">Avanti</button>
			</div>
        </div>
		
		<!-- STEP 3 => DESCRIZIONE PROBLEMI -->
		<div class="form-step" id="step3" style="display: none;">
			<h1>Descrizione problemi</h1>
			<div class="row">
				<div class="col">
					<div class="mb-3">
						<textarea class="form-control" id="descrizione_problemi" name="descrizione_problemi"></textarea>
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary w-100" value="Submit">Avanti</button>
			</div>
		</div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

	$(document).ready(function() {
		$('#clienteEsistenteSelect').select2();
	});

	let currentStep = 1;

	function validateStep(step) {
		const requiredFields = document.querySelectorAll(`#step${step} [required]`);

		for (const field of requiredFields) {
			if (!field.value) {
				alert("Devi compilare tutti i campi prima di passare allo step successivo.");
				return false;
			}
		}

		return true;
	}

	function nextStep() {
		if (validateStep(currentStep)) {
			const currentStepElement = document.getElementById(`step${currentStep}`);
			const nextStepElement = document.getElementById(`step${currentStep + 1}`);

			if (currentStepElement && nextStepElement) {
				currentStepElement.style.display = "none";
				nextStepElement.style.display = "block";
				currentStep++;
			}
		}
	}

</script>

</body>
</html>