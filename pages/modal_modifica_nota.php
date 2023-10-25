<!-- Modal Modifica Nota -->
<div class="modal fade" id="modal_modifica_nota" tabindex="-1" aria-labelledby="modificaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Modifica nota</h5>
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
				  <input type="text" class="form-control w-auto" id="edit_nome_nota" name="edit_nome_nota">
				</li>
				<li class="list-group-item d-flex justify-content-between lh-condensed p-3">
				  <div>
					<h6 class="my-0 pt-2">Testo</h6>
				  </div>
				  <input type="text" class="form-control w-auto" id="edit_testo_nota" name="edit_testo_nota">
				</li>
			  </ul>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="modifica_nota" name="modifica_nota" data-bs-dismiss="modal">Salva <i class="fa-regular fa-floppy-disk"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>