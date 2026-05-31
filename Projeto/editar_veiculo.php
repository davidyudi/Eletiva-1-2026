<?php
require_once('cabecalho.php');
require_once('conexao.php');

$id = intval($_GET['id'] ?? 0);
$categorias = $pdo->query("SELECT * FROM categoria_veiculo ORDER BY nome")->fetchAll();
$msg = ''; $tipo = '';

try {
    $stmt = $pdo->prepare("SELECT * FROM veiculo WHERE id=?");
    $stmt->execute([$id]);
    $v = $stmt->fetch();
    if (!$v) { header('Location: veiculos.php'); exit(); }
} catch (Exception $e) {
    die('Erro: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE veiculo SET placa=?,modelo=?,marca=?,ano=?,cor=?,km_atual=?,status=?,categoria_id=? WHERE id=?");
        $stmt->execute([
            trim($_POST['placa']), trim($_POST['modelo']), trim($_POST['marca']),
            $_POST['ano'], trim($_POST['cor']), $_POST['km_atual'],
            $_POST['status'], $_POST['categoria_id'], $id
        ]);
        header('Location: veiculos.php?ok=1');
        exit();
    } catch (Exception $e) {
        $msg = 'Erro: ' . $e->getMessage(); $tipo = 'danger';
    }
}
?>

<div class="page-header">
  <h1 class="page-title">✏️ Editar Veículo</h1>
  <a href="veiculos.php" class="btn-outline-frota">← Voltar</a>
</div>

<?php if ($msg): ?>
  <div class="alert-frota alert-<?= $tipo ?>">⚠️ <?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="card-frota">
  <form method="post">
    <div class="form-grid">
      <div>
        <label class="form-label-frota">Placa *</label>
        <input type="text" name="placa" class="form-control-frota" value="<?= htmlspecialchars($v['placa']) ?>" required maxlength="10" style="text-transform:uppercase">
      </div>
      <div>
        <label class="form-label-frota">Modelo *</label>
        <input type="text" name="modelo" class="form-control-frota" value="<?= htmlspecialchars($v['modelo']) ?>" required>
      </div>
      <div>
        <label class="form-label-frota">Marca *</label>
        <input type="text" name="marca" class="form-control-frota" value="<?= htmlspecialchars($v['marca']) ?>" required>
      </div>
      <div>
        <label class="form-label-frota">Ano *</label>
        <input type="number" name="ano" class="form-control-frota" value="<?= htmlspecialchars($v['ano']) ?>" min="1990" max="<?= date('Y')+1 ?>" required>
      </div>
      <div>
        <label class="form-label-frota">Cor</label>
        <input type="text" name="cor" class="form-control-frota" value="<?= htmlspecialchars($v['cor'] ?? '') ?>">
      </div>
      <div>
        <label class="form-label-frota">KM Atual</label>
        <input type="number" name="km_atual" class="form-control-frota" value="<?= $v['km_atual'] ?>" min="0" step="0.01">
      </div>
      <div>
        <label class="form-label-frota">Status *</label>
        <select name="status" class="form-control-frota" required>
          <?php foreach (['disponivel'=>'Disponível','em_uso'=>'Em uso','manutencao'=>'Manutenção','inativo'=>'Inativo'] as $k=>$l): ?>
            <option value="<?= $k ?>" <?= $v['status']==$k?'selected':'' ?>><?= $l ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="form-label-frota">Categoria *</label>
        <select name="categoria_id" class="form-control-frota" required>
          <?php foreach ($categorias as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $v['categoria_id']==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
      <button type="submit" class="btn-primary-frota">💾 Salvar Alterações</button>
      <a href="veiculos.php" class="btn-outline-frota">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once('rodape.php'); ?>