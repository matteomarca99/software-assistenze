<!-- Modal Modifica Assistenza -->
<div class="modal fade" id="modal_modifica_assistenza" tabindex="-1" aria-labelledby="modificaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Modifica assistenza</h5>
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
					<h6 class="my-0">Priorita'</h6>
				  </div>
					<select class="form-select w-auto" aria-label="priorita" id="priorita" name="priorita">
					  <option selected value="NORMALE">NORMALE</option>
					  <option value="ALTA">ALTA</option>
					</select>
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0">Tipo dispositivo</h6>
				  </div>
						<select class="form-select w-auto" aria-label="tipo_dispositivo" id="tipo_dispositivo" name="tipo_dispositivo">
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
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0">Salvataggio dati</h6>
				  </div>
					<select class="form-select w-auto" aria-label="salvataggio_dati" id="salvataggio_dati" name="salvataggio_dati">
					  <option selected value="NO">NO</option>
					  <option value="SI">SI</option>
					</select>
				</li>
			  </ul>
				<h6 class="p-3 text-center" id="account_microsoft_label">Account Microsoft</h6>
				<textarea class="form-control" id="account_microsoft" name="account_microsoft"></textarea>
				<h6 class="p-3 text-center" id="materiale_aggiuntivo_label">Materiale aggiuntivo</h6>
				<textarea class="form-control" id="materiale_aggiuntivo" name="materiale_aggiuntivo"></textarea>
				<h6 class="p-3 text-center" id="descrizione_problemi_label">Descrizione problemi</h6>
				<textarea class="form-control" id="descrizione_problemi" name="descrizione_problemi"></textarea>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="modifica_assistenza" name="modifica_assistenza" data-bs-dismiss="modal">Salva <i class="fa-regular fa-floppy-disk"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>