<!-- Modal Modifica Nota Azienda -->
<div class="modal fade" id="modal_modifica_nota_agenda" tabindex="-1" aria-labelledby="modificaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Modifica note</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- TESTO NOTA -->
			<div class="container mt-2">
				<input type="text" class="form-control w-100 mb-3" id="edit_nome_nota" name="edit_nome_nota">
				<textarea class="form-control" id="edit_testo_nota" name="edit_testo_nota" rows="20" cols="40"></textarea>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="update_nota" name="update_nota" data-bs-dismiss="modal">Salva <i class="fa-regular fa-floppy-disk"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>