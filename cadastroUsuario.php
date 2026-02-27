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

        h1 {
            text-align: center;
        }

        form {
            background-color: #fff;
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
            text-align: center;
            align-items: center;
            background: linear-gradient(45deg, #a8329e, #2dbac9);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 100px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
        }
    </style>
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