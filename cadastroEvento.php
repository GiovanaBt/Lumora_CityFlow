<?php

/* =========================================================
   CONEXÃO
========================================================= */

include 'Conexao.php';

/* =========================================================
   SESSÃO
========================================================= */

if (!isset($_SESSION)) {
    session_start();
}

/* =========================================================
   VERIFICA LOGIN
========================================================= */

if (!isset($_SESSION['usuario_id'])) {

    echo "
    <script>
        alert('Você precisa estar logado para acessar esta página.');
        window.location.href='index.php';
    </script>
    ";

    exit;
}

/* =========================================================
   BUSCA CATEGORIAS
========================================================= */

$categorias = mysqli_query(
    $conexao,
    "SELECT id_categoria, categoria_evento FROM categoria"
);

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
    <link rel="stylesheet" href="footer.css">
     <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="imgs/cityFlow.webp" alt="Logo CityFlow">
        </a>
    </div>

    <a href="mapa.php" target="_blank">
        <button class="botaoMapa">MAPA</button>
    </a>

    <nav>
        <ul class="menu">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="informacoes.php">INFORMAÇÕES</a></li>
            <li>
                <a href="cadastroEvento.php">
                    <i class="fa-solid fa-circle-plus"></i> DIVULGAR EVENTOS
                </a>
            </li>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <li class="perfil">
                    <a href="#">
                        <i class="fa-solid fa-circle-user"></i>
                        <?php echo $_SESSION['nome_usuario']; ?>
                    </a>
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
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <div class="main-container">
        
        <div class="form-fields">

            <section class="card-section">
                <h2>INFORMAÇÕES BÁSICAS</h2>
                <p class="subtitle">Preencha os dados principais do seu evento.</p>

                <div class="input-group">
                    <label for="nome">Nome do Evento <span class="required">*</span></label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Festival Cultural" required>
                </div>

                <div class="input-group image-upload">
                    <label>Capa do Evento <span class="required">*</span></label>
                    <div class="upload-flex">
                        <div class="upload-placeholder" id="drop-zone">
                            <span id="upload-text">Clique ou arraste a imagem aqui</span>
                            <img id="image-preview" src="" style="display:none;">
                            <input type="file" id="capa" name="capa" accept="image/*" onchange="gerenciarFoto(this)" required>
                        </div>

                        <div id="area-controles" class="controles-foto" style="display:none;">
                            <div class="botoes-foto-flex">
                                <button type="button" class="btn-foto-acao btn-trocar" onclick="document.getElementById('capa').click()">TROCAR IMAGEM</button>
                                <button type="button" class="btn-foto-acao btn-remover" onclick="limparFoto()">REMOVER</button>
                            </div>
                            <label class="label-acessibilidade">Descrição da imagem</label>
                            <textarea name="alt_text" id="alt_text" class="input-acessibilidade" placeholder="Descreva a imagem para acessibilidade..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label>Categoria <span class="required">*</span></label>
                    <select name="categorias" id="categorias" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <?php while ($row = mysqli_fetch_assoc($categorias)) { ?>
                            <option value="<?php echo $row['id_categoria']; ?>"><?php echo $row['categoria_evento']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </section>

            <section class="card-section card-classificacao">
                <h2>CLASSIFICAÇÃO INDICATIVA</h2>
                <p class="subtitle">Selecione a faixa etária recomendada para o evento.</p>
                <div class="classificacao-container">
                    <input type="radio" name="classificacao" id="class-l" value="L" required>
                    <label for="class-l" class="classificacao-box livre">L</label>

                    <input type="radio" name="classificacao" id="class-10" value="10">
                    <label for="class-10" class="classificacao-box c10">10</label>

                    <input type="radio" name="classificacao" id="class-12" value="12">
                    <label for="class-12" class="classificacao-box c12">12</label>

                    <input type="radio" name="classificacao" id="class-14" value="14">
                    <label for="class-14" class="classificacao-box c14">14</label>

                    <input type="radio" name="classificacao" id="class-16" value="16">
                    <label for="class-16" class="classificacao-box c16">16</label>

                    <input type="radio" name="classificacao" id="class-18" value="18">
                    <label for="class-18" class="classificacao-box c18">18</label>
                </div>
            </section>

            <section class="card-section">
                <h2>DATAS E HORÁRIOS</h2>
                <p class="subtitle">Adicione todas as datas do seu evento.</p>
                <div id="datas-container">
                    <div class="data-item">
                        <div class="input-group">
                            <label>Data do Evento</label>
                            <div class="input-with-icon">
                                <div class="icon-box"><i class="fa-regular fa-calendar"></i></div>
                                <input type="date" name="datas[]" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Hora Início</label>
                            <div class="input-with-icon">
                                <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                                <input type="time" name="horas_inicio[]" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Hora Fim</label>
                            <div class="input-with-icon">
                                <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                                <input type="time" name="horas_fim[]" required>
                            </div>
                        </div>
                        <button type="button" class="btn-remover-data"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
                <button type="button" class="btn-add-data" onclick="adicionarData()"><i class="fa-solid fa-plus"></i> ADICIONAR OUTRA DATA</button>
            </section>

            <section class="card-section">
                <h2>DESCRIÇÃO DO EVENTO</h2>
                <p class="subtitle">Coloque informações referente a organização do seu evento.</p>
                <div class="input-group">
                    <textarea id="descricao" name="descricao" rows="6" placeholder="Ex: Evento de tecnologia com palestras, networking e apresentações." required></textarea>
                </div>
            </section>

            <section class="card-section">
                <h2>ONDE O EVENTO VAI ACONTECER?</h2>
                <p class="subtitle">Adicione as informações de localização.</p>
                <div class="address-grid">
                    <div class="input-group col-medium">
                        <label>CEP <span class="required">*</span></label>
                        <input type="text" id="cep" name="cep" placeholder="00000-000" maxlength="9" required>
                    </div>
                    <div class="input-group col-medium">
                        <label>Cidade <span class="required">*</span></label>
                        <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo" required>
                    </div>
                    <div class="input-group col-medium">
                        <label>Bairro <span class="required">*</span></label>
                        <input type="text" id="bairro" name="bairro" placeholder="Ex: Centro" required>
                    </div>
                    <div class="input-group col-medium">
                        <label>Rua <span class="required">*</span></label>
                        <input type="text" id="rua" name="rua" placeholder="Ex: Avenida Paulista" required>
                    </div>
                    <div class="input-group col-large">
                        <label>Ponto de Referência</label>
                        <input type="text" id="ponto_referencia" name="ponto_referencia" placeholder="Ex: Próximo ao shopping">
                    </div>
                    <div class="input-group col-small">
                        <label>Número <span class="required">*</span></label>
                        <input type="text" id="numero" name="numero" placeholder="Ex: 1500" required>
                    </div>
                </div>
            </section>

            <section class="card-section">
                <h2>RESPONSABILIDADES</h2>
                <div class="checkbox-container">
                    <input type="checkbox" id="termos" required>
                    <label for="termos">
                        Ao publicar este evento, declaro estar de acordo com os <a href="informacoes.php#termosUsos">Termos de Uso</a> e com a <a href="informacoes.php">Política de Privacidade</a>.
                    </label>
                </div>
            </section>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.location.href='index.php'">CANCELAR</button>
                <button type="button" class="btn-preview" onclick="abrirPreVisualizacao(event)">PRÉ-VISUALIZAR</button>
                <button type="submit" class="btn-send">PUBLICAR EVENTO</button>
            </div>

        </div>

    </div>
</form>


<script>
/* =========================================================
   FOTO & PREVIEW LIVE EM TEMPO REAL
========================================================= */
function gerenciarFoto(input){
    const preview = document.getElementById('image-preview');
    const texto = document.getElementById('upload-text');
    const controles = document.getElementById('area-controles');

    if(input.files && input.files[0]){
        const reader = new FileReader();

        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = 'block';
            texto.style.display = 'none';
            controles.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function limparFoto(){
    document.getElementById('capa').value = "";
    document.getElementById('image-preview').src = "";
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('upload-text').style.display = 'block';
    document.getElementById('area-controles').style.display = 'none';
    document.getElementById('alt_text').value = "";
}

/* =========================================================
   VIA CEP
========================================================= */
document.getElementById('cep').addEventListener('blur', function(){
    let cep = this.value.replace(/\D/g,'');
    if(cep.length == 8){
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(r => r.json())
        .then(d => {
            if(!d.erro){
                document.getElementById('cidade').value = d.localidade;
                document.getElementById('bairro').value = d.bairro;
                document.getElementById('rua').value = d.logradouro;
            }
        });
    }
});

/* =========================================================
   ADICIONAR/REMOVER DATA
========================================================= */
function adicionarData(){
    const container = document.getElementById('datas-container');
    const div = document.createElement('div');
    div.classList.add('data-item');
    div.innerHTML = `
        <div class="input-group">
            <label>Data do Evento</label>
            <div class="input-with-icon">
                <div class="icon-box"><i class="fa-regular fa-calendar"></i></div>
                <input type="date" name="datas[]" required>
            </div>
        </div>
        <div class="input-group">
            <label>Hora Início</label>
            <div class="input-with-icon">
                <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                <input type="time" name="horas_inicio[]" required>
            </div>
        </div>
        <div class="input-group">
            <label>Hora Fim</label>
            <div class="input-with-icon">
                <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                <input type="time" name="horas_fim[]" required>
            </div>
        </div>
        <button type="button" class="btn-remover-data"><i class="fa-solid fa-trash"></i></button>
    `;
    container.appendChild(div);
}

document.addEventListener('click', e => {
    if(e.target.closest('.btn-remover-data')){
        const item = e.target.closest('.data-item');
        if(document.querySelectorAll('.data-item').length > 1){
            item.remove();
        }
    }
});

/* =========================================================
   LOGICA DA PRÉ-VISUALIZAÇÃO (ABRE EM NOVA ABA)
========================================================= */
function abrirPreVisualizacao(event) {
    if (event) event.preventDefault();

    // Captura a classificação selecionada (Radio button)
    const classSelecionada = document.querySelector('input[name="classificacao"]:checked');
    const classificacaoValue = classSelecionada ? classSelecionada.value : 'L';

    // Captura todas as datas e horários inseridos
    const datas = Array.from(document.querySelectorAll('input[name="datas[]"]')).map(el => el.value);
    const horasInicio = Array.from(document.querySelectorAll('input[name="horas_inicio[]"]')).map(el => el.value);
    const horasFim = Array.from(document.querySelectorAll('input[name="horas_fim[]"]')).map(el => el.value);

    // Estrutura o objeto com todos os dados atuais do formulário
    const dadosEvento = {
        nome: document.getElementById('nome').value || "Título Provisório",
        descricao: document.getElementById('descricao').value || "Sem descrição disponível.",
        cep: document.getElementById('cep').value || "00000-000",
        cidade: document.getElementById('cidade').value || "",
        bairro: document.getElementById('bairro').value || "",
        rua: document.getElementById('rua').value || "",
        numero: document.getElementById('numero').value || "",
        ponto_referencia: document.getElementById('ponto_referencia').value || "",
        classificacao: classificacaoValue,
        datas: datas,
        horasInicio: horasInicio,
        horasFim: horasFim,
        imagem: document.getElementById('image-preview').src || ""
    };

    // Salva na sessão temporária do navegador
    sessionStorage.setItem('dados_preview_evento', JSON.stringify(dadosEvento));

    // Abre a sua página de visualização final em uma nova aba
    window.open('visualizarEvento.html', '_blank');
}
</script>
<!-- =========================================================
   FOOTER
========================================================= -->
<?php include 'footer.php'; ?>
</body>
</html>