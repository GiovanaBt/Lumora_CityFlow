
<?php
session_start();

/* =========================================================
1. PROTEÇÃO DO FORMULÁRIO
========================================================= */

if (
    !isset($_POST['emailLogin']) ||
    !isset($_POST['senhaLogin'])
) {
    header("Location: index.php");
    exit();
}

/* =========================================================
2. CONEXÃO COM O BANCO
========================================================= */

require_once 'Conexao.php';

/* =========================================================
3. RECEBER DADOS
========================================================= */

$email = trim($_POST['emailLogin']);
$senhaLogin = $_POST['senhaLogin'];

/* =========================================================
4. BUSCAR USUÁRIO
========================================================= */

$sql = "
    SELECT
        id_usuarios,
        nome_usuario,
        senha
    FROM usuarios
    WHERE email = ?
    LIMIT 1
";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar consulta: " . $conexao->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();

$resultado = $stmt->get_result();

/* =========================================================
5. VERIFICAR LOGIN
========================================================= */

if ($resultado && $resultado->num_rows === 1) {

    $usuario = $resultado->fetch_assoc();

    /*
       Compatibilidade com senhas armazenadas
       em texto simples ou com password_hash().
    */

    $senhaValida = password_verify(
        $senhaLogin,
        $usuario['senha']
    );

    if (!$senhaValida) {
        $senhaValida = hash_equals(
            (string) $usuario['senha'],
            (string) $senhaLogin
        );
    }

    if ($senhaValida) {

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario['id_usuarios'];
        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];

        unset($_SESSION['erro_login']);

        $stmt->close();

        header("Location: index.php");
        exit();

    }
}

/* =========================================================
6. LOGIN INVÁLIDO
========================================================= */

$_SESSION['erro_login'] = "E-mail ou senha incorretos.";

$stmt->close();

header("Location: index.php");
exit();
?>
