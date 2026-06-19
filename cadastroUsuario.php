CADASTRO USUARIO
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Cadastro</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="cadastroUsuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp" alt="Logo CityFlow"></a>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>

            <li><a href="informacoes.php">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS</a></li>

            
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#"><i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?></a>
                    <ul class="submenu">
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>

                <?php endif; ?>
</header>

    <form action="enviarCadastroUsuario.php" method="POST" id="formCadastro">
        <a href="javascript:history.back()" class="btn-voltar">&lt;</a>
        
        <h1>CRIE SUA CONTA</h1>
        <h2>PREENCHA OS CAMPOS ABAIXO</h2>
        
        <label>NOME COMPLETO:</label>
        <input type="text" name="nomeCompleto" placeholder="Digite aqui o seu nome completo" required>

        <label>DATA DE NASCIMENTO:</label>
        <input type="date" name="dataNascimento" required>

        <label>CPF:</label>
        <input type="text" name="cpf" id="cpf" placeholder="Digite aqui o seu CPF" maxlength="14" required>

        <label>TELEFONE:</label>
        <input type="tel" name="telefone" id="telefone" placeholder="Digite aqui o seu telefone" maxlength="15" required>

        <label>E-MAIL:</label>
        <input type="email" name="email" placeholder="Digite aqui o seu E-mail" required>

        <label>SENHA:</label>
<div class="campo-senha">
    <input type="password" id="senha" name="senha" placeholder="Digite aqui a sua senha" required>
    <i class="fa-solid fa-eye-slash" id="olhoSenha"></i> 
</div>

<label>CONFIRMAR SENHA:</label>
<div class="campo-senha">
    <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Digite novamente a sua senha" required>
    <i class="fa-solid fa-eye-slash" id="olhoConfirmarSenha"></i> 
</div>

<p id="erroSenha" class="erro-senha"></p>
    
        <label>NOME DE USUÁRIO:</label>
        <input type="text" name="nomeUsuario" placeholder="Digite aqui o seu nome de usuário" required>

        <button type="submit">ENVIAR</button>
    </form>

<script>
const olhoSenha = document.getElementById("olhoSenha");
const senha = document.getElementById("senha");

const olhoConfirmar = document.getElementById("olhoConfirmarSenha");
const confirmarSenha = document.getElementById("confirmarSenha");

const erroSenha = document.getElementById("erroSenha");

olhoSenha.addEventListener("click", function() {
    if (senha.type === "password") {
        senha.type = "text";
        // Quando mostra o texto, o olho fica ABERTO
        this.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        senha.type = "password";
        // Quando esconde (bolinhas), o olho fica FECHADO
        this.classList.replace("fa-eye", "fa-eye-slash");
    }
});

olhoConfirmar.addEventListener("click", function() {
    if (confirmarSenha.type === "password") {
        confirmarSenha.type = "text";
        // Quando mostra o texto, o olho fica ABERTO
        this.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        confirmarSenha.type = "password";
        // Quando esconde (bolinhas), o olho fica FECHADO
        this.classList.replace("fa-eye", "fa-eye-slash");
    }
});

function verificarSenhas() {

    if (confirmarSenha.value === "") {
        erroSenha.style.display = "none";
        return;
    }

    if (senha.value !== confirmarSenha.value) {
        erroSenha.textContent = "As senhas não coincidem.";
        erroSenha.style.display = "block";
    } else {
        erroSenha.style.display = "none";
    }
}

senha.addEventListener("input", verificarSenhas);
confirmarSenha.addEventListener("input", verificarSenhas);

document.getElementById("formCadastro").addEventListener("submit", function(e) {

    if (senha.value !== confirmarSenha.value) {

        erroSenha.textContent = "As senhas não coincidem.";
        erroSenha.style.display = "block";

        e.preventDefault();
    }
});

const inputTelefone = document.querySelector('input[name="telefone"]');
const inputCpf = document.getElementById('cpf');

// Máscara do Telefone: (00) 00000-0000
inputTelefone.addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\D/g, ""); // Remove tudo o que não é número
    
    if (valor.length > 0) {
        valor = "(" + valor;
    }
    if (valor.length > 3) {
        valor = valor.slice(0, 3) + ") " + valor.slice(3);
    }
    if (valor.length > 10) {
        valor = valor.slice(0, 10) + "-" + valor.slice(10, 14);
    }
    
    e.target.value = valor;
});

// Máscara do CPF: 000.000.000-00
inputCpf.addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\D/g, ""); // Remove tudo o que não é número
    
    if (valor.length > 3) {
        valor = valor.slice(0, 3) + "." + valor.slice(3);
    }
    if (valor.length > 7) {
        valor = valor.slice(0, 7) + "." + valor.slice(7);
    }
    if (valor.length > 11) {
        valor = valor.slice(0, 11) + "-" + valor.slice(11, 13);
    }
    
    e.target.value = valor;
});
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php
// Configurações do Rodapé
$ano_atual = date('Y');
$footer_data = [
    'ajuda' => [
        'titulo' => 'Ajuda',
        'links'  => [
            ['txt' => 'Central de Ajuda', 'url' => '#'],
            ['txt' => 'FAQ', 'url' => '#'],
            ['txt' => 'Contato e Suporte', 'url' => '#'],
            ['txt' => 'Reportar Problema', 'url' => '#']
        ]
    ],
    'institucional' => [
        'titulo' => 'Institucional',
        'links'  => [
            ['txt' => 'Sobre o CityFlow', 'url' => '#'],
            ['txt' => 'Missão e Valores', 'url' => '#'],
            ['txt' => 'Privacidade', 'url' => '#'],
            ['txt' => 'Termos de Uso', 'url' => '#']
        ]
    ]
];
?>

<footer class="footer-main">
    <div class="footer-overlay">
        <div class="footer-container">
            
            <?php foreach ($footer_data as $coluna): ?>
            <div class="footer-col">
                <h4 class="footer-title"><?php echo $coluna['titulo']; ?></h4>
                <ul class="footer-links">
                    <?php foreach ($coluna['links'] as $link): ?>
                        <li><a href="<?php echo $link['url']; ?>"><?php echo $link['txt']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>

            <div class="footer-brand">
                <div class="logo-wrapper">
                    <span class="logo-city">CITY</span><span class="logo-flow">FLOW</span>
                </div>
                <p class="brand-text">
                    Conectando a essência das ruas e a cultura urbana. Descubra eventos, arte e movimento em um só lugar.
                </p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Twitter">TW</a>
                    <a href="#" aria-label="Facebook">FB</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo $ano_atual; ?> CityFlow - Todos os direitos reservados.</p>
        </div>
    </div>
</footer>
</body>
</html>