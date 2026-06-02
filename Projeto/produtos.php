<?php
    require_once('cabecalho.php');
    require_once('conexao.php');
    try{
        $stmt = $conexao->query('SELECT p.*, c.nome FROM produto p INNER JOIN categoria c ON
        c.id = p.categoria_id');
        $resultado = $stmt->fetchAll();
    } catch(Exception $e){
        echo "Erro: ".$e->getMessage();
    }
?>

<h2>Produtos</h2>
    <a href="novo_produto.php" class="btn btn-success mb-3">Novo Registro</a>
    <table class="table table-hover table-striped">
    <thead>
        <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Categoria</th>
        <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['descricao'] ?></td>
            <td><?= $r['nome'] ?></td>
            <td class="d-flex gap-2">
            <a href="alterar_produto.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="consultar_produto.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

<?php
    require_once('rodape.php');