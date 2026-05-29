<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>City Flow - Cadastro</title>
    <link rel="stylesheet" href="cadastroUsuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <header>
        <div class='logo'>
            <a href="index.php">
                <img src="imgs/cityFlow.webp" alt="logo">
            </a>
        </div>
    </header>

    <form action="enviarCadastroUsuario.php" method="POST">
        <a href="javascript:history.back()" class="btn-voltar">&lt;</a>
        
        <h1>CRIE SUA CONTA</h1>
        <h2>PREENCHA OS CAMPOS ABAIXO</h2>
        
        <label>NOME COMPLETO:</label>
        <input type="text" name="nomeCompleto" placeholder="Digite aqui o seu nome completo" required>

        <label>DATA DE NASCIMENTO:</label>
        <input type="date" name="dataNascimento" required>

        <label>E-MAIL:</label>
        <input type="email" name="email" placeholder="Digite aqui o seu E-mail" required>

        <label>SENHA:</label>
        <input type="password" name="senha" placeholder="Digite aqui a sua senha" required>

        <label>NOME DE USUÁRIO:</label>
        <input type="text" name="nomeUsuario" placeholder="Digite aqui o seu nome de usuário" required>

        <button type="submit">ENVIAR</button>
    </form>

</body>
</html>