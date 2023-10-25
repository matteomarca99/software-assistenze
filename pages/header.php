<nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		  <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Nuova assistenza
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="nuova_assistenza.php?clienteEsistente=true">Cliente esistente</a></li>
			<li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="nuova_assistenza.php?clienteEsistente=false">Cliente non esistente</a></li>
          </ul>
        </li>
		<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="lista_assistenze.php"><i class="fa-solid fa-list-ol"></i> Lista assistenze</a>
        </li>
		<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="storico_assistenze.php"><i class="fa-solid fa-list-check"></i> Storico assistenze</a>
        </li>
		<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="gestione_agenda.php"><i class="fa-solid fa-book"></i> Agenda aziendale</a>
        </li>
		 <?php if($_SESSION['privilegio'] == "0")
			 echo'
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Menu
				  </a>
				  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<li><a class="dropdown-item" href="register.php">Nuovo utente</a></li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="gestione_clienti.php">Gestione Clienti</a></li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="gestione_lavorazioni.php">Gestione lavorazioni</a></li>
				  </ul>
				</li>';
		 ?>
      </ul>
	  <span class="navbar-text fw-bold text-white messaggio-benvenuto me-3">
        Benvenuto <?php echo $_SESSION['username']; ?>
      </span>
	  <a class="btn btn-danger btn-sm" role="button" href="logout.php">LOGOUT <i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
  </div>
</nav>