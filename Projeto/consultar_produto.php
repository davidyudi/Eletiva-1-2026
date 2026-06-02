<?php
    require_once('cabecalho.php');
    require_once('conexao.php');
    try{
        $stmt = $conexao->prepare('SELECT p.*,c.nome FROM produto p
        INNER JOIN categoria c ON c.id = p.categoria_id
         WHERE p.id=?' );
        $stmt->execute([$_GET['id']]);
        $resultado = $stmt->fetch();
    } catch(Exception $e){
        echo "Erro! ".$e->getMessage();
    }
?>

<h1>Consultar Produto</h1>
    <form method="post" 
        action="consultar_produto.php?id=<?= $resultado['id'] ?>">
        <div class="mb-3">
              <p><strong>Descrição:</strong> 
                 <?= $resultado['descricao'] ?> 
              </p>
        </div>
        <div class="mb-3">
              <p><strong>Valor:</strong> 
                 <?= $resultado['valor'] ?> 
              </p>
        </div>
        <div class="mb-3">
              <p><strong>Categoria:</strong> 
                <?= $resultado['nome'] ?>
              </p>
        </div>
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = $_GET['id'];
            try{
                $sql = "DELETE FROM produto WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                if($stmt->execute([$id])){
                    header('Location: produtos.php');
                } else {
                    echo "Erro ao excluir!";
                }
            } catch(Exception $e){
                echo "Erro: ".$e->getMessage();
            }
        }
    ?>
<?php
    require_once('rodape.php');