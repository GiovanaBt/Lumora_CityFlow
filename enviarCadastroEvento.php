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

$nomeImagem = "";

if(isset($_FILES['capa']) && $_FILES['capa']['error'] == 0){

    $diretorio = "uploads/";

    if(!file_exists($diretorio)){
        mkdir($diretorio, 0777, true);
    }

    $extensao = pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION);
    $nomeImagem = uniqid() . "." . $extensao;

    move_uploaded_file($_FILES["capa"]["tmp_name"], $diretorio . $nomeImagem);
}

$idUsuario = $_SESSION['usuario_id'];
$nomeDoEvento = $_POST['nome'];
$descricao = $_POST['descricao'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$pontoReferencia = $_POST['ponto_referencia'];
$complemento = $_POST['complemento'];

$dataInicioEvento = $_POST['data_inicio_evento'];
$dataFimEvento = $_POST['data_fim_evento'];

$horarioInicioEvento = $_POST['horario_inicio_evento'];
$horarioFimEvento = $_POST['horario_fim_evento'];

$categorias = $_POST['categorias'];

function normalizarEndereco($texto){

    $acentos = [
        'Á'=>'A','À'=>'A','Ã'=>'A','Â'=>'A','Ä'=>'A',
        'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','ä'=>'a',
        'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
        'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
        'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
        'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
        'Ó'=>'O','Ò'=>'O','Õ'=>'O','Ô'=>'O','Ö'=>'O',
        'ó'=>'o','ò'=>'o','õ'=>'o','ô'=>'o','ö'=>'o',
        'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U',
        'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
        'Ç'=>'C','ç'=>'c'
    ];

    $texto = strtr($texto, $acentos);

    $texto = preg_replace('/[.,\-]/', ' ', $texto);

    $texto = preg_replace('/\s+/', ' ', $texto);

    return trim($texto);
}

// endereço digitado
$endereco = $rua . " " . $numero . ", " . $cidade . ", Brazil";

// normalização
$rua = normalizarEndereco($rua);
$bairro = normalizarEndereco($bairro);
$cidade = normalizarEndereco($cidade);

// $endereco = $rua . " " . $numero . ", " . $bairro . ", " . $cidade . ", Brazil";

$enderecoFormatado = urlencode($endereco);

$url = "https://nominatim.openstreetmap.org/search?q=".$enderecoFormatado."&format=json&limit=1";

echo "<h3>Debug endereço</h3>";
echo "Endereço original: ".$enderecoOriginal."<br>";
echo "Endereço normalizado: ".$endereco."<br>";
echo "URL enviada: ".$url."<br><br>";

$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: CityFlowApp/1.0\r\n"
    ]
];

$context = stream_context_create($options);

$resposta = file_get_contents($url, false, $context);

echo "<pre>Resposta da API:\n";
echo $resposta;
echo "</pre>";

$dados = json_decode($resposta, true);

$latitude = null;
$longitude = null;

if(!empty($dados)){
    $latitude = $dados[0]['lat'];
    $longitude = $dados[0]['lon'];

    echo "<br>Latitude: ".$latitude;
    echo "<br>Longitude: ".$longitude;

}else{
    echo "<br><b>Endereço não encontrado no mapa.</b>";
    exit();
}

$sql= "INSERT INTO Eventos_Cadastrados(
id_usuarios, nome, descricao, rua, bairro, numero, cidade, cep, complemento, ponto_referencia, 
data_inicio_evento, data_fim_evento, horario_inicio_evento, horario_fim_evento, id_categoria, Imagem, latitude, longitude)

VALUES (
'$idUsuario','$nomeDoEvento','$descricao', '$rua', '$bairro', '$numero', '$cidade', '$cep', '$complemento','$pontoReferencia',
'$dataInicioEvento', '$dataFimEvento', '$horarioInicioEvento', '$horarioFimEvento', '$categorias', '$nomeImagem', '$latitude', '$longitude')";

    
if ($conexao->query($sql) === TRUE) {
    echo "<script>
            window.location.href = 'index.php';
          </script>";
} else {
    // echo "Erro ao efetuar cadastro" . $conexao->error;
    
}

$conexao->close();  
?> 