<!-- Modal Aggiungi Cliente -->
<div class="modal fade" id="modal_aggiungi_cliente" tabindex="-1" aria-labelledby="aggiungiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Aggiungi cliente</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- DATI CLIENTE -->
			<div class="container mt-2">
				<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Nome</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_nome_cliente" name="add_nome_cliente">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Cognome</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_cognome_cliente" name="add_cognome_cliente">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Email</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_email_cliente" name="add_email_cliente">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Telefono</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_telefono_cliente" name="add_telefono_cliente">
				</li>
			  </ul>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="aggiungi_cliente" name="aggiungi_cliente" data-bs-dismiss="modal">Aggiungi <i class="fa-regular fa-square-plus"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>