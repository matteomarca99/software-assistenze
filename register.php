<?php

include('login_required.php');

require_once "db/conn.php"; // Connessione al database

include('pages/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
	$privilegio = $_POST['privilegio'];

    // Cifra la password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Esegue una query per inserire l'utente nel database
    $query = "INSERT INTO utenti (username, password, privilegio) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $privilegio);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php"); // Reindirizza all'area riservata
    } else {
        header("Location: register.php?success=false");
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dobby 3.0</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://kit.fontawesome.com/cfa4634ae8.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container mt-5">
		<h1>Registrazione</h1>
		<form action="register.php" method="post">
			<label for="username" class="form-label">Username:</label>
			<input type="text" class="form-control" id="username" name="username" required><br>

			<label for="password" class="form-label">Password:</label>
			<input type="password" id="password" class="form-control" name="password" required><br>
			
			<label for="privilegio" class="form-label">Privilegio:</label>
			<select class="form-select" id="privilegio" name="privilegio">
			  <option value="1" selected>UTENTE</option>
			  <option value="0">AMMINISTRATORE</option>
			</select>
			
			<div class="form-group mt-4">
				<button type="submit" class="btn btn-primary w-100">Aggiungi utente</button>
			</div>
		</form>
	</div>
	
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
</body>
</html>
