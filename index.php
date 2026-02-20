<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Concte-se à cultura de sua cidade</title>
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow_removebg.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    <header>
        <div class='logo'>
            <a href="index.php"></a>
            <img src="imgs/cityFlow.webp" alt="logo"> <!-- Logo -->
        </div>
        <a href="mapa.php" target="_blank">
            <button class="bMapa">MAPA</button> <!-- Botão para acessar o mapa em uma nova aba -->
        </a>
        <ul class="menu" id="menu"> <!-- Menu de navegação do header -->
            <li><a href="#informacoes">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php">DIVULGAR EVENTOS</a></li>


            <?php if (isset($_SESSION['usuario_id'])): ?> <!-- Verifica se o usuário está logado -->
                <li class="perfil">
                    <a href="index.php">
                        <i class="fa-solid fa-circle-user"></i>
                        <?php echo $_SESSION['nome_usuario']; ?>
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

                <div class="menu-container"> <!-- Container para o menu hambúrguer e o ícone de usuário -->
                    <li>
                        <a id="hamburguer" class="hamburguer"> <!-- Ícone do menu hambúrguer -->
                            <i class="fa-solid fa-bars"></i>
                        </a>
                        
                    </li>
                    <li>
                        <a id="abrirModal"> <!-- Ícone de usuário para abrir o modal de login -->
                            <i class="fa-solid fa-circle-user"></i>
                        </a>
                    </li>
                </div>

            <?php endif; ?> <!-- Fim da verificação de login -->

        </ul>

    </header>

    <div id="modal" class="modal"> <!-- Modal de login, inicialmente oculto, que será exibido ao clicar no ícone de usuário -->
        <div class="modal-conteudo">
            <span class="fechar">&times;</span> <!-- Botão para fechar o modal -->
            <h1>Que bom ter você aqui!</h1>
            <h3>Faça seu Login</h3>

            <form action="fazerLogin.php" method="POST">

                <label>E-mail</label><br>
                <input type="text" name="emailLogin"><br><br>

                <label>Senha</label><br>
                <input type="text" name="senhaLogin"><br><br>

                <button type="submit">Entrar</button>
                <?php
                echo "<script>window.location.href = 'index.php';
                </script>"; // Redireciona para a página inicial após o login
                ?>
            </form>

            <h4>Não possui uma conta?</h4>
            <a href="cadastroUsuario.php">Cadastre-se</a>
        </div>
    </div> <!-- Fim do modal de login -->

    <script src="script.js"></script>

</body>

</html>