<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000000ff;
            padding: 20px;
        }

        h2 {
            color: #fff;
        }

        form {
            background-color: #000;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #2db9c9ac;
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #2dbac9;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #a8329e;
        }
    </style>
</head>
<body>
    <h2>Preencha o formulário abaixo para cadastrar-se</h2>
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

