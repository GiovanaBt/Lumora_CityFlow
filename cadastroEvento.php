<?php
include 'Conexao.php';
if (!isset($_SESSION)) { session_start(); }

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
    <style>
        .upload-placeholder { position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 200px; border: 2px dashed #30363d; border-radius: 10px; background: #0d1117; transition: 0.3s; }
        .upload-placeholder:hover { border-color: #00d4ff; }
        #image-preview { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; display: none; }
        #upload-text { z-index: 2; position: relative; color: #6e7681; font-size: 0.9rem; }
        .upload-placeholder input[type="file"] { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 3; }
        
        .controles-foto { display: none; flex: 1; margin-left: 20px; min-width: 250px; text-align: left; }
        .btn-foto-acao { background: transparent; border-radius: 20px; padding: 8px 15px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-bottom: 15px; text-transform: uppercase; font-size: 0.75rem; }
        .btn-foto-acao:hover { transform: scale(1.05); opacity: 0.8; }

        .modal-previa { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .modal-card { background: #161b22; border: 1px solid #00d4ff; width: 90%; max-width: 400px; border-radius: 20px; overflow: hidden; box-shadow: 0 0 30px rgba(0, 212, 255, 0.3); }
    </style>
</head>
<body>  
<header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp"></a>
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
            <li><a href="#informacoes">INFORMAÇÕES</a></li>
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
            <div class="input-group">
                <label for="nome">Nome do Evento <span class="required">*</span></label>
                <input type="text" id="nome" placeholder="Ex: Batalha de Rima" name="nome" required>
            </div>

            <div class="input-group image-upload" style="text-align: left;">
                <label style="display: block; width: 100%; text-align: left;"> Capa do Evento <span class="required">*</span></label>
                <div style="display: flex; align-items: flex-start; flex-wrap: wrap; gap: 20px; width: 100%; text-align: left;">
                    <div class="upload-placeholder" id="drop-zone" style="flex: 0 0 300px; margin-left: 0;">
                        <span id="upload-text">Clique ou arraste a imagem aqui</span>
                        <img id="image-preview" src="">
                        <input type="file" id="capa" name="capa" accept="image/*" onchange="gerenciarFoto(this)">
                    </div>

                    <div id="area-controles" class="controles-foto">
                        <div style="display: flex; gap: 10px;">
                            <button type="button" class="btn-foto-acao" style="border: 1px solid #00d4ff; color: #00d4ff;" onclick="document.getElementById('capa').click()">TROCAR IMAGEM</button>
                            <button type="button" class="btn-foto-acao" style="border: 1px solid #ff4b4b; color: #ff4b4b;" onclick="limparFoto()">REMOVER</button>
                        </div>
                        <label style="font-size: 0.85rem; color: #8b949e; display: block; margin-bottom: 5px;">Descrição da imagem (acessibilidade)</label>
                        <textarea name="alt_text" id="alt_text" placeholder="Descreva a imagem..." style="width: 100%; height: 70px; background: #0d1117; color: white; border: 1px solid #30363d; padding: 10px; border-radius: 8px; resize: none;"></textarea>
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="categoria">Categoria <span class="required">*</span></label>
                <select id="categoria" name="categorias" required>
                    <option value="" disabled selected>Selecione uma categoria</option>
                    <?php while ($row = mysqli_fetch_assoc($categorias)) { echo "<option value='{$row['id_categoria']}'>{$row['categoria_evento']}</option>"; } ?>
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
                        <div class="icon-box"><i class="fa-regular fa-calendar"></i></div>
                        <input type="date" name="data_inicio_evento" id="data_inicio" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>Horário de Início <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                        <input type="time" name="horario_inicio_evento" id="hora_inicio" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>Data de Término <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box"><i class="fa-regular fa-calendar"></i></div>
                        <input type="date" name="data_fim_evento" id="data_fim" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>Horário de Término <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                        <input type="time" name="horario_fim_evento" id="hora_fim" required>
                    </div>
                </div>
            </div>
        </section>

        <<div class="campo-cadastro">
    <label>3. DESCRIÇÃO DO EVENTO</label>
    <textarea name="descricao" rows="6" placeholder="Descreva as atividades, cronograma e detalhes..."></textarea>
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
                    Ao publicar este evento, declaro estar de acordo com os <a href="#">Termos de Uso</a>, bem como estar ciente da <a href="#">Política de Privacidade</a>.
                </label>
            </div>
        </section>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='index.php'">CANCELAR</button>
            <button type="button" class="btn-preview" onclick="abrirPrevia()">PRÉ-VISUALIZAR</button>
            <button type="submit" name="status" value="publicado" class="btn-send">PUBLICAR EVENTO</button>
        </div>
    </div> 
</form>

<div id="modalPrevia" class="modal-previa">
    <div class="modal-card">
        <img id="p-img" src="" style="width:100%; height:180px; object-fit:cover; display:none;">
        <div style="padding: 20px;">
            <h2 id="p-nome" style="color:#00d4ff; margin:0; font-size: 1.4rem;"></h2>
            <p id="p-data" style="color:#8b949e; font-size:0.8rem; margin:10px 0;"></p>
            <p id="p-desc" style="color:white; font-size:0.9rem; line-height:1.4; max-height:120px; overflow-y:auto;"></p>
            <button type="button" onclick="fecharPrevia()" style="width:100%; padding:12px; background:#00d4ff; border:none; border-radius:100px; color:#000; font-weight:bold; margin-top:15px; cursor:pointer;">FECHAR</button>
        </div>
    </div>
</div>

<script>
// LÓGICA DA FOTO
function gerenciarFoto(input) {
    const preview = document.getElementById('image-preview');
    const texto = document.getElementById('upload-text');
    const controles = document.getElementById('area-controles');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { 
            preview.src = e.target.result; 
            preview.style.display = 'block'; 
            texto.style.display = 'none'; 
            controles.style.display = 'block'; 
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function limparFoto() {
    document.getElementById('capa').value = "";
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('upload-text').style.display = 'block';
    document.getElementById('area-controles').style.display = 'none';
}

// LÓGICA DO CEP (BUSCA AUTOMÁTICA)
document.getElementById('cep').addEventListener('blur', function() {
    let cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(dados => {
                if (!dados.erro) {
                    document.getElementById('cidade').value = dados.localidade;
                    document.getElementById('bairro').value = dados.bairro;
                    document.getElementById('rua').value = dados.logradouro;
                    document.getElementById('numero').focus();
                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(() => alert("Erro ao buscar o CEP."));
    }
});

function mascaraCEP(input) {
    let v = input.value.replace(/\D/g, "").substring(0, 8);
    v = v.replace(/(\d{5})(\d)/, "$1-$2");
    input.value = v;
}

// LÓGICA DA PRÉVIA
function abrirPrevia() {
    document.getElementById('p-nome').innerText = document.getElementById('nome').value || "Título";
    document.getElementById('p-desc').innerText = document.getElementById('descricao').value || "Sem descrição.";
    document.getElementById('p-data').innerText = `📅 ${document.getElementById('data_inicio').value} | 📍 ${document.getElementById('cidade').value}`;
    const foto = document.getElementById('image-preview');
    const pImg = document.getElementById('p-img');
    if(foto.style.display !== 'none') { pImg.src = foto.src; pImg.style.display = 'block'; }
    document.getElementById('modalPrevia').style.display = 'flex';
}

function fecharPrevia() { document.getElementById('modalPrevia').style.display = 'none'; }
</script>
</body>
</html>