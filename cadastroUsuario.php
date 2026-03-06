<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>City Flow - Cadastro de Usuário</title>
    <link rel="stylesheet" href="cadastroUsuario.css">
    <link rel="shortcut icon" href="imgs/logoCityFlow.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    <form action="enviarCadastroUsuario.php" method="POST">
        <h1>PREENCHA O FORMULÁRIO ABAIXO PARA CADASTRAR-SE</h1>
        <label>NOME COMPLETO:</label>
        <input type="text" name="nomeCompleto" placeholder="Digite aqui o seu nome completo" required><br><br>

        <label>DATA DE NASCIMENTO:</label>
        <input type="date" name="dataNascimento" placeholder="Selecione a data de nascimento" required><br><br>

        <label>E-MAIL:</label>
        <input type="text" name="email" placeholder="Digite aqui o seu E-mail" required><br><br>

        <label>SENHA:</label>
        <input type="password" name="senha" placeholder="Digite aqui a sua senha" required><br><br>

        <label>NOME DE USUÁRIO:</label>
        <input type="text" name="nomeUsuario" placeholder="Digite aqui o seu nome de usuário" required><br><br>

        <button type="submit">ENVIAR</button>
    </form>
</body>

</html>