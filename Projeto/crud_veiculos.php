<?php
include('cabecalho.php');
require_once('conexao.php');
try {
    $stmt = $conexao->query('SELECT * FROM Veiculos');
    $resultado = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>


<h2>Veículos</h2>
<a href="novo_veiculo.php" class="btn btn-success mb-3">Novo Registro</a>
<a href="principal.php" class="btn btn-secondary mb-3 me-2">Voltar</a>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Cor</th>
            <th>Fabricante</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resultado as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= $r['Placa'] ?></td>
                <td><?= $r['Modelo'] ?></td>
                <td><?= $r['Cor'] ?></td>
                <td><?= $r['Fabricante'] ?></td>
                <td class="d-flex gap-2">
                    <a href="alterar_veiculo.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="consultar_veiculo.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php
include('rodape.php');
?>