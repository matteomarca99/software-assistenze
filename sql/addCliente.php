<?php
function addCliente($nome, $cognome, $email, $telefono) {
    require_once "db/conn.php";

    $stmt = $conn->prepare("INSERT INTO cliente (nome, cognome, email, telefono) VALUES (?, ?, ?, ?)");
	$stmt->bind_param('ssss', $param_nome, $param_cognome, $param_email, $param_telefono);
	
	$param_nome = $nome;
	$param_cognome = $cognome;
	$param_email = $email;
	$param_telefono = $telefono;
	
	$stmt->execute();
	$id_cliente = $conn->insert_id;
	
	echo "New record created successfully. Last inserted ID is: " . $id_cliente;

    mysqli_close($conn);
	
	return $id_cliente;
}
?>
