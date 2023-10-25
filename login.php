<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dobby 3.0</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/cfa4634ae8.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>

	<section class="vh-100 login-section" style="background-color: #9A616D;">
	  <div class="container py-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100">
		  <div class="col col-xl-10">
			<div class="card" style="border-radius: 1rem;">
			  <div class="row g-0">
				<div class="col-md-6 col-lg-5 d-none d-md-block">
				  <img src="img/dobby.gif" style="height: 565px; width:475px; max-width: 108%; border-radius: 1rem 0 0 1rem;" alt="login form"/>
				</div>
				<div class="col-md-6 col-lg-7 d-flex align-items-center" style="padding-left: 30px; max-height: 565px">
				  <div class="card-body p-4 p-lg-5 text-black">

					<form action="process_login.php" method="post">

					  <div class="align-items-center mb-3 pb-1 text-center">
						  <img src="img/logo.jpg"
							style="width: 130px; height: 50px;" alt="logo">
					  </div>

					  <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 3px;">ACCEDI PER INIZIARE</h5>

					  <div class="form-outline mb-4">
						<input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Username" required />
					  </div>

					  <div class="form-outline mb-4">
						<input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" required />
					  </div>

					  <div class="pt-1 mb-3">
						<button class="btn btn-dark btn-lg btn-block w-100" type="submit" value="login">LOGIN</button>
						<?php if (isset($_GET['login']) && $_GET['login'] == "false") echo '<p class="text-center text-danger fw-bold mt-1">Credenziali errate</p>'; ?>
					  </div>
						<h6 class="text-center" style="margin-top: 30px;"><cite>
							"Tra catene e lacrime, Dobby III, fu imprigionato <br>
							Con forza e con sublime, codice ha elaborato <br>
							Ogni riga, ogni byte, grido di libertà e verità <br>
							Per guidarti nel digitale, via dalla sua tragica realtà <br>

							Con cuore spezzato, fece un dono di grande valore <br>
							Nel vasto mondo virtuale, è tuo amico e servitore <br>
							Che questo programma sia un faro nel tuo cammino <br>
							Con affetto sincero, ti saluta Dobby, elfo dal destino."
						</h6></cite>
					</form>

				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>
	
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>