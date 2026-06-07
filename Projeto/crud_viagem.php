<?php
include('cabecalho.php');

require_once('conexao.php');

try {
    $stmt = $conexao->query("
            SELECT
                v.id,
                m.nome,
                ve.Placa,
                r.Cidade_inicio,
                r.Estado_inicio,
                r.Cidade_fim,
                r.Estado_fim,
                v.data_saida,
                v.data_chegada
            FROM viagens v
            INNER JOIN motoristas m
                ON m.id = v.Motoristas_id
            INNER JOIN Veiculos ve
                ON ve.id = v.Veiculos_id
            INNER JOIN rotas r
                ON r.id = v.rotas_id
            ORDER BY v.id
        ");

    $resultado = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<?php if (isset($_GET['msg'])): ?>

    <?php if ($_GET['msg'] == 'criado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✅ Viagem criada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'editado'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                ✏️ Viagem editada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['msg'] == 'excluido'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show text-center shadow-sm">
                🗑️ Viagem excluída com sucesso!
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
<h2>Viagens</h2>

<a href="nova_viagem.php" class="btn btn-success mb-3">
    Novo Registro
</a>

<a href="principal.php" class="btn btn-secondary mb-3 me-2">
    Voltar
</a>

<table class="table table-hover table-striped">

    <thead>
        <tr>
            <th>ID</th>
            <th>Motorista</th>
            <th>Veículo</th>
            <th>Rota</th>
            <th>Saída</th>
            <th>Chegada</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($resultado as $r): ?>

            <tr>

                <td><?= $r['id'] ?></td>

                <td><?= htmlspecialchars($r['nome']) ?></td>

                <td><?= htmlspecialchars($r['Placa']) ?></td>

                <td>
                    <?= htmlspecialchars($r['Cidade_inicio']) ?>
                    -
                    <?= htmlspecialchars($r['Estado_inicio']) ?>

                    →

                    <?= htmlspecialchars($r['Cidade_fim']) ?>
                    -
                    <?= htmlspecialchars($r['Estado_fim']) ?>
                </td>

                <td><?= htmlspecialchars($r['data_saida']) ?></td>

                <td><?= htmlspecialchars($r['data_chegada']) ?></td>

                <td class="d-flex gap-2">

                    <a href="alterar_viagem.php?id=<?= $r['id'] ?>"
                        class="btn btn-sm btn-warning">
                        Editar
                    </a>

                    <a href="consultar_viagem.php?id=<?= $r['id'] ?>"
                        class="btn btn-sm btn-info">
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