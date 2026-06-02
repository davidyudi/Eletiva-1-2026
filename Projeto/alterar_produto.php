<?php
    require_once('cabecalho.php');
    require_once('conexao.php');
    $mensagem = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $categoria = $_POST['categoria'];
        $id = $_GET['id'];
        try{
          $sql = "UPDATE produto SET descricao = ?, valor = ?, categoria_id = ? WHERE id = ?";
          $stmt = $conexao->prepare($sql);
          if($stmt->execute([$descricao, $valor, $categoria, $id])){
            $mensagem = "<p>Alteração realizada!</p>";
          } else {
            $mensagem = "<p>Erro ao alterar! Tente novamente</p>";
          }
        } catch(Exception $e){
          echo "Erro: ".$e->getMessage();
        }
      }
    try{
        $stmt = $conexao->prepare("SELECT * from produto WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $resultado = $stmt->fetch();
    } catch (Exception $e){
        echo "Erro: ".$e->getMessage();
    }
    try{
        $stmt = $conexao->query("SELECT * from categoria");
        $resultado2 = $stmt->fetchAll();
    } catch(Exception $e){
        die("Erro: ".$e->getMessage());
    }
?>

<h1>Alterar Produto</h1>
    <form method="post" 
        action="alterar_produto.php?id=<?= $resultado['id']?>">
        <div class="mb-3">
            <label for="descricao" class="form-label">Informe a descrição</label>
            <input value="<?= $resultado['descricao']?>" type="text" id="descricao" name="descricao" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Informe o valor</label>
            <input value="<?= $resultado['valor']?>" type="text" id="valor" name="valor" class="form-control" required="">
        </div>
        <div class="mb-3">
            <label for="valor" class="form-label">Selecione a categoria</label>
            <select name="categoria" id="categoria" requird class="form-select">
                <?php foreach($resultado2 as $r): 
                        if($resultado['categoria_id'] == $r['id'])
                            $selecionado = "selected";
                        else
                            $selecionado = "";
                    ?>
                    <option <?= $selecionado ?> value="<?= $r['id']?>"><?= $r['nome'] ?></option>
                <?php endforeach ?>
            </select>
            
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <?php
      echo $mensagem;
    ?>

<?php
    require_once('rodape.php');