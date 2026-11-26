<?php
session_start();

include 'Conexao.php';

/* =========================================================
   FUNÇÃO PARA PROTEGER TEXTOS
========================================================= */

if (!function_exists('escapar')) {
    function escapar($texto) {
        return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
    }
}

/* =========================================================
   VERIFICAR LOGIN E CAPTURAR ERRO
========================================================= */

$logado = isset($_SESSION['usuario_id']);

$erroLogin = $_SESSION['erro_login'] ?? '';
unset($_SESSION['erro_login']);

/* =========================================================
   BUSCAR EVENTOS PARA O MAPA
========================================================= */

$sql = "SELECT
            id_evento,
            titulo,
            descricao,
            latitude,
            longitude,
            rua,
            bairro,
            numero
        FROM eventos_cadastrados";

$result = $conexao->query($sql);

if (!$result) {
    die("Erro SQL: " . $conexao->error);
}

$eventos = [];

while ($row = $result->fetch_assoc()) {
    $eventos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Flow - Mapa de Eventos</title>

    <!-- CSS DA PÁGINA -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="mapa.css">

    <!-- CSS GLOBAL DO CABEÇALHO (CARREGAR DEPOIS DOS CSS DA PÁGINA) -->
    <link rel="stylesheet" href="header.css">

    <link rel="stylesheet" href="footer.css">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- LEAFLET -->
    <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>

<body>
    <!-- CABEÇALHO PADRÃO DO CITYFLOW -->
    <?php include 'header.php'; ?>


<!-- =========================================================
     MODAL DE LOGIN - PADRÃO DA INDEX.PHP
========================================================= -->

<div id="modal" class="modal">
    <div class="modal-conteudo">
        <span class="fechar">&times;</span>

        <h1>QUE BOM TER VOCÊ AQUI!</h1>
        <h3>FAÇA SEU LOGIN</h3>

        <?php if (!empty($erroLogin)): ?>
            <p class="erro-login"><?= escapar($erroLogin); ?></p>
        <?php endif; ?>

        <form action="fazerLogin.php" method="POST">
            <label for="emailLogin">E-MAIL:</label>
            <input type="email" id="emailLogin" name="emailLogin" required>

            <label for="senhaLogin">SENHA:</label>
            <input type="password" id="senhaLogin" name="senhaLogin" required>

            <button type="submit">ENTRAR</button>
        </form>

        <h4>Não possui uma conta?</h4>
        <a href="cadastroUsuario.php">Cadastre-se</a>
    </div>
</div>

<!-- =========================================================
     JAVASCRIPT DO CABEÇALHO - PADRÃO DA INDEX.PHP
========================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const hamburguer = document.getElementById('hamburguer');
    const menu = document.getElementById('menuPrincipal');
    const perfil = document.querySelector('.perfil');
    const perfilLink = document.querySelector('.perfil-link');
    const modal = document.getElementById('modal');
    const abrirModal = document.getElementById('abrirModal');
    const fecharModal = document.querySelector('.fechar');
    const logado = <?= $logado ? 'true' : 'false'; ?>;

    function atualizarIconeMenu(aberto) {
        if (!hamburguer) return;

        hamburguer.innerHTML = aberto
            ? '<i class="fa-solid fa-xmark"></i>'
            : '<i class="fa-solid fa-bars"></i>';

        hamburguer.setAttribute('aria-expanded', String(aberto));
        hamburguer.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
    }

    function fecharSubmenu() {
        if (!perfil) return;

        perfil.classList.remove('submenu-aberto');

        if (perfilLink) {
            perfilLink.setAttribute('aria-expanded', 'false');
        }
    }

    function abrirMenu() {
        if (!menu || !hamburguer) return;

        menu.classList.add('ativo');
        atualizarIconeMenu(true);
    }

    function fecharMenu() {
        if (!menu || !hamburguer) return;

        menu.classList.remove('ativo');
        atualizarIconeMenu(false);
        fecharSubmenu();
    }

    if (hamburguer && menu) {
        hamburguer.addEventListener('click', function (evento) {
            evento.preventDefault();
            evento.stopPropagation();

            if (menu.classList.contains('ativo')) {
                fecharMenu();
            } else {
                abrirMenu();
            }
        });
    }

    if (perfil && perfilLink) {
        perfilLink.addEventListener('click', function (evento) {
            evento.preventDefault();
            evento.stopPropagation();

            const aberto = perfil.classList.toggle('submenu-aberto');
            perfilLink.setAttribute('aria-expanded', String(aberto));
        });
    }

    if (menu) {
        menu.querySelectorAll('a').forEach(function (link) {
            if (link.classList.contains('perfil-link')) return;

            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    fecharMenu();
                }
            });
        });
    }

    document.addEventListener('click', function (evento) {
        if (!menu || !hamburguer) return;

        if (
            window.innerWidth <= 900 &&
            menu.classList.contains('ativo') &&
            !menu.contains(evento.target) &&
            !hamburguer.contains(evento.target)
        ) {
            fecharMenu();
        }
    });

    document.addEventListener('keydown', function (evento) {
        if (evento.key === 'Escape') {
            fecharMenu();

            if (modal) {
                modal.style.display = 'none';
            }
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            fecharMenu();
        }
    });

    if (modal && logado) {
        modal.style.display = 'none';
    }

    if (abrirModal && modal) {
        abrirModal.addEventListener('click', function () {
            if (!logado) {
                fecharMenu();
                modal.style.display = 'flex';
            }
        });
    }

    if (fecharModal && modal) {
        fecharModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    if (modal) {
        modal.addEventListener('click', function (evento) {
            if (evento.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    fecharMenu();
});
</script>

<!-- =========================================================
     MAPA
========================================================= -->

<div id="map"></div>

<button id="btnLocalizacao" type="button">📍 Minha localização</button>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="script.js"></script>

<script>
// Configuração do Mapa Leaflet
var map = L.map('map').setView([-14.2350, -51.9253], 4);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

// Ícones
var iconeUsuario = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/64/64113.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32]
});

var iconeEvento = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32]
});

// Marcadores de eventos
var eventos = <?php
    echo json_encode(
        $eventos,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    );
?>;

console.log(eventos);

var grupoEventos = [];

eventos.forEach(function (evento) {

    if (
        evento.latitude &&
        evento.longitude &&
        evento.latitude != 0 &&
        evento.longitude != 0
    ) {
        var marker = L.marker([evento.latitude, evento.longitude], {
            icon: iconeEvento
        })
        .addTo(map)
        .bindTooltip(
            '<a href="eventos.php?id=' + encodeURIComponent(evento.id_evento) +
            '" class="evento-link">' +
            evento.titulo +
            '</a>',
            {
                permanent: true,
                direction: "top",
                offset: [0, -32],
                className: "evento-tooltip",
                interactive: true
            }
        );

        grupoEventos.push(marker);
    }
});

if (grupoEventos.length > 0) {
    var grupo = L.featureGroup(grupoEventos);

    setTimeout(function () {
        map.fitBounds(grupo.getBounds());
    }, 1000);
}

// Geolocalização do usuário
var marcadorUsuario = null;
var circuloUsuario = null;
var minhaLat = null;
var minhaLon = null;

function localizarUsuario() {

    if (!navigator.geolocation) {
        alert("Geolocalização não suportada");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (pos) {

            minhaLat = pos.coords.latitude;
            minhaLon = pos.coords.longitude;

            if (marcadorUsuario) {
                map.removeLayer(marcadorUsuario);
            }

            if (circuloUsuario) {
                map.removeLayer(circuloUsuario);
            }

            marcadorUsuario = L.marker(
                [minhaLat, minhaLon],
                { icon: iconeUsuario }
            )
            .addTo(map)
            .bindPopup("📍 Você está aqui");

            circuloUsuario = L.circle(
                [minhaLat, minhaLon],
                {
                    radius: 50,
                    color: "#0078ff",
                    fillColor: "#0078ff",
                    fillOpacity: 0.2
                }
            ).addTo(map);

            map.setView([minhaLat, minhaLon], 15);
        },
        function (error) {
            console.log(error);
        },
        {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0
        }
    );
}

localizarUsuario();

document.getElementById("btnLocalizacao").onclick = function () {

    if (minhaLat !== null && minhaLon !== null) {
        map.setView([minhaLat, minhaLon], 16);
    } else {
        localizarUsuario();
    }
};
</script>

<?php if (!empty($erroLogin)): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modalLogin = document.getElementById("modal");

    if (modalLogin) {
        modalLogin.style.display = "flex";
    }
});
</script>

<?php endif; ?>
<?php include 'footer.php'; ?>

</body>
</html>
