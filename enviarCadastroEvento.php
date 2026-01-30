<?php
include 'testeConexao.php';

$idUsuarios = $_POST['id_usuarios'];
$nomeDoEvento = $_POST['descricao'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$pontoReferencia = $_POST['ponto_referencia'];
$dataEvento = $_POST['data_evento'];
$horarioEvento = $_POST['horario_evento'];
$categorias = $_POST['categorias'];
$eventoConcluido = $_POST['evento_concluido'];
       
 $sql= "INSERT INTO Eventos_Cadastrados(id_usuarios, descricao, rua, bairro, numero, cidade, ponto_referencia, data_evento, horario_evento, id_categoria, evento_concluido)
    VALUES ('$idUsuarios','$nomeDoEvento', '$rua', '$bairro', '$numero', '$cidade', '$pontoReferencia', '$dataEvento', '$horarioEvento', '$categorias', '$eventoConcluido')";
    
   echo "<script>alert('Cadastro feito com Sucesso!');
    window.location.href = 'cadastroEvento.php';
    </script>";
    
if ($conexao->query($sql) === TRUE) {
    echo "<script>alert ('OK ATE AQUI');</script>";
    echo "Cadastro efetuado com sucesso!<br>"; 
} else {
    echo "Erro ao efetuar cadastro" . $conexao->error;
}

$conexao->close();  
?> 