<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>City Flow - Cadastro</title>

    <!-- CSS DA PÁGINA -->
    <link rel="stylesheet" href="cadastroUsuario.css">

    <!-- CSS DO RODAPÉ -->
    <link rel="stylesheet" href="footer.css">

    <!-- CSS DO CABEÇALHO -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="submenu.css">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- CABEÇALHO PADRÃO -->
    <?php include 'header.php'; ?>

    <!-- FORMULÁRIO DE CADASTRO -->
    <form action="enviarCadastroUsuario.php" method="POST" id="formCadastro">
        
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

<script src="script.js"></script>

<!-- =========================================================
   FOOTER
========================================================= -->
<?php include 'footer.php'; ?>
</body>
</html>