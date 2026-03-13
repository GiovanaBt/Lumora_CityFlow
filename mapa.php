<?php
session_start();
include 'Conexao.php';

// Busca eventos para o mapa
$sql = "SELECT id_evento, descricao, latitude, longitude, rua, bairro, numero 
        FROM Eventos_Cadastrados";
$result = $conexao->query($sql);

$eventos = [];
while($row = $result->fetch_assoc()){
    $eventos[] = $row;
}

/* Captura erro de login caso o usuário tente logar pelo mapa e erre */
$erroLogin = "";
if(!empty($_SESSION['erro_login'])){
    $erroLogin = $_SESSION['erro_login'];
    unset($_SESSION['erro_login']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - Mapa de Eventos</title>

    <link rel="stylesheet" href="index.css"> <link rel="stylesheet" href="mapa.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp"></a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <a href="mapa.php">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="index.php#informacoes">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS</a></li>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#"><i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?></a>
                    <ul class="submenu">
                        <li class="submenu-header">PERFIL</li>
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <hr style="border:0.5px solid #333; margin:5px 15px; opacity:0.2;">
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <div class="menu-container" id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span class="texto-entrar">ENTRAR</span>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div id="modal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>
        <h1>QUE BOM TER VOCÊ AQUI!</h1>
        <h3>FAÇA SEU LOGIN</h3>
        <?php if($erroLogin != ""): ?>
            <p class="erro-login"><?php echo $erroLogin; ?></p>
        <?php endif; ?>
        <form action="fazerLogin.php" method="POST">
            <label>E-MAIL:</label>
            <input type="email" name="emailLogin" required>
            <label>SENHA:</label>
            <input type="password" name="senhaLogin" required>
            <button type="submit">ENTRAR</button>
        </form>
        <h4>Não possui uma conta?</h4>
        <a href="cadastroUsuario.php">Cadastre-se</a>
    </div>
</div>

<div id="map"></div>

<button id="btnLocalizacao">📍 Minha localização</button>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="script.js"></script> <script>
// Configuração do Mapa Leaflet
var map = L.map('map').setView([-14.2350,-51.9253],4); 

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'&copy; OpenStreetMap'
}).addTo(map);

// Ícones
var iconeUsuario = L.icon({
    iconUrl:"https://cdn-icons-png.flaticon.com/512/64/64113.png",
    iconSize:[32,32],
    iconAnchor:[16,32]
});

var iconeEvento = L.icon({
    iconUrl:"https://cdn-icons-png.flaticon.com/512/684/684908.png",
    iconSize:[32,32],
    iconAnchor:[16,32]
});

// Marcadores de Eventos
var eventos = <?php echo json_encode($eventos); ?>;
var grupoEventos = [];

eventos.forEach(function(evento){
    if(evento.latitude && evento.longitude){
        var marker = L.marker([evento.latitude,evento.longitude], {icon:iconeEvento})
            .addTo(map)
            .bindPopup("<b>"+evento.descricao+"</b><br>📍 "+evento.rua+", "+evento.numero+"<br>"+evento.bairro);
        grupoEventos.push(marker);
    }
});

if(grupoEventos.length > 0){
    var grupo = L.featureGroup(grupoEventos);
    setTimeout(function(){ map.fitBounds(grupo.getBounds()); },1000);
}

// Geolocalização do Usuário
var marcadorUsuario = null;
var circuloUsuario = null;
var minhaLat = null, minhaLon = null;

function localizarUsuario(){
    if(!navigator.geolocation){ alert("Geolocalização não suportada"); return; }
    navigator.geolocation.getCurrentPosition(function(pos){
        minhaLat = pos.coords.latitude;
        minhaLon = pos.coords.longitude;
        if(marcadorUsuario) map.removeLayer(marcadorUsuario);
        if(circuloUsuario) map.removeLayer(circuloUsuario);
        marcadorUsuario = L.marker([minhaLat,minhaLon], {icon:iconeUsuario}).addTo(map).bindPopup("📍 Você está aqui");
        circuloUsuario = L.circle([minhaLat,minhaLon], {radius:50, color:"#0078ff", fillColor:"#0078ff", fillOpacity:0.2}).addTo(map);
        map.setView([minhaLat,minhaLon],15);
    }, function(error){
        console.log(error);
    }, {enableHighAccuracy:true, timeout:15000, maximumAge:0});
}

localizarUsuario();

document.getElementById("btnLocalizacao").onclick=function(){
    if(minhaLat && minhaLon){ map.setView([minhaLat,minhaLon],16); }
    else{ localizarUsuario(); }
};
</script>

<?php if($erroLogin != ""): ?>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const modalLogin = document.getElementById("modal");
        if(modalLogin) modalLogin.style.display = "block";
    });
</script>
<?php endif; ?>

</body>
</html>