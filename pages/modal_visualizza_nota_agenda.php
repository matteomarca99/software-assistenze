<!-- Modal Visualizza Nota Azienda -->
<div class="modal fade" id="modal_visualizza_nota_agenda" tabindex="-1" aria-labelledby="modificaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="dettagliModalLabel">Visualizza nota</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  </div>
	  <div class="modal-body" style="word-wrap: break-word;">
		<!-- TESTO NOTA -->
			<div class="container mt-2">
				<input type="text" class="form-control w-100 mb-3" id="show_nome_nota" name="show_nome_nota" readonly>
				<textarea class="form-control" id="show_testo_nota" name="show_testo_nota" rows="20" cols="40" readonly></textarea>
			</div>
	  </div>
	  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
	  </div>
	</div>
  </div>
</div>