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
        <h1>Preencha o formulário abaixo para cadastrar-se</h1>
        <label>Nome Completo</label>
        <input type="text" name="nomeCompleto"><br><br>

        <label>Data de Nascimento </label>
        <input type="date" name="dataNascimento" required><br><br>

        <label>E-mail</label>
        <input type="text" name="email" required><br><br>

        <label>Senha</label>
        <input type="password" name="senha" required><br><br>

        <label>Nome de Usuário</label>
        <input type="text" name="nomeUsuario" required><br><br>


        <button type="submit">Enviar</button>
    </form>
</body>

</html>