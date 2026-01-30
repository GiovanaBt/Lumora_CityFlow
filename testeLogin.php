<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Preencha as lacunas para cadastrar-se</h2>
    <form action="testeEnviar.php" method = "POST">
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

kskks


