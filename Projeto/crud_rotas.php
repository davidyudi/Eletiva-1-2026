<?php
    include('cabecalho.php');
    require_once('conexao.php');
    try {
        $stmt    = $conexao->query('SELECT * FROM rotas');
        $resultado = $stmt->fetchAll();
    } catch(Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
?>

<h2>Rotas</h2>
    <a href="nova_rota.php" class="btn btn-success mb-3">Novo Registro</a>
    <a href="principal.php" class="btn btn-secondary mb-3 me-2">Voltar</a>
    <table class="table table-hover table-striped">
    <thead>
        <tr>
        <th>ID</th>
        <th>Cidade Início</th>
        <th>Estado Início</th>
        <th>Cidade Fim</th>
        <th>Estado Fim</th>
        <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['Cidade_inicio']) ?></td>
                <td><?= htmlspecialchars($r['Estado_inicio']) ?></td>
                <td><?= htmlspecialchars($r['Cidade_fim']) ?></td>
                <td><?= htmlspecialchars($r['Estado_fim']) ?></td>
                <td class="d-flex gap-2">
                <a href="alterar_rota.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="consultar_rota.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

<?php
    include('rodape.php');
?>
