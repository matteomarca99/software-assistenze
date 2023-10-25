<!-- Modal Aggiungi Lavorazione -->
<div class="modal fade" id="modal_aggiungi_lavorazione" tabindex="-1" aria-labelledby="aggiungiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Aggiungi lavorazione</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- DATI LAVORAZIONE -->
			<div class="container mt-2">
				<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Nome Lavorazione</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_nome_lavorazione" name="nome_lavorazione">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Costo lavorazione</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="add_costo_lavorazione" name="costo_lavorazione">
				</li>
			  </ul>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="aggiungi_lavorazione" name="aggiungi_lavorazione" data-bs-dismiss="modal">Aggiungi <i class="fa-regular fa-square-plus"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>