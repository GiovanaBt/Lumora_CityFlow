<?php
include 'Conexao.php';

$id = $_GET['id'];

$sql = "SELECT * FROM Eventos_Cadastrados WHERE id_evento = $id";
$result = $conexao->query($sql);
$evento = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $evento['descricao']; ?></title>
</head>

<body>

<h1><?= $evento['descricao']; ?></h1>

<img src="uploads/<?= $evento['Imagem']; ?>" width="400">

<p><b>Local:</b> <?= $evento['rua'] . ", " . $evento['numero'] . " - " . $evento['bairro']; ?></p>

<p><b>Data:</b> <?= date("d/m/Y", strtotime($evento['data_inicio_evento'])); ?></p>

<p><b>Horário:</b> <?= $evento['horario_inicio_evento']; ?></p>

</body>
</html>