<?php
include 'testeConexao.php';

$categorias = mysqli_query($conexao, 'SELECT id_categoria, categoria_evento FROM Categoria')

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Cadastro de Eventos</title>
</head>
<body>
    <h2>Preencha as lacunas para cadastrar seu evento</h2>
    <form action="enviarCadastroEvento.php" method = "POST">

        <label>Nome/id do Usuário Organizador</label><br>
        <input type="number" name="id_usuarios" required><br><br>   

        <label>Nome do Evento</label><br>
        <input type="text" name="descricao" required><br><br>

        <label>Rua</label><br>
        <input type="text" name="rua" required><br><br>

        <label>Bairro</label><br>
        <input type="text" name="bairro" required><br><br>

        <label>Número</label><br>
        <input type="number" name="numero" required><br><br>

        <label>Cidade</label><br>
        <input type="text" name="cidade" required><br><br>

        <label>Ponto de referencia</label><br>
        <input type="text" name="ponto_referencia" required><br><br>

        <label>Data do Evento</label><br>
        <input type="date" name="data_evento" required><br><br>
        
        <label>Horário do Evento</label><br>
        <input type="time" name="horario_evento" required><br><br>

    <label for="categorias">Escolha uma categoria para seu Evento:</label><br>
    <select id="categorias" name="categorias">  
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
    </select>  <br><br>

        <label>O evento foi concluido?</label><br>
        <input type="text" name="evento_concluido" required><br><br>


        <button type="submit">Enviar</button>
    </form>
</body>
</html>