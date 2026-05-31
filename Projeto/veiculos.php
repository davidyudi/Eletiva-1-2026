<?php
require_once('cabecalho.php');
require_once('conexao.php');

$busca = trim($_GET['busca'] ?? '');
try {
    if ($busca) {
        $stmt = $pdo->prepare("
            SELECT v.*, c.nome AS categoria_nome FROM veiculo v
            JOIN categoria_veiculo c ON v.categoria_id = c.id
            WHERE v.placa LIKE ? OR v.modelo LIKE ? OR v.marca LIKE ?
            ORDER BY v.id DESC
        ");
        $like = "%$busca%";
        $stmt->execute([$like, $like, $like]);
    } else {
        $stmt = $pdo->query("
            SELECT v.*, c.nome AS categoria_nome FROM veiculo v
            JOIN categoria_veiculo c ON v.categoria_id = c.id
            ORDER BY v.id DESC
        ");
    }
    $veiculos = $stmt->fetchAll();
} catch (Exception $e) {
    echo '<div class="alert-frota alert-danger">⚠️ ' . $e->getMessage() . '</div>';
    $veiculos = [];
}

$status_labels = ['disponivel'=>'Disponível','em_uso'=>'Em uso','manutencao'=>'Manutenção','inativo'=>'Inativo'];
?>

<div class="page-header">
  <h1 class="page-title">🚙 Veículos</h1>
  <a href="novo_veiculo.php" class="btn-primary-frota">＋ Novo Veículo</a>
</div>

<!-- Busca -->
<div class="card-frota" style="margin-bottom:20px;padding:16px 20px;">
  <form method="get" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <input type="text" name="busca" class="form-control-frota" placeholder="Buscar por placa, modelo ou marca..." value="<?= htmlspecialchars($busca) ?>" style="flex:1;min-width:200px;">
    <button type="submit" class="btn-primary-frota">🔍 Buscar</button>
    <?php if ($busca): ?><a href="veiculos.php" class="btn-outline-frota">✕ Limpar</a><?php endif; ?>
  </form>
</div>

<div class="card-frota">
  <?php if (empty($veiculos)): ?>
    <div class="empty-state">
      <div class="empty-icon">🚗</div>
      <p>Nenhum veículo encontrado</p>
      <a href="novo_veiculo.php" class="btn-primary-frota">＋ Cadastrar Veículo</a>
    </div>
  <?php else: ?>
    <div style="overflow-x:auto;">
      <table class="table-frota">
        <thead>
          <tr>
            <th>Placa</th>
            <th>Veículo</th>
            <th>Categoria</th>
            <th>Ano</th>
            <th>KM Atual</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($veiculos as $v): ?>
            <tr>
              <td><strong style="font-family:monospace;font-size:.95rem;"><?= htmlspecialchars($v['placa']) ?></strong></td>
              <td>
                <strong><?= htmlspecialchars($v['modelo']) ?></strong><br>
                <small style="color:var(--text-muted);"><?= htmlspecialchars($v['marca']) ?> &bull; <?= htmlspecialchars($v['cor'] ?? '') ?></small>
              </td>
              <td><?= htmlspecialchars($v['categoria_nome']) ?></td>
              <td><?= htmlspecialchars($v['ano']) ?></td>
              <td><?= number_format($v['km_atual'], 0, ',', '.') ?> km</td>
              <td><span class="badge-frota badge-<?= $v['status'] ?>"><?= $status_labels[$v['status']] ?></span></td>
              <td>
                <div style="display:flex;gap:6px;">
                  <a href="ver_veiculo.php?id=<?= $v['id'] ?>" class="btn-sm-view">👁</a>
                  <a href="editar_veiculo.php?id=<?= $v['id'] ?>" class="btn-sm-edit">✏️</a>
                  <a href="excluir_veiculo.php?id=<?= $v['id'] ?>" class="btn-sm-delete" onclick="return confirm('Excluir este veículo?')">🗑</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="margin-top:12px;color:var(--text-muted);font-size:.82rem;font-weight:600;">
      <?= count($veiculos) ?> veículo(s) encontrado(s)
    </div>
  <?php endif; ?>
</div>

<?php require_once('rodape.php'); ?>