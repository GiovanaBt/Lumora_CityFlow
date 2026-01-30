<?php
include 'testeConexao.php';

$nomeCompleto = $_POST['nomeCompleto'];
$dataNascimento = $_POST['dataNascimento'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$nomeUsuario = $_POST['nomeUsuario'];
       
$sql=  "INSERT INTO Usuarios(nome_completo, data_nascimento, email, senha, nome_usuario)
        VALUES ('$nomeCompleto', '$dataNascimento', '$email', '$senha', '$nomeUsuario')";

if ($conexao->query($sql) === TRUE) {
  echo "<script>alert('Cadastro feito com Sucesso!');
    window.location.href = 'testeLogin.php';
    </script>";
} else {
    echo "Erro ao efetuar cadastro" . $conexao->error;
}

$conexao->close();  
?>  