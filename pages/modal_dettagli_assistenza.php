<!-- Modal Dettagli Assistenza -->
<div class="modal fade" id="modal_dettagli_assistenza" tabindex="-1" aria-labelledby="dettagliModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Dettagli assistenza</h5>
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