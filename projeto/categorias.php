<?php
    require_once('cabecalho.php');
    require_once('conexao.php');
    try{
        $stmt = $pdo->query('SELECT * FROM categoria');
        $resultado = $stmt->fetchALL();
    } catch(Exception $e){
      echo "Erro: ".$e->getMessage();
    }
?>

<h2>Categorias</h2>
    <a href="nova_categoria.php" class="btn btn-success mb-3">Novo Registro</a>
    <table class="table table-hover table-striped">
    <thead>
        <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['nome'] ?></td>
            <td class="d-flex gap-2">
            <a href="alterar_categoria.php" class="btn btn-sm btn-warning">Editar</a>
            <a href="consultar_categoria.php" class="btn btn-sm btn-info">Consultar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

<?php
    require_once('rodape.php');