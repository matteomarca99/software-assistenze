<!-- Modal esegui diagnosi -->
<div class="modal fade" id="modal_esegui_diagnosi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eseguiDignosiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="eseguiDignosiModalLabel">Esegui diagnosi</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- DATI DIAGNOSI -->
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
					<h6 class="my-0 pt-2">P/N</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="p_n" name="p_n">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">S/N</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="s_n" name="s_n">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3" id="account_password_esegui_diagnosi" name="account_password_esegui_diagnosi">
				  <div>
					<h6 class="my-0 pt-2">Account/Password</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="account_password_text" name="account_password_text">
				</li>
			  </ul>
			   
				<div class="d-flex flex-row" id="aggiungiPreventivoRow" name="aggiungiPreventivoRow">
					<button id="aggiungiPreventivo" name="aggiungiPreventivo" class="btn btn-primary d-inline me-1">Aggiungi preventivo</button>
					<input type="text" class="form-control w-auto d-inline" id="nome_preventivo" name="nome_preventivo" placeholder="Cerca preventivo...">
				</div>
				<div id="suggerimenti_preventivi" class="list-group mt-1"></div>
				
				<!-- TABELLA PREVENTIVI -->
				<div class="table-responsive">
					<table id="tabellaPreventivi" class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Nome Preventivo</th>
								<th scope="col">Quantità</th>
								<th scope="col">Costo</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<!-- Qui verranno inserite le righe dinamicamente -->
						</tbody>
						<tfoot>
							<tr id="totalePreventiviRow">
								<td colspan="2"></td>
								<td class="fw-bold">Totale</td>
								<td id="totaleCostiPreventivi" name="totaleCostiPreventivi" class="fw-bold">0.00 €</td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<div id="btnAccettazionePreventivo" class="text-center">
					<button id="accettaPreventivo" class="btn btn-success me-2">Preventivo accettato</button>
					<button id="rifiutaPreventivo" class="btn btn-danger">Preventivo rifiutato</button>
				</div>
				
				<div class="d-flex flex-row" id="aggiungiLavorazioneRow" name="aggiungiLavorazioneRow">
					<button id="aggiungiLavorazione" class="btn btn-primary d-inline me-1">Aggiungi lavorazione</button>
					<input type="text" class="form-control w-auto d-inline" id="nome_lavorazione" name="nome_lavorazione" placeholder="Cerca lavorazione...">
				</div>
				<div id="suggerimenti_lavorazioni" class="list-group mt-1"></div>
				
				<!-- TABELLA LAVORAZIONI -->
				<div class="table-responsive">
				  <table id="tabellaLavorazioni" class="table">
					<thead class="thead-dark">
					  <tr>
						<th scope="col">Nome Lavorazione</th>
						<th scope="col">Quantità</th>
						<th scope="col">Costo</th>
						<th scope="col"></th>
					  </tr>
					</thead>
					<tbody>
					  <!-- Qui verranno inserite le righe dinamicamente -->
					</tbody>
					<tfoot>
						<tr id="totaleLavorazioniRow">
							<td colspan="2"></td>
							<td class="fw-bold">Totale</td>
							<td id="totaleCostiLavorazioni" name="totaleCostiLavorazioni" class="fw-bold">0.00 €</td>
						</tr>
					</tfoot>
				  </table>
				</div>
				
				<h6 class="p-3 fw-bold" id="note_diagnosi_label">Note:</h6>
				<textarea class="form-control" id="note_diagnosi" name="note_diagnosi"></textarea>
				
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="completa_assistenza" name="completa_assistenza" data-bs-dismiss="modal">Completa assistenza <i class="fa-regular fa-square-check"></i></button>
			<button type="button" class="btn btn-success" id="salva_assistenza" name="salva_assistenza" data-bs-dismiss="modal">Salva <i class="fa-regular fa-floppy-disk"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>

<script>

// SUGGERIMENTI PER LAVORAZIONI
document.getElementById('nome_lavorazione').addEventListener('input', function() {
    var searchTerm = this.value.toLowerCase();
    if (searchTerm.length >= 2) {
        // Utilizza AJAX per ottenere i suggerimenti dal tuo backend
        // Assicurati di implementare il codice lato server che restituisce i suggerimenti
        // e che la risposta sia nel formato corretto (ad esempio, JSON)
        
        // Esempio di utilizzo di jQuery per AJAX:
        $.ajax({
            url: 'sql/get_suggerimenti_lavorazioni.php',
            type: 'GET',
            data: { searchTerm: searchTerm },
            success: function(response) {
                displaySuggestionsLavorazioni(response);
            },
            error: function(error) {
                console.error('Errore durante il recupero dei suggerimenti:', error);
            }
        });
    } else {
        // Nascondi l'elenco dei suggerimenti quando la lunghezza del termine di ricerca è inferiore a 2
        document.getElementById('suggerimenti_lavorazioni').innerHTML = '';
    }
});

// SUGGERIMENTI PER LAVORAZIONI
function displaySuggestionsLavorazioni(suggestions) {
    var suggerimentiContainer = document.getElementById('suggerimenti_lavorazioni');
	var searchContainer = document.getElementById('nome_lavorazione');
    suggerimentiContainer.innerHTML = '';

    suggestions.forEach(function(suggerimento) {
        var suggerimentoElement = document.createElement('button');
        suggerimentoElement.classList.add('list-group-item', 'list-group-item-action', 'btn-suggerimento');
        suggerimentoElement.textContent = suggerimento.nome;

        suggerimentoElement.addEventListener('click', function() {		
			var costo = suggerimento.costo.replace(',', '.');
			var lavorazione = 'Nome: ' + suggerimento.nome + ', Quantità: 1, Costo: ' + costo + '\n';
			autoAddLavorazioniFromString(lavorazione);
			suggerimentiContainer.innerHTML = '';
			searchContainer.value = '';
			
        });

        suggerimentiContainer.appendChild(suggerimentoElement);
    });
}

// SUGGERIMENTI PER PREVENTIVI
document.getElementById('nome_preventivo').addEventListener('input', function() {
    var searchTerm = this.value.toLowerCase();
    if (searchTerm.length >= 2) {
        // Utilizza AJAX per ottenere i suggerimenti dal tuo backend
        // Assicurati di implementare il codice lato server che restituisce i suggerimenti
        // e che la risposta sia nel formato corretto (ad esempio, JSON)
        
        // Esempio di utilizzo di jQuery per AJAX:
        $.ajax({
            url: 'sql/get_suggerimenti_lavorazioni.php',
            type: 'GET',
            data: { searchTerm: searchTerm },
            success: function(response) {
                displaySuggestionsPreventivi(response);
            },
            error: function(error) {
                console.error('Errore durante il recupero dei suggerimenti:', error);
            }
        });
    } else {
        // Nascondi l'elenco dei suggerimenti quando la lunghezza del termine di ricerca è inferiore a 2
        document.getElementById('suggerimenti_preventivi').innerHTML = '';
    }
});

// SUGGERIMENTI PER PREVENTIVI
function displaySuggestionsPreventivi(suggestions) {
    var suggerimentiContainer = document.getElementById('suggerimenti_preventivi');
	var searchContainer = document.getElementById('nome_preventivo');
    suggerimentiContainer.innerHTML = '';

    suggestions.forEach(function(suggerimento) {
        var suggerimentoElement = document.createElement('button');
        suggerimentoElement.classList.add('list-group-item', 'list-group-item-action', 'btn-suggerimento');
        suggerimentoElement.textContent = suggerimento.nome;

        suggerimentoElement.addEventListener('click', function() {		
			var costo = suggerimento.costo.replace(',', '.');
			var preventivo = 'Nome: ' + suggerimento.nome + ', Quantità: 1, Costo: ' + costo + '\n';
			autoAddPreventiviFromString(preventivo);
			suggerimentiContainer.innerHTML = '';
			searchContainer.value = '';
			
        });

        suggerimentiContainer.appendChild(suggerimentoElement);
    });
}

	// Funzione per rimuovere un preventivo
	function removePreventivo(button) {
		var row = button.closest('tr');
		row.remove();
		updateTotalCostPreventivi();
	}
	
	// Funzione per rimuovere un preventivo
	function removeLavorazione(button) {
		var row = button.closest('tr');
		row.remove();
		updateTotalCostLavorazioni();
	}

	// Aggiungi evento all'input per il calcolo del costo
	document.getElementById('tabellaPreventivi').addEventListener('input', function(e) {
		var target = e.target;
		if (target.classList.contains('quantitaPreventivo') || target.classList.contains('costoPreventivo')) {
			updateTotalCostPreventivi();
		}
	});
	
	// Aggiungi evento all'input per il calcolo del costo
	document.getElementById('tabellaLavorazioni').addEventListener('input', function(e) {
		var target = e.target;
		if (target.classList.contains('quantitaLavorazione') || target.classList.contains('costoLavorazione')) {
			updateTotalCostLavorazioni();
		}
	});

	// Aggiungi evento ai bottoni "Rimuovi"
	document.getElementById('tabellaPreventivi').addEventListener('click', function(e) {
		var target = e.target;
		if (target.classList.contains('rimuoviPreventivo')) {
			removePreventivo(target);
		}
	});
	
	// Aggiungi evento ai bottoni "Rimuovi"
	document.getElementById('tabellaLavorazioni').addEventListener('click', function(e) {
		var target = e.target;
		if (target.classList.contains('rimuoviLavorazione')) {
			removeLavorazione(target);
		}
	});

	// Aggiungi evento al pulsante "Aggiungi preventivo"
	document.getElementById('aggiungiPreventivo').addEventListener('click', function() {
		var table = document.getElementById('tabellaPreventivi').getElementsByTagName('tbody')[0];
		var newRow = table.insertRow(table.rows.length);

		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1);
		var cell3 = newRow.insertCell(2);
		var cell4 = newRow.insertCell(3);

		cell1.innerHTML = '<input type="text" class="nomePreventivo">';
		cell2.innerHTML = '<input type="number" class="quantitaPreventivo" value="1">';
		cell3.innerHTML = '<input type="number" class="costoPreventivo" step="0.01">';
		cell4.innerHTML = '<button class="rimuoviPreventivo btn btn-danger">Rimuovi</button>';

		updateTotalCostPreventivi();
	});
	
	// Aggiungi automticamente righe alla tabella preventivo
	function autoAddPreventiviFromString(preventiviString) {
		var preventiviArray = preventiviString.split('\n').filter(Boolean);

		preventiviArray.forEach(function(preventivoString) {
			var preventivoData = preventivoString.split(',').reduce(function(obj, item) {
				var parts = item.trim().split(':');
				obj[parts[0].trim()] = parts[1].trim();
				return obj;
			}, {});

			var table = document.getElementById('tabellaPreventivi').getElementsByTagName('tbody')[0];
			var newRow = table.insertRow(table.rows.length);

			var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);
			var cell4 = newRow.insertCell(3);

			cell1.innerHTML = '<input type="text" class="nomePreventivo" value="' + preventivoData.Nome + '">';
			cell2.innerHTML = '<input type="number" class="quantitaPreventivo" value="' + preventivoData.Quantità + '">';
			cell3.innerHTML = '<input type="number" class="costoPreventivo" step="0.01" value="' + preventivoData.Costo + '">';
			cell4.innerHTML = '<button class="rimuoviPreventivo btn btn-danger">Rimuovi</button>';
		});

		updateTotalCostPreventivi();
	};
	
	// Aggiungi automticamente righe alla tabella lavorazioni
	function autoAddLavorazioniFromString(lavorazioniString) {
		var lavorazioniArray = lavorazioniString.split('\n').filter(Boolean);

		lavorazioniArray.forEach(function(lavorazioniString) {
			var lavorazioniData = lavorazioniString.split(',').reduce(function(obj, item) {
				var parts = item.trim().split(':');
				obj[parts[0].trim()] = parts[1].trim();
				return obj;
			}, {});

			var table = document.getElementById('tabellaLavorazioni').getElementsByTagName('tbody')[0];
			var newRow = table.insertRow(table.rows.length);

			var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);
			var cell4 = newRow.insertCell(3);

			cell1.innerHTML = '<input type="text" class="nomeLavorazione" value="' + lavorazioniData.Nome + '">';
			cell2.innerHTML = '<input type="number" class="quantitaLavorazione" value="' + lavorazioniData.Quantità + '">';
			cell3.innerHTML = '<input type="number" class="costoLavorazione" step="0.01" value="' + lavorazioniData.Costo + '">';
			cell4.innerHTML = '<button class="rimuoviLavorazione btn btn-danger">Rimuovi</button>';
		});

		updateTotalCostLavorazioni();
	};


	// Funzione per aggiornare il costo totale
	function updateTotalCostPreventivi() {
		var totaleCosti = 0;
		var costi = document.getElementsByClassName('costoPreventivo');
		var quantita = document.getElementsByClassName('quantitaPreventivo');

		for (var i = 0; i < costi.length; i++) {
			var costo = parseFloat(costi[i].value) || 0;
			var qty = parseInt(quantita[i].value) || 0;
			totaleCosti += costo * qty;
		}

		document.getElementById('totaleCostiPreventivi').textContent = totaleCosti.toFixed(2) + " €";
	}

	function updateTotalCostLavorazioni() {
		var totaleCosti = 0;
		var costi = document.getElementsByClassName('costoLavorazione');
		var quantita = document.getElementsByClassName('quantitaLavorazione');

		for (var i = 0; i < costi.length; i++) {
			var costo = parseFloat(costi[i].value) || 0;
			var qty = parseInt(quantita[i].value) || 0;
			totaleCosti += costo * qty;
		}

		document.getElementById('totaleCostiLavorazioni').textContent = totaleCosti.toFixed(2) + " €";
	}
</script>

<script>
  document.getElementById('aggiungiLavorazione').addEventListener('click', function() {
    var table = document.getElementById('tabellaLavorazioni').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.rows.length);

    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
	var cell4 = newRow.insertCell(3);

    cell1.innerHTML = '<input type="text" class="nomeLavorazione">';
    cell2.innerHTML = '<input type="number" class="quantitaLavorazione" value="1">';
	cell3.innerHTML = '<input type="number" class="costoLavorazione" step="0.01">';
    cell4.innerHTML = '<button class="btn btn-danger rimuoviLavorazione">Rimuovi</button>';
	
	updateTotalCostLavorazioni();
  });
  
function getPreventiviAsString() {
    var table = document.getElementById('tabellaPreventivi');
    var rows = table.getElementsByTagName('tr');
    var preventiviString = '';

    for (var i = 1; i < rows.length - 1; i++) {
        var cells = rows[i].getElementsByTagName('td');
        if (cells.length > 0) {
            var nomePreventivoInput = cells[0].getElementsByTagName('input')[0];
            var quantitaInput = cells[1].getElementsByTagName('input')[0];
            var costoInput = cells[2].getElementsByTagName('input')[0];

            if (nomePreventivoInput && quantitaInput && costoInput) {
                var nomePreventivo = nomePreventivoInput.value;
                var quantita = quantitaInput.value;
                var costo = costoInput.value;

                preventiviString += 'Nome: ' + nomePreventivo + ', Quantità: ' + quantita + ', Costo: ' + costo + '\n';
            } else {
                console.error('Elemento input mancante in una riga di preventivo.');
            }
        }
    }

    return preventiviString;
}

function getLavorazioniAsString() {
    var table = document.getElementById('tabellaLavorazioni');
    var rows = table.getElementsByTagName('tr');
    var lavorazioniString = '';

    for (var i = 1; i < rows.length - 1; i++) {
        var cells = rows[i].getElementsByTagName('td');
        if (cells.length > 0) {
            var nomeLavorazioneInput = cells[0].getElementsByTagName('input')[0];
            var quantitaInput = cells[1].getElementsByTagName('input')[0];
            var costoInput = cells[2].getElementsByTagName('input')[0];

            if (nomeLavorazioneInput && quantitaInput && costoInput) {
                var nomeLavorazione = nomeLavorazioneInput.value;
                var quantita = quantitaInput.value;
                var costo = costoInput.value;

                lavorazioniString += 'Nome: ' + nomeLavorazione + ', Quantità: ' + quantita + ', Costo: ' + costo + '\n';
            } else {
                console.error('Elemento input mancante in una riga di preventivo.');
            }
        }
    }

    return lavorazioniString;
}

function addDefaultLavorazione() {
    var default_lavorazione = 'Nome: Diagnosi, Quantità: 1, Costo: 29.99\n';

	autoAddLavorazioniFromString(default_lavorazione);
	
	updateTotalCostLavorazioni();
}

function addLavorazioniFromPreventivi() {
    var lavorazioni = getPreventiviAsString();

	autoAddLavorazioniFromString(lavorazioni);
	
	updateTotalCostLavorazioni();
}

function clearPreventiviTable() {
    var table = document.getElementById('tabellaPreventivi').getElementsByTagName('tbody')[0];
    table.innerHTML = '';
    updateTotalCostPreventivi();
}

function clearLavorazioniTable() {
    var table = document.getElementById('tabellaLavorazioni').getElementsByTagName('tbody')[0];
    table.innerHTML = '';
	updateTotalCostLavorazioni();
}

</script>