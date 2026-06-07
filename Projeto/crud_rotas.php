<?php
include('cabecalho.php');
require_once('conexao.php');
try {
    $stmt   = $conexao->query('SELECT * FROM rotas');
    $resultado = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<?php if (isset($_GET['msg'])): ?>

    <?php if ($_GET['msg'] == 'criado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✅ Rota criada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'editado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✏️ Rota editada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'excluido'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                🗑️ Rota excluída com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'em_uso'): ?>
        <div class="container mt-3">
            <div class="alert alert-warning alert-dismissible fade show text-center shadow-sm">
                ⚠️ Esta rota não pode ser excluída pois está em uso em uma viagem!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'erro'): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show text-center shadow-sm">
                ❌ Ocorreu um erro ao executar a operação!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<h2>Rotas</h2>
<a href="nova_rota.php" class="btn btn-success mb-3">Novo Registro</a>
<a href="principal.php" class="btn btn-secondary mb-3 me-2">Voltar</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Partida</th>
            <th>Destino</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>

                <td>
                    <?= htmlspecialchars($r['Cidade_inicio']) ?>
                    -
                    <?= htmlspecialchars($r['Estado_inicio']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($r['Cidade_fim']) ?>
                    -
                    <?= htmlspecialchars($r['Estado_fim']) ?>
                </td>

                <td class="d-flex gap-2">
                    <a href="alterar_rota.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">
                        Editar
                    </a>

                    <a href="consultar_rota.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">
                        Consultar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
include('rodape.php');
?>