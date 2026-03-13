<?php
include 'Conexao.php';

$categorias = mysqli_query($conexao, 'SELECT id_categoria, categoria_evento FROM Categoria');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Eventos</title>
    <link rel="stylesheet" href="cadastroEvento.css">
</head>
<body>
    
   <form action="enviarCadastroEvento.php" method="POST" enctype="multipart/form-data">

   <div class="main-container">
    <h1 class="main-title">CADASTRO DE EVENTO</h1>

    </form>

    <div class="main-container">

    <section class="card-section basic-info">
        <h2>1. INFORMAÇÕES BÁSICAS</h2>
        <p class="subtitle">Adicione as principais informações do evento.</p>

        <div class="input-group">
            <label for="nome">Nome do Evento <span class="required">*</span></label>
            <input type="text" id="nome" name="nome" placeholder="Nome do Evento">
        </div>

        <div class="input-group image-upload">
            <label for="capa">Capa do Evento (opcional)</label>
            <div class="upload-placeholder">
                <span>Clique ou arraste a imagem aqui</span>
                <input type="file" id="capa" name="capa">
            </div>
            <div class="upload-info">
                <p>A dimensão recomendada é de <strong>1600 x 838</strong></p>
                <p>Formato <strong>JPEG, GIF ou PNG de no máximo 2MB.</strong></p>
            </div>
        </div>

        <div class="input-group">
            <label for="categoria">Escolha uma categoria para seu Evento <span class="required">*</span></label>
            <select id="categoria" name="categoria">
                <option value="" disabled selected>Selecione uma categoria</option>
                </select>
        </div>
    </section>

</div>





<section class="card-section">
    <h2>2. DATA E HORÁRIO</h2>
    <p class="subtitle">Informe aos participantes quando seu evento vai acontecer.</p>

    <div class="datetime-grid">
        <div class="input-group">
            <label>Data de Início <span class="required">*</span></label>
            <div class="input-with-icon">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <input type="date">
            </div>
        </div>

        <div class="input-group">
            <label>Horário de Início <span class="required">*</span></label>
            <div class="input-with-icon">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <input type="time">
            </div>
        </div>

        <div class="input-group">
            <label>Data de Término <span class="required">*</span></label>
            <div class="input-with-icon">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <input type="date">
            </div>
        </div>

        <div class="input-group">
            <label>Horário de Término <span class="required">*</span></label>
            <div class="input-with-icon">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <input type="time">
            </div>
        </div>
    </div>

</section>





<div class="card-section">
    <h2>3. DESCRIÇÃO DO EVENTO</h2>
    <p class="subtitle">Conte todos os detalhes do seu evento, como a programação e os diferenciais da sua produção!</p>

    <textarea class="description-textarea" placeholder="Adicione aqui a descrição do seu evento..."></textarea>
</div>





<section class="card-section">
    <h2>4. ONDE O SEU EVENTO VAI ACONTECER?</h2>
    <p class="subtitle">Adicione as principais informações do evento.</p>

    <div class="address-grid">
        <div class="input-group col-medium">
            <label>Cidade <span class="required">*</span></label>
            <input type="text" placeholder="Nome da cidade">
        </div>

        <div class="input-group col-medium">
            <label>Bairro <span class="required">*</span></label>
            <input type="text" placeholder="Nome do bairro">
        </div>

        <div class="input-group col-medium">
            <label>Nome da Av./Rua <span class="required">*</span></label>
            <input type="text" placeholder="Nome da Av./Rua">
        </div>

        <div class="input-group col-medium">
            <label>CEP <span class="required">*</span></label>
            <input type="text" placeholder="_____-___">
        </div>

        <div class="input-group col-large">
            <label>Ponto de Referência <span class="required">*</span></label>
            <input type="text" placeholder="Ponto de referência">
        </div>

        <div class="input-group col-small">
            <label>Número <span class="required">*</span></label>
            <input type="text" placeholder="Número">
        </div>

        <div class="input-group col-full">
            <label>Complemento</label>
            <input type="text" placeholder="Complemento">
        </div>
    </div>
</section>





<section class="card-section">
    <h2>5. RESPONSABILIDADES</h2>
    <div class="checkbox-container">
        <input type="checkbox" id="termos" name="termos" required>
        <label for="termos">
            Ao publicar este evento, declaro estar de acordo com os 
            <a href="#">Termos de Uso</a>, bem como estar ciente da 
            <a href="#">Política de Privacidade</a> e das obrigações legais aplicáveis.
        </label>
    </div>
</section>

<button type="submit" class="btn-send">Enviar Evento</button>


</html>