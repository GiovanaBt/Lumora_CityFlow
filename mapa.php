<?php
include 'Conexao.php';

$sql = "SELECT id_evento, descricao, latitude, longitude, rua, bairro, numero 
        FROM Eventos_Cadastrados";

$result = $conexao->query($sql);

$eventos = [];

while($row = $result->fetch_assoc()){
    $eventos[] = $row;
}

session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>City Flow - Conecte-se à cultura de sua cidade</title>

<link rel="stylesheet" href="mapa.css">
<link rel="shortcut icon" href="imgs/logoCityFlow.webp">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

</head>

<body>

<header>

<div class='logo'>
    <a href="index.php">
    <img src="imgs/logoCityFlow.webp">
    </a>
</div>

<a href="mapa.php">
    <button class="botaoMapa">MAPA</button>
</a>

<ul class="menu" id="menu">

    <li><a href="index.php">INÍCIO</a></li>
    <li><a href="#informacoes">INFORMAÇÕES</a></li>

    <li>
        <a href="cadastroEvento.php">
        <i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS
        </a>
    </li>

<?php if (isset($_SESSION['usuario_id'])): ?>

<li class="perfil">

    <a href="#">
    <i class="fa-solid fa-circle-user"></i>
    <?php echo $_SESSION['nome_usuario'];?>
    </a>

<ul class="submenu">
    <li><a href="minhaConta.php">Minha conta</a></li>
    <li><a href="minhaConta.php#favoritos">Favoritos</a></li>
    <li><a href="minhaConta.php#meusEventos">Meus eventos</a></li>
    <li><a href="ajuda.php">Central de ajuda</a></li>
    <li><a href="logout.php">Sair</a></li>
</ul>

</li>

<?php else: ?>

<li class="menu-container">
    <a id="abrirModal" style="cursor:pointer;">
    <i class="fa-solid fa-right-to-bracket"> ENTRAR</i>
    </a>
</li>

<?php endif; ?>

</ul>

<div class="hamburguer" id="hamburguer">
    <i class="fa-solid fa-bars"></i>
</div>

</header>

<div id="map"></div>

<button id="btnLocalizacao">📍 Minha localização</button>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

// mapa 

var map = L.map('map').setView([-14.2350,-51.9253],4); // Brasil inicial

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
attribution:'&copy; OpenStreetMap'
}).addTo(map);


//icones 

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


// eventos

var eventos = <?php echo json_encode($eventos); ?>;

var grupoEventos = [];

eventos.forEach(function(evento){

if(evento.latitude && evento.longitude){

    var marker = L.marker(
    [evento.latitude,evento.longitude],
    {icon:iconeEvento}
)
.addTo(map)
.bindPopup(
"<b>"+evento.descricao+"</b><br>"+
"📍 "+evento.rua+", "+evento.numero+"<br>"+
evento.bairro
);

grupoEventos.push(marker);

}

});


// Zoom automático

if(grupoEventos.length > 0){

    var grupo = L.featureGroup(grupoEventos);

    setTimeout(function(){

    map.fitBounds(grupo.getBounds());

    },1000);

}


//geolocalização

var marcadorUsuario = null;
var circuloUsuario = null;
var minhaLat = null;
var minhaLon = null;

function localizarUsuario(){

if(!navigator.geolocation){

    alert("Geolocalização não suportada");
    return;

}

navigator.geolocation.getCurrentPosition(

function(pos){

minhaLat = pos.coords.latitude;
minhaLon = pos.coords.longitude;

console.log("Minha localização:",minhaLat,minhaLon);

// remove marcador antigo 

if(marcadorUsuario){
    map.removeLayer(marcadorUsuario);
}

if(circuloUsuario){
    map.removeLayer(circuloUsuario);
}

// marcador 

marcadorUsuario = L.marker(
[minhaLat,minhaLon],
{icon:iconeUsuario}
).addTo(map)
.bindPopup("📍 Você está aqui");

// círculo de precisão 

circuloUsuario = L.circle(
[minhaLat,minhaLon],
{
radius:50,
color:"#0078ff",
fillColor:"#0078ff",
fillOpacity:0.2
}
).addTo(map);

// centraliza 

map.setView([minhaLat,minhaLon],15);

},

function(error){

console.log(error);

if(error.code===1){
    alert("Permissão de localização negada.");
}
else if(error.code===2){
    alert("Localização indisponível.");
}
else{
    alert("Tempo excedido ao localizar.");
}

},

{
enableHighAccuracy:true,
timeout:15000,
maximumAge:0
}

);

}

// iniciar localização 

localizarUsuario();


//BOTÃO LOCALIZAÇÃO 

document.getElementById("btnLocalizacao").onclick=function(){

if(minhaLat && minhaLon){
    map.setView([minhaLat,minhaLon],16);
}else{
    localizarUsuario();
}

};

</script>

</body>
</html>