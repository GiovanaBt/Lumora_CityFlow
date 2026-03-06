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

        <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100vh; /* ocupa a tela inteira */
            width: 100%;
        }
    </style>
    
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
<div id="map"></div>

<!-- JS do Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Criar o mapa (posição inicial padrão - Brasil)
    var map = L.map('map').setView([-23.5505, -46.6333], 13);

    // Adicionar camada do OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Verificar se o navegador suporta geolocalização
    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(
            function(position) {

                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                // Centralizar mapa na posição do usuário
                map.setView([lat, lon], 15);

                // Adicionar marcador
                L.marker([lat, lon])
                    .addTo(map)
                    .bindPopup("📍 Você está aqui!")
                    .openPopup();

            },
            function(error) {
                alert("Não foi possível obter sua localização.");
            }
        );

    } else {
        alert("Seu navegador não suporta geolocalização.");
    }
</script>

</body>
</html>
