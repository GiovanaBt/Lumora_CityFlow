```php
<?php

session_start();
include 'Conexao.php';


/* =========================================
   VERIFICA SE O USUÁRIO ESTÁ LOGADO
========================================= */

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}


$idUsuario = (int) $_SESSION['usuario_id'];


/* =========================================
   VERIFICA SE O FORMULÁRIO FOI ENVIADO
========================================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: minhaConta.php");
    exit();
}


/* =========================================
   RECEBE OS DADOS
========================================= */

$nomeCompleto = trim($_POST['nome_completo'] ?? '');
$nomeUsuario = trim($_POST['nome_usuario'] ?? '');
$dataNascimento = trim($_POST['data_nascimento'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');


/* =========================================
   VERIFICA CAMPOS OBRIGATÓRIOS
========================================= */

if ($nomeCompleto === '' || $nomeUsuario === '' || $email === '') {

    $_SESSION['erro_usuario'] =
        "Preencha os campos obrigatórios.";

    header("Location: minhaConta.php");
    exit();
}


/* =========================================
   VERIFICA SE O E-MAIL JÁ É DE OUTRO USUÁRIO
========================================= */

$stmtEmail = mysqli_prepare(
    $conexao,
    "SELECT id_usuarios
     FROM usuarios
     WHERE email = ?
     AND id_usuarios != ?"
);

mysqli_stmt_bind_param(
    $stmtEmail,
    "si",
    $email,
    $idUsuario
);

mysqli_stmt_execute($stmtEmail);

$resultEmail = mysqli_stmt_get_result($stmtEmail);


if (mysqli_num_rows($resultEmail) > 0) {

    $_SESSION['erro_usuario'] =
        "Este e-mail já está sendo utilizado por outro usuário.";

    header("Location: minhaConta.php");
    exit();
}


/* =========================================
   ATUALIZA COM OU SEM SENHA
========================================= */


if ($senha !== '') {

    /*
       Atualiza todos os dados,
       incluindo a senha.
    */

    $stmt = mysqli_prepare(
        $conexao,
        "UPDATE usuarios SET
            nome_completo = ?,
            nome_usuario = ?,
            data_nascimento = ?,
            cpf = ?,
            telefone = ?,
            email = ?,
            senha = ?
        WHERE id_usuarios = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $nomeCompleto,
        $nomeUsuario,
        $dataNascimento,
        $cpf,
        $telefone,
        $email,
        $senha,
        $idUsuario
    );

} else {

    /*
       Se a senha estiver vazia,
       mantém a senha atual.
    */

    $stmt = mysqli_prepare(
        $conexao,
        "UPDATE usuarios SET
            nome_completo = ?,
            nome_usuario = ?,
            data_nascimento = ?,
            cpf = ?,
            telefone = ?,
            email = ?
        WHERE id_usuarios = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $nomeCompleto,
        $nomeUsuario,
        $dataNascimento,
        $cpf,
        $telefone,
        $email,
        $idUsuario
    );
}


/* =========================================
   EXECUTA O UPDATE
========================================= */

if (mysqli_stmt_execute($stmt)) {

    /*
       Atualiza o nome da sessão
       para o cabeçalho mudar também.
    */

    $_SESSION['nome_usuario'] = $nomeUsuario;

    $_SESSION['sucesso_usuario'] =
        "Dados atualizados com sucesso!";

} else {

    $_SESSION['erro_usuario'] =
        "Erro ao atualizar os dados.";
}


/* =========================================
   VOLTA PARA MINHA CONTA
========================================= */

header("Location: minhaConta.php");
exit();

?>
```
