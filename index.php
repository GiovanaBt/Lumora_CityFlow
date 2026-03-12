<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

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
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="logo">
        </a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button> 
    </a>

    <nav> 
        <ul class="menu" id="menu"> 
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="#informacoes">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i>DIVULGAR EVENTOS</a></li>

            <?php 
            /* Início do bloco PHP: Verifica se o usuário está logado.
               Se existir um 'usuario_id' na sessão, ele mostra o menu de Perfil.
            */
            if (isset($_SESSION['usuario_id'])): 
            ?> 
                <li class="perfil">
                    <a href="#">
                        <i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?> <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i> </a>

                    <ul class="submenu">
                        <li class="submenu-header">PERFIL</li> 
                        
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="minhaConta.php#meusEventos"><i class="fa-solid fa-calendar-days"></i> Meus eventos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        
                        <hr style="border: 0.5px solid #333; margin: 5px 15px; opacity: 0.2;">
                        
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php 
            /* Caso o usuário NÃO esteja logado (else), mostra o botão de login.
            */
            else: 
            ?>
                <li>
                    <div class="menu-container" id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> <span class="texto-entrar">ENTRAR</span>
                    </div>
                </li>
            <?php endif; // Fim da condição PHP ?> 
        </ul>
    </nav>
</header>


    </header>

    <div id="modal" class="modal"> <!-- Modal de login, inicialmente oculto, que será exibido ao clicar no ícone de usuário -->
        <div class="modal-conteudo">
            <span class="fechar">&times;</span> <!-- Botão para fechar o modal -->
            <h1>QUE BOM TER VOCÊ AQUI!</h1>
            <h3>FAÇA SEU LOGIN</h3>

            <form action="fazerLogin.php" method="POST">

                <label>E-MAIL:</label><br>
                <input type="text" name="emailLogin" placeholder="Digite aqui o seu E-mail"><br><br>

                <label>SENHA:</label><br>
                <input type="password" name="senhaLogin" placeholder="Digite aqui a sua senha"><br><br>

                <button type="submit">ENTRAR</button>
                <?php
                // echo "<script>window.location.href = 'index.php';
                // </script>";
                ?>
            </form>

            <h4>NÃO POSSUI UMA CONTA?</h4>
            <a href="cadastroUsuario.php">CADASTRE-SE</a>
        </div>
    </div> <!-- Fim do modal de login -->

    <script src="script.js"></script>

    <section>

    </section>

</body>

</html>