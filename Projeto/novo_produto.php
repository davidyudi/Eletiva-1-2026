<?php
    require_once('cabecalho.php');
    require_once('conexao.php');
    try{
        $stmt = $conexao->query("SELECT * FROM categoria");
        $resultado = $stmt->fetchAll();

    } catch(Exception $e){
        die("Erro: ".$e->getMessage());
    }
?>

<h1>Novo Produto</h1>
    <form method="post">
        <div class="mb-3">
              <label for="nome" class="form-label">Informe a descrição</label>
              <input type="text" id="descricao" name="descricao" class="form-control" required="">
        </div>
        <div class="mb-3">
              <label for="nome" class="form-label">Informe o valor</label>
              <input type="text" id="valor" name="valor" class="form-control" required="">
        </div>
        <div class="mb-3">
                <label for="categoria" class="form-label">Selecione a categoria</label>
                <select required name="categoria" id="categoria" class="form-select">
                    <?php foreach($resultado as $r):?>   
                        <option value="<?= $r['id'] ?>"> <?= $r['nome']?> </option>

                    <?php endforeach;?>   
                </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once('conexao.php');
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $categoria = $_POST['categoria'];
        try{
          $stmt = $conexao->prepare('INSERT INTO produto (descricao, valor, categoria_id) VALUES (?, ?, ?);');
          if($stmt->execute([$descricao, $valor, $categoria])){
            echo "<p>Cadastro realizado!</p>";
          } else {
            echo "<p>Erro ao cadastrar! Tente novamente</p>";
          }
        } catch(Exception $e){
          echo "Erro: ".$e->getMessage();
        }
      }
    ?>

<?php
    require_once('rodape.php');