<?php
include 'Conexao.php';
if (!isset($_SESSION)) { session_start(); }

// Proteção: Se não estiver logado, redireciona para a index ou exibe erro
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página.'); window.location.href='index.php';</script>";
    exit;
}

$categorias = mysqli_query($conexao, 'SELECT id_categoria, categoria_evento FROM Categoria');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CityFlow - Cadastro de Eventos</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="cadastroEvento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>  

<header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp" alt="Logo CityFlow"></a>
    </div>

    <div class="hamburguer" id="hamburguer">
        <i class="fa-solid fa-bars"></i>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="index.php#informacoes">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS</a></li>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#"><i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?></a>
                    <ul class="submenu">
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <hr style="border:0.5px solid #333; margin:5px 15px; opacity:0.2;">
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <div class="menu-container" id="abrirModal">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span class="texto-entrar">ENTRAR</span>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<h1 class="main-title">CADASTRO DE EVENTO</h1>

<form action="enviarCadastroEvento.php" method="POST" enctype="multipart/form-data">
    <div class="main-container">

        <section class="card-section basic-info">
            <h2>1. INFORMAÇÕES BÁSICAS</h2>
            <p class="subtitle">Adicione as principais informações do evento.</p>

            <div class="input-group">
                <label for="nome">Nome do Evento <span class="required">*</span></label>
                <input type="text" id="nome" placeholder="Nome do Evento" name="nome" required>
            </div>

            <div class="input-group image-upload">
                <label for="capa">Capa do Evento  <span class="required">*</span></label>
                <div class="upload-placeholder">
                    <span>Clique ou arraste a imagem aqui</span>
                    <input type="file" id="capa" name="capa" accept="image/*" required>
                </div>
                <div class="upload-info">
                    <p>A dimensão recomendada é de <strong>1600 x 838</strong></p>
                    <p>Formato <strong>JPEG, GIF ou PNG de no máximo 2MB.</strong></p>
                </div>
            </div>

            <div class="input-group">
                <label for="categoria">Escolha uma categoria para seu Evento <span class="required">*</span></label>
                <select id="categoria" name="categorias" required>
                    <option value="" disabled selected>Selecione uma categoria</option>
                    <?php 
                    if ($categorias && mysqli_num_rows($categorias) > 0) {
                        while ($row = mysqli_fetch_assoc($categorias)) {
                            echo "<option value='{$row['id_categoria']}'>{$row['categoria_evento']}</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhuma categoria disponível</option>";
                    }
                    ?>
                </select>
            </div>
        </section>

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
                        <input type="date" name="data_inicio_evento" id="data_inicio" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Horário de Início <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <input type="time" name="horario_inicio_evento" id="hora_inicio" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Data de Término <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </div>
                        <input type="date" name="data_fim_evento" id="data_fim" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Horário de Término <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <input type="time" name="horario_fim_evento" id="hora_fim" required>
                    </div>
                </div>
            </div>
        </section>

        <div class="card-section">
            <h2>3. DESCRIÇÃO DO EVENTO</h2>
            <p class="subtitle">Conte todos os detalhes do seu evento! <span class="required">*</span></p>
            <textarea id="descricao" class="description-textarea" placeholder="Adicione aqui a descrição do seu evento..." name="descricao" required></textarea>
        </div>

        <section class="card-section">
            <h2>4. ONDE O SEU EVENTO VAI ACONTECER?</h2>
            <p class="subtitle">Adicione as informações de localização.</p>

            <div class="address-grid">
                <div class="input-group col-medium">
                    <label>CEP <span class="required">*</span></label>
                    <input type="text" id="cep" placeholder="00000-000" name="cep" maxlength="9" oninput="mascaraCEP(this)" required>
                </div>
                <div class="input-group col-medium">
                    <label>Cidade <span class="required">*</span></label>
                    <input type="text" id="cidade" placeholder="Nome da cidade" name="cidade" required>
                </div>
                <div class="input-group col-medium">
                    <label>Bairro <span class="required">*</span></label>
                    <input type="text" id="bairro" placeholder="Nome do bairro" name="bairro" required>
                </div>
                <div class="input-group col-medium">
                    <label>Nome da Av./Rua <span class="required">*</span></label>
                    <input type="text" id="rua" placeholder="Nome da Av./Rua" name="rua" required>
                </div>
                <div class="input-group col-large">
                    <label>Ponto de Referência <span class="required">*</span></label>
                    <input type="text" id="ponto_referencia" placeholder="Ponto de referência" name="ponto_referencia" required>
                </div>
                <div class="input-group col-small">
                    <label>Número <span class="required">*</span></label>
                    <input type="text" id="numero" placeholder="Número" name="numero" required>
                </div>
            </div>
        </section>

        <section class="card-section">
            <h2>5. RESPONSABILIDADES</h2>
            <div class="checkbox-container">
                <input type="checkbox" id="termos" name="termos" required>
                <label for="termos">
                    Ao publicar este evento, declaro estar de acordo com os <a href="#">Termos de Uso</a>, bem como estar ciente da <a href="#">Política de Privacidade</a> e das obrigações legais aplicáveis.
                </label>
            </div>
        </section>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='index.php'">CANCELAR</button>
            <button type="button" class="btn-preview" onclick="preVisualizar()">PRÉ-VISUALIZAR</button>
            <button type="submit" name="status" value="rascunho" class="btn-draft">SALVAR RASCUNHO</button>
            <button type="submit" name="status" value="publicado" class="btn-send">PUBLICAR EVENTO</button>
        </div>
    </div> 
</form>

<script>
// --- BUSCA DE CEP ---
function mascaraCEP(input) {
    let v = input.value.replace(/\D/g, "").substring(0, 8);
    v = v.replace(/(\d{5})(\d)/, "$1-$2");
    input.value = v;

    if (v.replace("-", "").length === 8) {
        buscarCEP(v.replace("-", ""));
    }
}

function buscarCEP(valorCep) {
    let url = "https://viacep.com.br/ws/" + valorCep + "/json/";
    fetch(url)
        .then(res => res.json())
        .then(dados => {
            if (!dados.erro) {
                document.getElementById('rua').value = dados.logradouro;
                document.getElementById('bairro').value = dados.bairro;
                document.getElementById('cidade').value = dados.localidade;
                document.getElementById('numero').focus(); 
            }
        })
        .catch(error => console.error("Erro ao buscar CEP:", error));
}

// --- FUNÇÃO DE PRÉ-VISUALIZAÇÃO ---
function preVisualizar() {
    const nome = document.getElementById('nome').value || "Evento sem nome";
    const desc = document.getElementById('descricao').value || "Sem descrição disponível.";
    const cidade = document.getElementById('cidade').value || "Cidade não informada";
    const bairro = document.getElementById('bairro').value || "Bairro não informado";
    const data = document.getElementById('data_inicio').value || "Data não definida";
    const hora = document.getElementById('hora_inicio').value || "Horário não definido";

    // Cria uma pequena janela pop-up para simular como ficaria
    const popup = window.open('', 'Previa', 'width=600,height=700');
    popup.document.write(`
        <html>
        <head>
            <title>Prévia CityFlow</title>
            <style>
                body { background: #0d1117; color: white; font-family: 'Inter', sans-serif; padding: 30px; }
                .card { border: 2px solid #00d4ff; padding: 20px; border-radius: 15px; background: #161b22; }
                h1 { color: #00d4ff; margin-bottom: 5px; }
                .info { color: #8b949e; margin-bottom: 20px; font-size: 0.9rem; }
                p { line-height: 1.6; white-space: pre-wrap; }
                .btn { display: inline-block; padding: 10px 20px; background: #00d4ff; color: black; border-radius: 5px; text-decoration: none; font-weight: bold; margin-top: 20px; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="card">
                <div class="info">📅 ${data} às ${hora} | 📍 ${bairro}, ${cidade}</div>
                <h1>${nome}</h1>
                <p>${desc}</p>
                <div class="btn" onclick="window.close()">VOLTAR AO CADASTRO</div>
            </div>
        </body>
        </html>
    `);
}

// --- CONTROLE DOS ÍCONES DE DATA/HORA ---
document.querySelectorAll('.input-with-icon').forEach(container => {
    const iconBox = container.querySelector('.icon-box');
    const input = container.querySelector('input');
    if (iconBox && input) {
        iconBox.addEventListener('click', () => { input.showPicker(); });
    }
});
</script>

</body>
</html>