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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityFlow - Cadastro de Eventos</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="cadastroEvento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>  
<header>
    <div class="logo">
        <a href="index.php"><img src="imgs/cityFlow.webp" alt="Logo CityFlow"></a>
    </div>
    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>
    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="informacoes.php">INFORMAÇÕES</a></li>
            <li><a href="cadastroEvento.php"><i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS</a></li>
            
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#"><i class="fa-solid fa-circle-user"></i> <?php echo $_SESSION['nome_usuario']; ?></a>
                    <ul class="submenu">
                        <li><a href="minhaConta.php"><i class="fa-solid fa-user-gear"></i> Minha Conta</a></li>
                        <li><a href="minhaConta.php#favoritos"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                        <li><a href="ajuda.php"><i class="fa-solid fa-circle-question"></i> Central de ajuda</a></li>
                        <li><a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                    </ul>
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
    <div class="botoes-foto-flex">
        <button type="button" class="btn-foto-acao btn-trocar" onclick="document.getElementById('capa').click()">TROCAR IMAGEM</button>
        <button type="button" class="btn-foto-acao btn-remover" onclick="limparFoto()">REMOVER</button>
    </div>
    
    <label class="label-acessibilidade">Descrição da imagem (acessibilidade)</label>
    
    <textarea name="alt_text" id="alt_text" placeholder="Descreva a imagem..." class="input-acessibilidade"></textarea>
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

        <div class="campo-cadastro">
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
                    Ao publicar este evento, declaro estar de acordo com os <a href="informacoes.php#termosUsos">Termos de Uso</a>, bem como estar ciente da <a href="informacoes.php">Política de Privacidade</a>.
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
</script>
</body>
</html>