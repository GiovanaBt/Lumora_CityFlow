<?php

/* =========================================================
   CONEXÃO
========================================================= */

include 'Conexao.php';


/* =========================================================
   SESSÃO
========================================================= */

if (session_status() === PHP_SESSION_NONE) {
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
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="cadastroEvento.css">

    <link rel="shortcut icon" href="imgs/logoCityFlow.webp">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header>

    <div class="logo">

        <a href="index.php">

            <img
                src="imgs/cityFlow.webp"
                alt="Logo CityFlow"
            >

        </a>

    </div>


    <a href="mapa.php" target="_blank">

        <button class="botaoMapa">
            MAPA
        </button>

    </a>


    <nav>

        <ul class="menu">

            <li>
                <a href="index.php">
                    INÍCIO
                </a>
            </li>


            <li>
                <a href="informacoes.php">
                    INFORMAÇÕES
                </a>
            </li>


            <li>

                <a href="cadastroEvento.php">

                    <i class="fa-solid fa-circle-plus"></i>

                    DIVULGAR EVENTOS

                </a>

            </li>


            <?php if (isset($_SESSION['usuario_id'])): ?>

                <li class="perfil">

                    <a href="#">

                        <i class="fa-solid fa-circle-user"></i>

                        <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?>

                    </a>


                    <ul class="submenu">

                        <li>

                            <a href="minhaConta.php">

                                <i class="fa-solid fa-user-gear"></i>

                                Minha Conta

                            </a>

                        </li>


                        <li>

                            <a href="minhaConta.php#favoritos">

                                <i class="fa-solid fa-heart"></i>

                                Favoritos

                            </a>

                        </li>


                        <li>

                            <a href="ajuda.php">

                                <i class="fa-solid fa-circle-question"></i>

                                Central de ajuda

                            </a>

                        </li>


                        <li>

                            <a
                                href="logout.php"
                                class="btn-sair"
                            >

                                <i class="fa-solid fa-right-from-bracket"></i>

                                Sair

                            </a>

                        </li>

                    </ul>

                </li>

            <?php endif; ?>

        </ul>

    </nav>

</header>



<!-- =========================================================
     TÍTULO DA PÁGINA
========================================================= -->

<div class="page-title">

    <div class="page-title-icon">

        <i class="fa-solid fa-calendar-plus"></i>

    </div>


    <div class="page-title-content">

        <h1>
            CADASTRO DE EVENTO
        </h1>

        <p>
            Divulgue seu evento e faça parte do CityFlow.
        </p>

    </div>

</div>



<!-- =========================================================
     FORMULÁRIO
========================================================= -->

<form
    id="formCadastroEvento"
    action="enviarCadastroEvento.php"
    method="POST"
    enctype="multipart/form-data"
>


    <!-- =====================================================
         COORDENADAS
    ====================================================== -->

    <input
        type="hidden"
        name="latitude"
        id="latitude"
    >


    <input
        type="hidden"
        name="longitude"
        id="longitude"
    >



    <div class="main-container">


        <div class="form-fields">


            <!-- =================================================
                 INFORMAÇÕES BÁSICAS
            ================================================== -->

            <section class="card-section">

                <h2>
                    INFORMAÇÕES BÁSICAS
                </h2>


                <p class="subtitle">
                    Preencha os dados principais do seu evento.
                </p>


                <div class="input-group">

                    <label for="nome">

                        Nome do Evento

                        <span class="required">
                            *
                        </span>

                    </label>


                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        placeholder="Ex: Festival Cultural"
                        required
                    >

                </div>



                <div class="input-group">

                    <label for="subtitulo">
                        Subtítulo
                    </label>


                    <input
                        type="text"
                        id="subtitulo"
                        name="subtitulo"
                        placeholder="Digite um subtítulo para o evento"
                    >

                </div>



                <div class="input-group image-upload">

                    <label>

                        Capa do Evento

                        <span class="required">
                            *
                        </span>

                    </label>


                    <div class="upload-flex">


                        <div
                            class="upload-placeholder"
                            id="drop-zone"
                        >

                            <span id="upload-text">

                                Clique ou arraste a imagem aqui

                            </span>


                            <img
                                id="image-preview"
                                src=""
                                style="display:none;"
                                alt="Pré-visualização da imagem"
                            >


                            <input
                                type="file"
                                id="capa"
                                name="capa"
                                accept="image/*"
                                onchange="gerenciarFoto(this)"
                                required
                            >

                        </div>



                        <div
                            id="area-controles"
                            class="controles-foto"
                            style="display:none;"
                        >


                            <div class="botoes-foto-flex">


                                <button
                                    type="button"
                                    class="btn-foto-acao btn-trocar"
                                    onclick="document.getElementById('capa').click()"
                                >

                                    TROCAR IMAGEM

                                </button>


                                <button
                                    type="button"
                                    class="btn-foto-acao btn-remover"
                                    onclick="limparFoto()"
                                >

                                    REMOVER

                                </button>


                            </div>


                            <label class="label-acessibilidade">

                                Descrição da imagem

                            </label>


                            <textarea
                                name="alt_text"
                                id="alt_text"
                                class="input-acessibilidade"
                                placeholder="Descreva a imagem para acessibilidade..."
                            ></textarea>


                        </div>

                    </div>

                </div>



                <div class="input-group">

                    <label>

                        Categoria

                        <span class="required">
                            *
                        </span>

                    </label>


                    <select
                        name="categorias"
                        id="categorias"
                        required
                    >

                        <option
                            value=""
                            disabled
                            selected
                        >

                            Selecione uma categoria

                        </option>


                        <?php while ($row = mysqli_fetch_assoc($categorias)): ?>

                            <option
                                value="<?php echo $row['id_categoria']; ?>"
                            >

                                <?php echo htmlspecialchars($row['categoria_evento']); ?>

                            </option>

                        <?php endwhile; ?>


                    </select>

                </div>

            </section>



            <!-- =================================================
                 CLASSIFICAÇÃO
            ================================================== -->

            <section class="card-section card-classificacao">

                <h2>
                    CLASSIFICAÇÃO INDICATIVA
                </h2>


                <p class="subtitle">

                    Selecione a faixa etária recomendada para o evento.

                </p>


                <div class="classificacao-container">


                    <input
                        type="radio"
                        name="classificacao"
                        id="class-l"
                        value="L"
                        required
                    >

                    <label
                        for="class-l"
                        class="classificacao-box livre"
                    >
                        L
                    </label>



                    <input
                        type="radio"
                        name="classificacao"
                        id="class-10"
                        value="10"
                    >

                    <label
                        for="class-10"
                        class="classificacao-box c10"
                    >
                        10
                    </label>



                    <input
                        type="radio"
                        name="classificacao"
                        id="class-12"
                        value="12"
                    >

                    <label
                        for="class-12"
                        class="classificacao-box c12"
                    >
                        12
                    </label>



                    <input
                        type="radio"
                        name="classificacao"
                        id="class-14"
                        value="14"
                    >

                    <label
                        for="class-14"
                        class="classificacao-box c14"
                    >
                        14
                    </label>



                    <input
                        type="radio"
                        name="classificacao"
                        id="class-16"
                        value="16"
                    >

                    <label
                        for="class-16"
                        class="classificacao-box c16"
                    >
                        16
                    </label>



                    <input
                        type="radio"
                        name="classificacao"
                        id="class-18"
                        value="18"
                    >

                    <label
                        for="class-18"
                        class="classificacao-box c18"
                    >
                        18
                    </label>


                </div>

            </section>



            <!-- =================================================
                 DATAS E HORÁRIOS
            ================================================== -->

            <section class="card-section">

                <h2>
                    DATAS E HORÁRIOS
                </h2>


                <p class="subtitle">

                    Adicione todas as datas do seu evento.

                </p>


                <div id="datas-container">


                    <div class="data-item">


                        <div class="input-group">

                            <label>
                                Data do Evento
                            </label>


                            <div class="input-with-icon">

                                <div class="icon-box">

                                    <i class="fa-regular fa-calendar"></i>

                                </div>


                                <input
                                    type="date"
                                    name="datas[]"
                                    min="<?= date('Y-m-d'); ?>"
                                    required
                                >

                            </div>

                        </div>



                        <div class="input-group">

                            <label>
                                Hora Início
                            </label>


                            <div class="input-with-icon">

                                <div class="icon-box">

                                    <i class="fa-regular fa-clock"></i>

                                </div>


                                <input
                                    type="time"
                                    name="horas_inicio[]"
                                    required
                                >

                            </div>

                        </div>



                        <div class="input-group">

                            <label>
                                Hora Fim
                            </label>


                            <div class="input-with-icon">

                                <div class="icon-box">

                                    <i class="fa-regular fa-clock"></i>

                                </div>


                                <input
                                    type="time"
                                    name="horas_fim[]"
                                    required
                                >

                            </div>

                        </div>



                        <button
                            type="button"
                            class="btn-remover-data"
                        >

                            <i class="fa-solid fa-trash"></i>

                        </button>


                    </div>

                </div>



                <button
                    type="button"
                    class="btn-add-data"
                    onclick="adicionarData()"
                >

                    <i class="fa-solid fa-plus"></i>

                    ADICIONAR OUTRA DATA

                </button>


            </section>



            <!-- =================================================
                 DESCRIÇÃO
            ================================================== -->

            <section class="card-section">

                <h2>
                    DESCRIÇÃO DO EVENTO
                </h2>


                <p class="subtitle">

                    Coloque informações referentes à organização do seu evento.

                </p>


                <div class="input-group">

                    <textarea
                        id="descricao"
                        name="descricao"
                        rows="6"
                        placeholder="Ex: Evento de tecnologia com palestras, networking e apresentações."
                        required
                    ></textarea>

                </div>

            </section>



            <!-- =================================================
                 LOCALIZAÇÃO
            ================================================== -->

            <section class="card-section">

                <h2>
                    ONDE O EVENTO VAI ACONTECER?
                </h2>


                <p class="subtitle">

                    Adicione as informações de localização.

                </p>


                <div class="address-grid">


                    <div class="input-group col-medium">

                        <label for="cep">

                            CEP

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="cep"
                            name="cep"
                            placeholder="00000-000"
                            maxlength="9"
                            required
                        >

                    </div>



                    <div class="input-group col-medium">

                        <label for="cidade">

                            Cidade

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="cidade"
                            name="cidade"
                            placeholder="Ex: Jacareí"
                            required
                        >

                    </div>



                    <div class="input-group col-medium">

                        <label for="bairro">

                            Bairro

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="bairro"
                            name="bairro"
                            placeholder="Ex: Centro"
                            required
                        >

                    </div>



                    <div class="input-group col-medium">

                        <label for="rua">

                            Rua

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="rua"
                            name="rua"
                            placeholder="Ex: Avenida Paulista"
                            required
                        >

                    </div>



                    <div class="input-group col-large">

                        <label for="ponto_referencia">

                            Ponto de Referência

                        </label>


                        <input
                            type="text"
                            id="ponto_referencia"
                            name="ponto_referencia"
                            placeholder="Ex: Próximo ao shopping"
                        >

                    </div>



                    <div class="input-group col-small">

                        <label for="numero">

                            Número

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="numero"
                            name="numero"
                            placeholder="Ex: 1500"
                            required
                        >

                    </div>


                </div>

            </section>



            <!-- =================================================
                 RESPONSABILIDADES
            ================================================== -->

            <section class="card-section">

                <h2>
                    RESPONSABILIDADES
                </h2>


                <div class="checkbox-container">

                    <input
                        type="checkbox"
                        id="termos"
                        required
                    >


                    <label for="termos">

                        Ao publicar este evento, declaro estar de acordo com os

                        <a href="informacoes.php#termosUsos">
                            Termos de Uso
                        </a>

                        e com a

                        <a href="informacoes.php">
                            Política de Privacidade
                        </a>.

                    </label>

                </div>

            </section>



            <!-- =================================================
                 BOTÕES
            ================================================== -->

            <div class="form-actions">


                <button
                    type="button"
                    class="btn-cancel"
                    onclick="window.location.href='index.php'"
                >

                    CANCELAR

                </button>



                <button
                    type="button"
                    class="btn-preview"
                    onclick="abrirPreVisualizacao(event)"
                >

                    PRÉ-VISUALIZAR

                </button>



                <button
                    type="submit"
                    class="btn-send"
                    id="btnPublicar"
                >

                    PUBLICAR EVENTO

                </button>


            </div>


        </div>

    </div>

</form>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>


/* =========================================================
   FOTO
========================================================= */

function gerenciarFoto(input) {

    const preview =
        document.getElementById('image-preview');

    const texto =
        document.getElementById('upload-text');

    const controles =
        document.getElementById('area-controles');


    if (input.files && input.files[0]) {

        const reader =
            new FileReader();


        reader.onload = function(e) {

            preview.src =
                e.target.result;

            preview.style.display =
                'block';

            texto.style.display =
                'none';

            controles.style.display =
                'block';

        };


        reader.readAsDataURL(
            input.files[0]
        );

    }

}



function limparFoto() {

    document.getElementById('capa').value = "";

    document.getElementById('image-preview').src = "";

    document.getElementById('image-preview').style.display = "none";

    document.getElementById('upload-text').style.display = "block";

    document.getElementById('area-controles').style.display = "none";

    document.getElementById('alt_text').value = "";

}



/* =========================================================
   VIA CEP
========================================================= */

document
.getElementById('cep')
.addEventListener('blur', function() {


    let cep =
        this.value.replace(/\D/g, '');


    if (cep.length !== 8) {

        return;

    }


    fetch(
        `https://viacep.com.br/ws/${cep}/json/`
    )

    .then(response =>
        response.json()
    )

    .then(dados => {


        if (dados.erro) {

            alert("CEP não encontrado.");

            return;

        }


        document.getElementById('cidade').value =
            dados.localidade || "";


        document.getElementById('bairro').value =
            dados.bairro || "";


        document.getElementById('rua').value =
            dados.logradouro || "";


        /*
         * Limpa as coordenadas antigas.
         * Elas serão buscadas novamente
         * quando o formulário for enviado.
         */

        document.getElementById('latitude').value = "";

        document.getElementById('longitude').value = "";

    })

    .catch(erro => {

        console.error(
            "Erro ao consultar o ViaCEP:",
            erro
        );

    });

});



/* =========================================================
   BUSCAR LATITUDE E LONGITUDE
========================================================= */

async function buscarCoordenadas() {


    const rua =
        document.getElementById('rua').value.trim();


    const numero =
        document.getElementById('numero').value.trim();


    const bairro =
        document.getElementById('bairro').value.trim();


    const cidade =
        document.getElementById('cidade').value.trim();


    const cep =
        document.getElementById('cep').value.trim();


    if (!rua || !cidade) {

        return false;

    }


    /*
     * Monta o endereço completo.
     */

    let endereco =
        `${rua}, ${numero}, ${bairro}, ${cidade}, ${cep}, Brasil`;


    console.log(
        "Buscando endereço:",
        endereco
    );


    try {


        const url =
            "https://nominatim.openstreetmap.org/search" +
            "?format=json" +
            "&limit=1" +
            "&countrycodes=br" +
            "&q=" +
            encodeURIComponent(endereco);


        const resposta =
            await fetch(url);


        if (!resposta.ok) {

            console.error(
                "Erro HTTP:",
                resposta.status
            );

            return false;

        }


        const dados =
            await resposta.json();


        console.log(
            "Resultado da busca:",
            dados
        );


        if (dados.length === 0) {

            /*
             * Se o endereço completo não for encontrado,
             * tenta novamente somente com rua + cidade.
             */

            const enderecoSimplificado =
                `${rua}, ${cidade}, Brasil`;


            const urlSimplificada =
                "https://nominatim.openstreetmap.org/search" +
                "?format=json" +
                "&limit=1" +
                "&countrycodes=br" +
                "&q=" +
                encodeURIComponent(enderecoSimplificado);


            const resposta2 =
                await fetch(urlSimplificada);


            const dados2 =
                await resposta2.json();


            if (dados2.length === 0) {

                return false;

            }


            document.getElementById('latitude').value =
                dados2[0].lat;


            document.getElementById('longitude').value =
                dados2[0].lon;


            console.log(
                "Latitude:",
                dados2[0].lat
            );


            console.log(
                "Longitude:",
                dados2[0].lon
            );


            return true;

        }


        /*
         * Encontrou o endereço.
         */

        document.getElementById('latitude').value =
            dados[0].lat;


        document.getElementById('longitude').value =
            dados[0].lon;


        console.log(
            "Latitude:",
            dados[0].lat
        );


        console.log(
            "Longitude:",
            dados[0].lon
        );


        return true;


    } catch (erro) {


        console.error(
            "Erro ao buscar coordenadas:",
            erro
        );


        return false;

    }

}



/* =========================================================
   ENVIO DO FORMULÁRIO
========================================================= */

const formulario =
    document.getElementById('formCadastroEvento');


formulario.addEventListener(
    'submit',
    async function(event) {


        /*
         * Impede o envio imediato.
         */

        event.preventDefault();


        /*
         * Verifica se o formulário está preenchido.
         */

        if (!this.checkValidity()) {

            this.reportValidity();

            return;

        }


        const botao =
            document.getElementById('btnPublicar');


        /*
         * Evita que o usuário clique várias vezes.
         */

        botao.disabled = true;

        botao.innerText =
            "LOCALIZANDO ENDEREÇO...";


        /*
         * Busca latitude e longitude.
         */

        const encontrou =
            await buscarCoordenadas();


        if (!encontrou) {


            alert(
                "Não foi possível localizar o endereço informado.\n\n" +
                "Verifique CEP, rua, número, bairro e cidade."
            );


            botao.disabled = false;

            botao.innerText =
                "PUBLICAR EVENTO";


            return;

        }


        /*
         * Mostra no console as coordenadas
         * que serão enviadas para o PHP.
         */

        console.log(
            "================================"
        );

        console.log(
            "COORDENADAS DO EVENTO"
        );

        console.log(
            "Latitude:",
            document.getElementById('latitude').value
        );

        console.log(
            "Longitude:",
            document.getElementById('longitude').value
        );

        console.log(
            "================================"
        );


        botao.innerText =
            "PUBLICANDO...";


        /*
         * Agora envia o formulário.
         */

        this.submit();

    }
);



/* =========================================================
   ADICIONAR OUTRA DATA
========================================================= */

function adicionarData() {


    const container =
        document.getElementById(
            'datas-container'
        );


    /*
     * Pega a última data adicionada.
     */

    const ultimaData =
        container.querySelector(
            '.data-item:last-child'
        );


    const data =
        ultimaData.querySelector(
            'input[name="datas[]"]'
        );


    const horaInicio =
        ultimaData.querySelector(
            'input[name="horas_inicio[]"]'
        );


    const horaFim =
        ultimaData.querySelector(
            'input[name="horas_fim[]"]'
        );


    /*
     * Não deixa criar outra linha
     * se a anterior estiver vazia.
     */

    if (
        !data.value ||
        !horaInicio.value ||
        !horaFim.value
    ) {


        alert(
            "Preencha a data, a hora de início e a hora de fim antes de adicionar outra data."
        );


        return;

    }


    /*
     * Cria nova linha.
     */

    const div =
        document.createElement('div');


    div.classList.add(
        'data-item'
    );


    div.innerHTML = `

        <div class="input-group">

            <label>
                Data do Evento
            </label>

            <div class="input-with-icon">

                <div class="icon-box">

                    <i class="fa-regular fa-calendar"></i>

                </div>

                <input
                    type="date"
                    name="datas[]"
                    min="<?= date('Y-m-d'); ?>"
                    required
                >

            </div>

        </div>


        <div class="input-group">

            <label>
                Hora Início
            </label>

            <div class="input-with-icon">

                <div class="icon-box">

                    <i class="fa-regular fa-clock"></i>

                </div>

                <input
                    type="time"
                    name="horas_inicio[]"
                    required
                >

            </div>

        </div>


        <div class="input-group">

            <label>
                Hora Fim
            </label>

            <div class="input-with-icon">

                <div class="icon-box">

                    <i class="fa-regular fa-clock"></i>

                </div>

                <input
                    type="time"
                    name="horas_fim[]"
                    required
                >

            </div>

        </div>


        <button
            type="button"
            class="btn-remover-data"
        >

            <i class="fa-solid fa-trash"></i>

        </button>

    `;


    container.appendChild(div);

}



/* =========================================================
   REMOVER DATA
========================================================= */

document.addEventListener(
    'click',
    function(e) {


        const botao =
            e.target.closest(
                '.btn-remover-data'
            );


        if (!botao) {

            return;

        }


        const item =
            botao.closest(
                '.data-item'
            );


        const quantidade =
            document.querySelectorAll(
                '.data-item'
            ).length;


        /*
         * Mantém pelo menos uma data.
         */

        if (quantidade > 1) {

            item.remove();

        }

    }
);



/* =========================================================
   PRÉ-VISUALIZAÇÃO
========================================================= */

function abrirPreVisualizacao(event) {


    if (event) {

        event.preventDefault();

    }


    const classSelecionada =
        document.querySelector(
            'input[name="classificacao"]:checked'
        );


    const classificacaoValue =
        classSelecionada
            ? classSelecionada.value
            : 'L';


    const datas =
        Array.from(
            document.querySelectorAll(
                'input[name="datas[]"]'
            )
        ).map(
            el => el.value
        );


    const horasInicio =
        Array.from(
            document.querySelectorAll(
                'input[name="horas_inicio[]"]'
            )
        ).map(
            el => el.value
        );


    const horasFim =
        Array.from(
            document.querySelectorAll(
                'input[name="horas_fim[]"]'
            )
        ).map(
            el => el.value
        );


    const dadosEvento = {


        nome:
            document.getElementById('nome').value
            || "Título Provisório",


        subtitulo:
            document.getElementById('subtitulo').value
            || "",


        descricao:
            document.getElementById('descricao').value
            || "Sem descrição disponível.",


        cep:
            document.getElementById('cep').value
            || "00000-000",


        cidade:
            document.getElementById('cidade').value
            || "",


        bairro:
            document.getElementById('bairro').value
            || "",


        rua:
            document.getElementById('rua').value
            || "",


        numero:
            document.getElementById('numero').value
            || "",


        ponto_referencia:
            document.getElementById('ponto_referencia').value
            || "",


        classificacao:
            classificacaoValue,


        datas:
            datas,


        horasInicio:
            horasInicio,


        horasFim:
            horasFim,


        imagem:
            document.getElementById('image-preview').src
            || ""

    };


    sessionStorage.setItem(
        'dados_preview_evento',
        JSON.stringify(dadosEvento)
    );


    window.open(
        'visualizarEvento.html',
        '_blank'
    );

}

</script>



<!-- =========================================================
     FOOTER
========================================================= -->

<?php include 'footer.php'; ?>


</body>

</html>