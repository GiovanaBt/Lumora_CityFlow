<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
include 'Conexao.php';

session_start();


$idUsuario = $_SESSION['usuario_id'];
$nomeDoEvento = $_POST['descricao'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$pontoReferencia = $_POST['ponto_referencia'];

$dataInicioEvento = $_POST['data_inicio_evento'];
$dataFimEvento = $_POST['data_fim_evento'];

$horarioInicioEvento = $_POST['horario_inicio_evento'];
$horarioFimEvento = $_POST['horario_fim_evento'];

$categorias = $_POST['categorias'];
$eventoConcluido = $_POST['evento_concluido'];
       
 $sql= "INSERT INTO Eventos_Cadastrados(id_usuarios, descricao, rua, bairro, numero, cidade, ponto_referencia, data_inicio_evento, data_fim_evento, horario_inicio_evento, horario_fim_evento, id_categoria, evento_concluido)
    VALUES ('$idUsuario','$nomeDoEvento', '$rua', '$bairro', '$numero', '$cidade', '$pontoReferencia','$dataInicioEvento', '$dataFimEvento', '$horarioInicioEvento', '$horarioFimEvento', '$categorias', '$eventoConcluido')";

    
if ($conexao->query($sql) === TRUE) {
    echo "Evento Cadastrado com sucesso";
} else {
    // echo "Erro ao efetuar cadastro" . $conexao->error;
    
}

$conexao->close();  
?> 