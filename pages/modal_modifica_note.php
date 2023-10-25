<!-- Modal Modifica Assistenza -->
<div class="modal fade" id="modal_modifica_note" tabindex="-1" aria-labelledby="modificaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Modifica note</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- TESTO NOTA -->
			<div class="container mt-2">
				<textarea class="form-control" id="testo_note" name="testo_note" rows="20" cols="40"></textarea>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="modifica_nota" name="modifica_nota" data-bs-dismiss="modal">Salva <i class="fa-regular fa-floppy-disk"></i></button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>