<?php
include('cabecalho.php');
require_once('conexao.php');
try {
    $stmt = $conexao->query('SELECT * FROM motoristas');
    $resultado = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<?php if (isset($_GET['msg'])): ?>

    <?php if ($_GET['msg'] == 'criado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✅ Motorista cadastrado com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'editado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✏️ Motorista editado com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'excluido'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                🗑️ Motorista excluído com sucesso!
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

<h2>Motoristas</h2>
<a href="novo_motorista.php" class="btn btn-success mb-3">Novo Registro</a>
<a href="principal.php" class="btn btn-secondary mb-3 me-2">Voltar</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>CNH</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['nome']) ?></td>
                <td><?= htmlspecialchars($r['data_nascimento']) ?></td>
                <td><?= htmlspecialchars($r['cpf']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['telefone']) ?></td>
                <td><?= htmlspecialchars($r['cnh']) ?></td>
                <td class="d-flex gap-2">
                    <a href="alterar_motorista.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="consultar_motorista.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
include('rodape.php');
?>