<!-- Pular para o conteúdo principal
Google Sala de Aula
Sala de Aula
SESI-2B (Quinta e Sexta)
Técnico em Desenvolvimento de Sistemas
Início
Agenda
Minhas inscrições
Pendentes
2
2B-SESI-TI_PBE2_2026/1
2B-SESI-TI
S
SESI-2B (Quinta e Sexta)
Técnico em Desenvolvimento de Sistemas
1
1B-SESI
Desenvolvimento de sistemas
Turmas arquivadas
Configurações
Detalhes do material
Formulário Inteligente com Máscaras e Consulta de CEP (HTML + JavaScript + API)
MARCELO DA SILVA SOARES
•
27 de fev. (editado: 27 de fev.)
Material de Aula – Formulário com Validação e Formatação Automática

Este material apresenta um exemplo prático de formulário em HTML e JavaScript que realiza a formatação automática de campos e a consulta de endereço a partir do CEP utilizando uma API externa.

No código disponibilizado, são abordados os seguintes conceitos:

- Formatação automática de CPF
- Formatação automática de CNPJ
- Formatação automática de telefone
- Formatação de data no padrão brasileiro (DD/MM/AAAA)
- Formatação de valores monetários (R$)
- Manipulação de strings com expressões regulares (RegEx)
- Uso do evento oninput
- Acesso e manipulação de elementos do DOM
- Consumo de API com fetch()
- Integração com a API ViaCEP
- Exibição dinâmica de dados na página

Objetivo do material
Demonstrar como criar formulários mais inteligentes e amigáveis ao usuário, aplicando máscaras nos campos de entrada e consumindo uma API para obter dados automaticamente, utilizando apenas HTML e JavaScript.

Conceito importante
A formatação dos dados melhora a experiência do usuário, mas não substitui a validação no servidor.
Todo dado digitado pelo usuário deve ser validado novamente no back-end para garantir segurança e integridade das informações.
formulario.html
HTML

Comentários da turma

Adicionar comentário para a turma... -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro Completo</title>

    <style>
        :root {
            --primary: #006198;
            --secondary: #0a7bbf;
            --bg: #f2f6fa;
            --border: #b5cde0;
        }

        * {
            box-sizing: border-box;
            font-family: Segoe UI, Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #004b73, #006198);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 10px;
        }

        .form-wrapper {
            background: #fff;
            width: 95%;
            max-width: 900px;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .25);
            padding: 20px;
        }

        h1,
        h2 {
            text-align: center;
            color: var(--primary);
        }

        hr {
            margin: 35px 0;
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 2px solid var(--border);
            font-size: 15px;
        }

        .full {
            grid-column: 1 / -1;
        }

        button {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
        }

        .resultado {
            margin-top: 15px;
            padding: 15px;
            border-radius: 10px;
            background: #f2f6fa;
            border: 2px solid var(--border);
        }

        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="form-wrapper">

        <h1>Cadastro de Usuário</h1>

        <div class="form-grid">

            <div>
                <label>CPF</label>
                <input id="cpf" maxlength="14" placeholder="000.000.000-00" oninput="formatarCPF()">
            </div>

            <div>
                <label>CNPJ</label>
                <input id="cnpj" maxlength="18" placeholder="00.000.000/0000-00" oninput="formatarCNPJ()">
            </div>

            <div>
                <label>Telefone</label>
                <input id="telefone" maxlength="15" placeholder="(00) 00000-0000" oninput="formatarTelefone()">
            </div>

            <div>
                <label>Data</label>
                <input id="data" maxlength="10" placeholder="DD/MM/AAAA" oninput="formatarData()">
            </div>

            <div class="full">
                <label>Valor</label>
                <input id="valor" placeholder="R$ 0,00" oninput="formatarValor()">
            </div>

        </div>

        <hr>

        <h2>Consulta de CEP</h2>

        <div class="form-grid">

            <div>
                <input id="cep" maxlength="9" placeholder="00000-000">
            </div>

            <div>
                <button onclick="buscarCEP()">Buscar CEP</button>
            </div>

            <div class="full resultado">
                <p id="rua"></p>
                <p id="bairro"></p>
                <p id="cidade"></p>
                <p id="estado"></p>
            </div>

        </div>

    </div>

    <script>
        function formatarCPF() {
            let v = cpf.value.replace(/\D/g, "").substring(0, 11);
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            cpf.value = v;
        }

        function formatarCNPJ() {
            let v = cnpj.value.replace(/\D/g, "").substring(0, 14);
            v = v.replace(/^(\d{2})(\d)/, "$1.$2");
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
            v = v.replace(/(\d{4})(\d)/, "$1-$2");
            cnpj.value = v;
        }

        function formatarTelefone() {
            let v = telefone.value.replace(/\D/g, "").substring(0, 11);
            v = v.replace(/(\d{2})(\d)/, "($1) $2");
            v = v.replace(/(\d{5})(\d)/, "$1-$2");
            telefone.value = v;
        }

        function formatarData() {
            let v = data.value.replace(/\D/g, "").substring(0, 8);
            v = v.replace(/(\d{2})(\d)/, "$1/$2");
            v = v.replace(/(\d{2})(\d)/, "$1/$2");
            data.value = v;
        }

        function formatarValor() {
            let v = valor.value.replace(/\D/g, "");
            v = (v / 100).toFixed(2);
            v = v.replace(".", ",");
            v = v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            valor.value = "R$ " + v;
        }

        function buscarCEP() {
            let url = "https://viacep.com.br/ws/" + cep.value + "/json/";

            fetch(url)
                .then(r => r.json())
                .then(d => {
                    rua.innerText = "Rua: " + d.logradouro;
                    bairro.innerText = "Bairro: " + d.bairro;
                    cidade.innerText = "Cidade: " + d.localidade;
                    estado.innerText = "Estado: " + d.uf;
                });
        }
    </script>

</body>

</html>
formulario.html
Exibindo formulario.html…