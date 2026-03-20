<?php
include 'Conexao.php';
session_start();

// Verificação de segurança
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Você precisa estar logado.");
}

$nomeImagem = "";

// CORREÇÃO: O nome no HTML é "capa", então usamos $_FILES['capa']
if(isset($_FILES['capa']) && $_FILES['capa']['error'] == 0){

    $diretorio = "uploads/";

    if(!file_exists($diretorio)){
        mkdir($diretorio, 0777, true);
    }

    $extensao = pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION);
    $nomeImagem = uniqid() . "." . $extensao;

    move_uploaded_file($_FILES["capa"]["tmp_name"], $diretorio . $nomeImagem);
}

// Coleta de dados do formulário
$idUsuario = $_SESSION['usuario_id'];
// No seu dump, 'descricao' parece ser usado para o NOME/TÍTULO do evento
$nomeDoEvento = mysqli_real_escape_string($conexao, $_POST['nome']); 
$descricaoDetalhada = mysqli_real_escape_string($conexao, $_POST['descricao']);
$rua = mysqli_real_escape_string($conexao, $_POST['rua']);
$bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
$numero = (int)$_POST['numero'];
$cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);
$pontoReferencia = mysqli_real_escape_string($conexao, $_POST['ponto_referencia']);

$dataInicioEvento = $_POST['data_inicio_evento'];
$dataFimEvento = $_POST['data_fim_evento'];
$horarioInicioEvento = $_POST['horario_inicio_evento'];
$horarioFimEvento = $_POST['horario_fim_evento'];
$categoriaId = $_POST['categorias'];

// SQL atualizado para bater com as colunas do seu DUMP
// Nota: Usei a variável $nomeDoEvento na coluna 'descricao' pois vi no seu dump 
// que você salva o título do evento (ex: "Workshop de Jazz") nela.
$sql = "INSERT INTO eventos_cadastrados (
            id_usuarios, descricao, rua, bairro, numero, cidade, ponto_referencia, 
            data_inicio_evento, data_fim_evento, horario_inicio_evento, horario_fim_evento, 
            id_categoria, Imagem
        ) VALUES (
            '$idUsuario', '$nomeDoEvento', '$rua', '$bairro', $numero, '$cidade', '$pontoReferencia', 
            '$dataInicioEvento', '$dataFimEvento', '$horarioInicioEvento', '$horarioFimEvento', 
            '$categoriaId', '$nomeImagem'
        )";

if ($conexao->query($sql) === TRUE) {
    echo "<script>
            alert('Evento publicado com sucesso!');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "Erro ao cadastrar: " . $conexao->error;
}

$conexao->close();
?>