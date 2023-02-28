<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistema de Comentario</title>

	<link rel="stylesheet" href="assets\bootstrap\css\bootstrap.min">

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/navbar-animation-fix.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

</body>

</html>

<div class="container">
	<?php

	try {
		$pdo = new PDO("mysql:dbname=controledeusuarios;host=localhost", "root", "");
	} catch (PDOException $e) {
		echo "ERRO: " . $e->getMessage();
		exit;
	}

	if (isset($_POST['nome']) && empty($_POST['nome']) == false) {
		$nome = $_POST['nome'];
		$mensagem = $_POST['mensagem'];

		$sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":msg", $mensagem);
		$sql->execute();
	}
	?>

	<fieldset>
		<form method="POST">
			<div class="form-group">
				<h2>Digite a sua mensagem:</h2>
				Nome:<br />
				<input class="form-control" type="text" name="nome" /><br /><br />

				Mensagem:<br />
				<textarea class="form-control" name="mensagem"></textarea><br /><br />

				<input class="btn btn-primary" type="submit" value="Enviar Mensagem" />
			</div>
		</form>
	</fieldset>
	<br /><br />

	<?php
	$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
	$sql = $pdo->query($sql);
	if ($sql->rowCount() > 0) {
		foreach ($sql->fetchAll() as $mensagem) :
	?>
			<strong><?php echo $mensagem['nome']; ?></strong><br />
			<?php echo $mensagem['msg']; ?></br>
			<?php echo $mensagem['data_msg']; ?>
			<hr />
	<?php
		endforeach;
	} else {
		echo "Não há mensagens.";
	}

	?>
</div>