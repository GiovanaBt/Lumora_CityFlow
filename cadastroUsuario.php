<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Preencha as lacunas para cadastrar-se</h2>
    <form action="enviarCadastroUsuario.php" method = "POST">
        <label>Nome Completo</label><br>
        <input type="text" name="nomeCompleto"><br><br>

        <label>Data de Nascimento </label><br>
        <input type="date" name="dataNascimento" required><br><br>

        <label>E-mail</label><br>
        <input type="text" name="email" required><br><br>

        <label>Senha</label><br>
        <input type="text" name="senha" required><br><br>

        <label>Nome de Usuário</label><br>
        <input type="text" name="nomeUsuario" required><br><br>


        <button type="submit">Enviar</button>
    </form>
</body>
</html>

