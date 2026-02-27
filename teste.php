<?php
include "conexao.php";

$sql = "SELECT * FROM Eventos_Cadastrados ORDER BY id_evento DESC";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Eventos</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #fff6f2;
}
.container {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap: 20px;
    padding: 30px;
}
.card {
    background: #ffece5;
    border-radius: 20px;
    padding-bottom: 15px;
    text-align: center;
}
.card img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    border-radius: 20px 20px 0 0;
}
.nome {
    font-size: 22px;
    margin: 10px 0;
}
.local {
    color: #ff5722;
}
.data {
    color: #555;
}
.btn {
    display: block;
    margin: 10px auto;
    width: 70%;
    padding: 10px;
    background: #25d366;
    color: white;
    text-decoration: none;
    border-radius: 20px;
}
</style>

</head>
<body>

<h1 style="text-align:center;">Eventos</h1>

<div class="container">

<div class="container">

<?php while($row = $result->fetch_assoc()): ?>

    <div class="card">
        <img src="uploads/<?= $row['Imagem']; ?>" alt="<?= $row['descricao']; ?>">

        <div class="nome"><?= $row['descricao']; ?></div>
        <div class="local"><?= $row['rua']; ?> <?= $row['numero']; ?>, <?= $row['bairro']; ?></div>
        <div class="data">Data: <?= date("d/m/Y", strtotime($row['data_inicio_evento'])); ?></div>
    </div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>