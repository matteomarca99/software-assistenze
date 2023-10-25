<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
  <div id="toastAlert" name="toastAlert" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
    <div class="toast-header">
      
      <strong class="me-auto toast-title">Eliminazione</strong>
      <small class="toast-time">11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Eliminzione avvenuta con successo.
    </div>
  </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    var displayToastValue = getCookieValue('displayToast');

    switch(displayToastValue) {
        case 'eliminazione':
            // Elimino il cookie
            document.cookie = "displayToast=eliminazione; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Eliminazione", "Eliminazione avvenuta con successo.", "#CEEDD5", "#00630f", "#000000", "#ffffff", "#ffffff");
            break;
			
		case 'eliminazione-fallita':
            // Elimino il cookie
            document.cookie = "displayToast=eliminazione; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Eliminazione fallita", "Il cliente ha delle assistenze associate.", "#f58787", "#fa4343", "#000000", "#ffffff", "#ffffff");
            break;
        
        case 'modifica':
            // Elimino il cookie
            document.cookie = "displayToast=modifica; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Modifica", "Modifica avvenuta con successo.", "#CEEDD5", "#00630f", "#000000", "#ffffff", "#ffffff");
            break;
			
		case 'cambio-stato':
            // Elimino il cookie
            document.cookie = "displayToast=cambio-stato; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Stato", "Stato cambiato con successo.", "#CEEDD5", "#00630f", "#000000", "#ffffff", "#ffffff");
            break;
			
		case 'salvataggio-assistenza':
            // Elimino il cookie
            document.cookie = "displayToast=salvataggio-assistenza; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Salvataggio", "L'assistenza è stata salvata con successo.", "#CEEDD5", "#00630f", "#000000", "#ffffff", "#ffffff");
            break;
			
		case 'aggiungere':
            // Elimino il cookie
            document.cookie = "displayToast=aggiungere; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // E mostro l'alert
            showToast("Aggiunto", "Aggiunta avvenuta con successo.", "#CEEDD5", "#00630f", "#000000", "#ffffff", "#ffffff");
            break;

        default:
            // Gestisci altri casi se necessario
            // ...
            break;
    }
});

function showToast(title, body, backgroundColor, headerColor, bodyTextColor, headerTextColor, timeTextColor) {
	
	var toastElement = document.getElementById('toastAlert');
	
	// Imposta il testo del titolo
	toastElement.querySelector('.toast-title').textContent = title;
	
	// Imposta la data
	var currentTime = getCurrentTime();
	toastElement.querySelector('.toast-time').textContent = currentTime;

	// Imposta il testo del corpo
	toastElement.querySelector('.toast-body').textContent = body;
	
	// Aggiungi colori personalizzati
	toastElement.style.backgroundColor = backgroundColor;
	toastElement.querySelector('.toast-header').style.backgroundColor = headerColor;
	
	// Modifica il colore del testo dell'header, del corpo e del tempo se i parametri sono forniti
	if (bodyTextColor) {
		toastElement.querySelector('.toast-body').style.color = bodyTextColor;
	}
	
	if (headerTextColor) {
		toastElement.querySelector('.toast-header').style.color = headerTextColor;
	}
	if(timeTextColor) {
		toastElement.querySelector('.toast-time').style.color = timeTextColor;
	}
	
	var myToast = new bootstrap.Toast(toastElement);
	myToast.show();
}


function getCurrentTime() {
  var now = new Date();
  var hours = now.getHours().toString().padStart(2, '0'); // Ottiene le ore e assicura che siano su due cifre
  var minutes = now.getMinutes().toString().padStart(2, '0'); // Ottiene i minuti e assicura che siano su due cifre

  return hours + ':' + minutes;
}

function getCookieValue(name) {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim().split('=');
        if (cookie[0] === name) {
            return cookie[1];
        }
    }
    return '';
}

</script>