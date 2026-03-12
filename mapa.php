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

        overflow: hidden; /* Evita barras de rolagem desnecessárias */

    }



    #map {

        height: calc(100vh - 80px); /* Ocupa a tela menos a altura do header */

        width: 100%;

        z-index: 1; /* Garante que fique atrás dos menus */

    }

   

    header {

        position: relative;

        z-index: 1000; /* Garante que o menu e submenus fiquem na frente do mapa */

    }

</style>

</head>

<body>


<header>

    <div class='logo'>

        <a href="index.php">

            <img src="imgs/logoCityFlow.webp" alt="logoCityFlow">

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

                <a id="abrirModal" style="cursor: pointer;">

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
<div id="loginModal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>
        </div>
</div>

<script>
    // Script básico para abrir a modal
    const modal = document.getElementById("loginModal");
    const btn = document.getElementById("abrirModal");
    const span = document.getElementsByClassName("fechar")[0];

    if (btn) {
        btn.onclick = function() { modal.style.display = "block"; }
    }
    if (span) {
        span.onclick = function() { modal.style.display = "none"; }
    }
    window.onclick = function(event) {
        if (event.target == modal) { modal.style.display = "none"; }
    }
</script>

</body>

</html>

