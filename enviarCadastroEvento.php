<?php
include 'Conexao.php';
session_start();

// Verificação de segurança
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Você precisa estar logado.");
}

$nomeImagem = "";

// Processamento da Imagem
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

// 1. Título do evento (O nome que aparece nos cards)
$tituloEvento = mysqli_real_escape_string($conexao, $_POST['nome']); 

// 2. Descrição detalhada (O texto longo da seção 3)
$descricaoDetalhada = mysqli_real_escape_string($conexao, $_POST['descricao']);

// 3. Dados de localização
$rua = mysqli_real_escape_string($conexao, $_POST['rua']);
$bairro = mysqli_real_escape_string($conexao, $_POST['bairro']);
$numero = (int)$_POST['numero'];
$cidade = mysqli_real_escape_string($conexao, $_POST['cidade']);

// ----------------------
// CONVERSÃO DE ENDEREÇO
// ----------------------

// Trata número inválido
$numero = trim($numero);

if($numero == "Não consta" || $numero == "S/N" || empty($numero)){
    $endereco = "$rua, $bairro, $cidade, Brasil";
}else{
    $endereco = "$rua $numero, $bairro, $cidade, Brazil";
}

// Monta URL
$enderecoFormatado = urlencode($endereco);

$url = "https://nominatim.openstreetmap.org/search?q=".$enderecoFormatado."&format=json&limit=1";

// Configuração obrigatória
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: CityFlowApp/1.0\r\n"
    ]
];

$context = stream_context_create($options);

// Faz requisição
$resposta = file_get_contents($url, false, $context);

$dados = json_decode($resposta, true);

// Validação forte (resolve seu erro DEFINITIVAMENTE)
if(empty($dados) || !isset($dados[0]['lat']) || !isset($dados[0]['lon'])){
    echo "Erro: endereço não encontrado. Verifique os dados.";
    exit();
}

// Agora SEMPRE terá valor
$latitude = $dados[0]['lat'];
$longitude = $dados[0]['lon'];

// 4. Ponto de Referência (Agora salvo de forma limpa, sem o título junto)
$pontoReferencia = mysqli_real_escape_string($conexao, $_POST['ponto_referencia']);

// 5. Datas, Horários e Categoria
$dataInicioEvento = $_POST['data_inicio_evento'];
$dataFimEvento = $_POST['data_fim_evento'];
$horarioInicioEvento = $_POST['horario_inicio_evento'];
$horarioFimEvento = $_POST['horario_fim_evento'];
$categoriaId = $_POST['categorias'];

// SQL ORGANIZADO: Cada informação na sua respectiva coluna
$sql = "INSERT INTO Eventos_Cadastrados(
    id_usuarios, 
    titulo, 
    descricao, 
    rua, 
    bairro, 
    numero, 
    cidade, 
    ponto_referencia, 
    latitude,
    longitude,
    data_inicio_evento, 
    data_fim_evento, 
    horario_inicio_evento, 
    horario_fim_evento, 
    id_categoria, 
    Imagem
)

VALUES(
    '$idUsuario', 
    '$tituloEvento', 
    '$descricaoDetalhada', 
    '$rua', 
    '$bairro', 
    $numero, 
    '$cidade', 
    '$pontoReferencia', 
    $latitude,
    $longitude,
    '$dataInicioEvento', 
    '$dataFimEvento', 
    '$horarioInicioEvento', 
    '$horarioFimEvento', 
    '$categoriaId', 
    '$nomeImagem'
)";

if ($conexao->query($sql) === TRUE) {

    echo "<script>
            window.location.href = 'index.php';
          </script>";

} else {

    echo "Erro ao cadastrar evento: " . $conexao->error;

}

$conexao->close();
?>