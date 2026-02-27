<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
<header>
    <div class='logo'>
        <img src="imgs/logoCityFlow.webp" alt="logo">
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="menu" id="menu">
    <li><a href="#informacoes">Informações</a></li>
    <li><a href="cadastroEvento.php">Divulgar Eventos</a></li>

    <a href="mapa.php" target="_blank">
    <button class="bMapa">Ver eventos no mapa</button>
    </a>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <li class="perfil">
            <a href="index.php">
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
        <li>
            <a id="abrirModal">
                <i class="fa-solid fa-circle-user"></i>
            </a>
        </li>
    <?php endif; ?>

</ul>

</header>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div id="map" style="height:400px;"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([-23.55, -46.63], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

// localização do usuário
navigator.geolocation.getCurrentPosition(function(pos) {
    var lat = pos.coords.latitude;
    var lon = pos.coords.longitude;

    map.setView([lat, lon], 15);
    L.marker([lat, lon]).addTo(map)
        .bindPopup("Você está aqui")
        .openPopup();
});

// adicionar ponto ao clicar
map.on('click', function(e){
    L.marker(e.latlng).addTo(map);
});
</script>