<?php
include 'Conexao.php';
if (!isset($_SESSION)) { session_start(); }

// Proteção: Se não estiver logado, redireciona para a index ou exibe erro
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href='index.php';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CityFlow - Informações</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="informacoes.css">
</head>



<body> 

<main class="info-container">
    <h1 class="info-title">INFORMAÇÕES</h1><br><br>
    <h2 class="info-subtitle">INFORMAÇÕES GERAIS</h2>

        <div class="accordion-group">
            <details class="accordion-item"><summary>Sobre o site</summary><div class="content">Somos um site de eventos informais...</div></details>
            <details class="accordion-item"><summary>FAQ </summary><div class="content">Respostas para perguntas comuns...</div></details>
            <details class="accordion-item"><summary>Contato e atendimento ao cliente </summary><div class="content">E-mail: contato@cityflow.com</div></details>
            <details class="accordion-item"><summary>Termos de uso </summary><div class="content">Regras do site...</div></details>
        </div>
    </section>
    <br><br>

    <section class="info-section">
        <h2 class="info-subtitle">PROBLEMAS DE CADASTRO</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>Não lembro do login ou senha cadastrado </summary><div class="content">Clique em "esqueci minha senha"...</div></details>
            <details class="accordion-item"><summary>Qual a segurança que tenho em fornecer meus dados no site? </summary><div class="content">Usamos criptografia de ponta...</div></details>
            <details class="accordion-item"><summary>Por que tenho que informar e-mail válido? </summary><div class="content">Para confirmação de ingressos e segurança...</div></details>
        </div>
    </section>
    
    <section class="info-section">
        <h2 class="info-subtitle">ACESSIBILIDADE</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>Pessoas com sensibilidade sensorial (TEA, TPS, etc.) </summary><div class="content">Oferecemos abafadores e áreas calmas...</div></details>
            <details class="accordion-item"><summary>Preciso entrar com medicamentos / insulina, como faço? </summary><div class="content">Apresente a receita médica na entrada...</div></details>
            </div>
    </section>

    <section class="info-section">
        <h2 class="info-subtitle">LEI GERAL DE PROTEÇÃO DE DADOS</h2>
        <div class="accordion-group">
            <details class="accordion-item"><summary>O que é a Lei Geral de Proteção de Dados (LGPD)?</summary><div class="content">A LGPD (Lei Geral de Proteção de Dados Pessoais – Lei 13.709 de 2018) tem o objetivo de proteger e garantir a privacidade dos dados pessoais dos cidadãos (pessoas físicas) no caso de qualquer tratamento destes dados, incluindo aqueles armazenados por empresas em acervos digitais, por meio regras de coleta, armazenamento e uso dos dados pessoais dos usuários. <br><br> A lei dá direito aos usuários de acesso aos seus dados pessoais armazenados e compartilhados em bancos de dados digitais das empresas, além de outros direitos garantidos aos usuários, bem como define obrigações de tais empresas, além de instituir procedimentos para garantir a segurança dos dados. <br><br> A Lei também prevê a possibilidade de o usuário solicitar informações sobre os dados armazenados e solicitar que seus dados sejam eliminados dos acervos digitais das empresas (desde que seja aplicável nos termos da LGPD). <br><br> Sites, produtos e serviços de terceiros (parceiros) possuem termos de uso e políticas de privacidade próprios, sendo necessário solicitar seus direitos diretamente a esses terceiros.</div></details>
            <details class="accordion-item"><summary>Qual é o objetivo da lei geral de proteção de dados (LGPD)? </summary><div class="content">De acordo com o texto da Lei, ela visa proteger os direitos fundamentais de liberdade e de privacidade e o livre desenvolvimento da personalidade da pessoa natural. O objetivo é também regulamentar qualquer atividade (uso, coleta, armazenamento, compartilhamento, etc que a lei chama de tratamento) de dados pessoais.</div></details>
            </div>
    </section>
</main>
</main>