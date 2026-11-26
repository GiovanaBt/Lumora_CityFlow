
<?php
/* =========================================================
   CITYFLOW - CABEÇALHO PADRÃO
========================================================= */

/* Iniciar sessão */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Função de segurança */
if (!function_exists('escapar')) {
    function escapar($texto) {
        return htmlspecialchars(
            (string) $texto,
            ENT_QUOTES,
            'UTF-8'
        );
    }
}

/* Verificar login */
$logado = isset($_SESSION['usuario_id']);

/* Identificar página atual */
$paginaAtual = basename($_SERVER['PHP_SELF']);

/* Ocultar botão entrar na página de cadastro */
$ocultarEntrar = ($paginaAtual === 'cadastroUsuario.php');

/* Mensagem de erro de login */
$erroLogin = $_SESSION['erro_login'] ?? '';

if (!$ocultarEntrar) {
    unset($_SESSION['erro_login']);
}
?>

<!-- =====================================================
     CABEÇALHO
====================================================== -->

<header class="header-principal">

    <!-- LOGO -->
    <div class="logo">
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="CityFlow">
        </a>
    </div>

    <!-- BOTÃO HAMBÚRGUER -->
    <button
        class="hamburguer"
        id="hamburguer"
        type="button"
        aria-label="Abrir menu"
        aria-expanded="false"
        aria-controls="menuPrincipal"
    >
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- NAVEGAÇÃO -->
    <nav id="menuPrincipal">

        <ul class="menu">

            <li>
                <a href="index.php">INÍCIO</a>
            </li>

            <li>
                <a href="informacoes.php">INFORMAÇÕES</a>
            </li>

            <li>
                <a href="cadastroEvento.php">
                    <i class="fa-solid fa-circle-plus"></i>
                    DIVULGAR EVENTOS
                </a>
            </li>

            <?php if ($logado): ?>

                <!-- PERFIL DESKTOP -->
                <li class="perfil">

                    <a
                        href="#"
                        class="perfil-link"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="fa-solid fa-circle-user"></i>

                        <?= escapar($_SESSION['nome_usuario'] ?? 'Minha Conta'); ?>

                        <i class="fa-solid fa-chevron-down seta-submenu"></i>
                    </a>

                    <!-- SUBMENU -->
                    <ul class="submenu">

                        <li>
                            <a href="minhaConta.php">
                                <i class="fa-solid fa-user-gear"></i>
                                Minha Conta
                            </a>
                        </li>

                        <li>
                            <a href="minhaConta.php#favoritos">
                                <i class="fa-solid fa-heart"></i>
                                Favoritos
                            </a>
                        </li>

                        <li>
                            <a href="ajuda.php">
                                <i class="fa-solid fa-circle-question"></i>
                                Central de ajuda
                            </a>
                        </li>

                        <li>
                            <a href="logout.php" class="btn-sair">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Sair
                            </a>
                        </li>

                    </ul>

                </li>

                <!-- OPÇÕES MOBILE -->
                <li class="opcao-mobile">
                    <a href="minhaConta.php">
                        <i class="fa-solid fa-user-gear"></i>
                        MINHA CONTA
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="minhaConta.php#favoritos">
                        <i class="fa-solid fa-heart"></i>
                        FAVORITOS
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="ajuda.php">
                        <i class="fa-solid fa-circle-question"></i>
                        CENTRAL DE AJUDA
                    </a>
                </li>

                <li class="opcao-mobile">
                    <a href="logout.php" class="btn-sair">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        SAIR
                    </a>
                </li>

            <?php elseif (!$ocultarEntrar): ?>

                <!-- ENTRAR -->
                <li>
                    <button
                        type="button"
                        class="menu-container"
                        id="abrirModal"
                    >
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>ENTRAR</span>
                    </button>
                </li>

            <?php endif; ?>

            <!-- MAPA -->
            <li>
                <a href="mapa.php" class="botaoMapa">
                    <i class="fa-solid fa-map-location-dot"></i>
                    MAPA
                </a>
            </li>

        </ul>

    </nav>

</header>


<!-- =====================================================
     MODAL DE LOGIN
====================================================== -->

<?php if (!$logado && !$ocultarEntrar): ?>

    <div id="modal" class="modal">

        <div class="modal-conteudo">

            <button
                type="button"
                class="fechar"
                aria-label="Fechar modal"
            >
                &times;
            </button>

            <h1>QUE BOM TER VOCÊ AQUI!</h1>

            <h3>FAÇA SEU LOGIN</h3>

            <?php if (!empty($erroLogin)): ?>

                <p class="erro-login">
                    <?= escapar($erroLogin); ?>
                </p>

            <?php endif; ?>

            <form action="fazerLogin.php" method="POST">

                <label for="emailLogin">E-MAIL:</label>

                <input
                    type="email"
                    id="emailLogin"
                    name="emailLogin"
                    required
                >

                <label for="senhaLogin">SENHA:</label>

                <input
                    type="password"
                    id="senhaLogin"
                    name="senhaLogin"
                    required
                >

                <button type="submit">
                    ENTRAR
                </button>

            </form>

            <h4>Não possui uma conta?</h4>

            <a href="cadastroUsuario.php">
                Cadastre-se
            </a>

        </div>

    </div>

<?php endif; ?>


<!-- =====================================================
     JAVASCRIPT
====================================================== -->

<script>
(function () {

    function iniciarHeader() {

        const hamburguer = document.getElementById('hamburguer');
        const menu = document.getElementById('menuPrincipal');

        const perfil = document.querySelector('.perfil');
        const perfilLink = document.querySelector('.perfil-link');

        const modal = document.getElementById('modal');
        const abrirModal = document.getElementById('abrirModal');
        const fecharModal = document.querySelector('.fechar');

        /* =====================================
           ÍCONE DO HAMBÚRGUER
        ===================================== */

        function atualizarIconeMenu(aberto) {

            if (!hamburguer) return;

            hamburguer.innerHTML = aberto
                ? '<i class="fa-solid fa-xmark"></i>'
                : '<i class="fa-solid fa-bars"></i>';

            hamburguer.setAttribute(
                'aria-expanded',
                String(aberto)
            );

            hamburguer.setAttribute(
                'aria-label',
                aberto ? 'Fechar menu' : 'Abrir menu'
            );
        }


        /* =====================================
           SUBMENU DO PERFIL
        ===================================== */

        function fecharSubmenu() {

            if (!perfil) return;

            perfil.classList.remove('submenu-aberto');

            if (perfilLink) {
                perfilLink.setAttribute('aria-expanded', 'false');
            }
        }


        /* =====================================
           ABRIR MENU MOBILE
        ===================================== */

        function abrirMenu() {

            if (!menu || !hamburguer) return;

            menu.classList.add('ativo');

            atualizarIconeMenu(true);
        }


        /* =====================================
           FECHAR MENU MOBILE
        ===================================== */

        function fecharMenu() {

            if (!menu || !hamburguer) return;

            menu.classList.remove('ativo');

            atualizarIconeMenu(false);

            fecharSubmenu();
        }


        /* =====================================
           CLIQUE NO HAMBÚRGUER
        ===================================== */

        if (hamburguer && menu) {

            hamburguer.addEventListener('click', function (evento) {

                evento.preventDefault();
                evento.stopPropagation();

                const aberto = menu.classList.contains('ativo');

                if (aberto) {
                    fecharMenu();
                } else {
                    abrirMenu();
                }

            });

        } else {

            console.error(
                'CityFlow: botão hambúrguer ou menu não encontrado.'
            );

        }

if (perfil && perfilLink) {

    perfilLink.addEventListener('click', function (evento) {

        evento.preventDefault();
        evento.stopPropagation();

        const aberto = perfil.classList.toggle('submenu-aberto');

        perfilLink.setAttribute(
            'aria-expanded',
            String(aberto)
        );

        console.log('Submenu clicado!');
        console.log('Classes do perfil:', perfil.className);

    });

}


        /* =====================================
           FECHAR MENU AO CLICAR EM UM LINK
        ===================================== */

        if (menu) {

            menu.querySelectorAll('a').forEach(function (link) {

                if (link.classList.contains('perfil-link')) {
                    return;
                }

                link.addEventListener('click', function () {

                    if (window.innerWidth <= 900) {
                        fecharMenu();
                    }

                });

            });

        }


        /* =====================================
           FECHAR AO CLICAR FORA
        ===================================== */

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


        /* =====================================
           TECLA ESC
        ===================================== */

        document.addEventListener('keydown', function (evento) {

            if (evento.key === 'Escape') {

                fecharMenu();

                if (modal) {
                    modal.style.display = 'none';
                }

            }

        });


        /* =====================================
           REDIMENSIONAMENTO DA TELA
        ===================================== */

        window.addEventListener('resize', function () {

            if (window.innerWidth > 900) {
                fecharMenu();
            }

        });


        /* =====================================
           ABRIR MODAL DE LOGIN
        ===================================== */

        if (abrirModal && modal) {

            abrirModal.addEventListener('click', function () {

                fecharMenu();

                modal.style.display = 'flex';

            });

        }


        /* =====================================
           FECHAR MODAL
        ===================================== */

        if (fecharModal && modal) {

            fecharModal.addEventListener('click', function () {

                modal.style.display = 'none';

            });

        }


        /* Fechar clicando fora do conteúdo */

        if (modal) {

            modal.addEventListener('click', function (evento) {

                if (evento.target === modal) {
                    modal.style.display = 'none';
                }

            });

        }


        /* =====================================
           ESTADO INICIAL
        ===================================== */

        fecharMenu();

    }


    /* Executar mesmo se o DOM já estiver carregado */

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            iniciarHeader
        );

    } else {

        iniciarHeader();

    }

})();
</script>
