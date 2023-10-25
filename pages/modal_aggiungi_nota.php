<!-- Modal Aggiungi Nota -->
<div class="modal fade" id="modal_aggiungi_nota" tabindex="-1" aria-labelledby="aggiungiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Aggiungi nota</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- DATI NOTA -->
			<div class="container mt-2">
				<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Nome</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_nome_nota" name="add_nome_nota">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div class="w-100">
					<h6 class="my-0 pt-2 mb-4">Testo</h6>
					<textarea class="form-control w-100" id="add_testo_nota" name="add_testo_nota" rows="20" cols="40"></textarea>
				  </div>
				</li>
				</li>
			  </ul>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="aggiungi_nota" name="aggiungi_nota" data-bs-dismiss="modal">Aggiungi <i class="fa-regular fa-square-plus"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>