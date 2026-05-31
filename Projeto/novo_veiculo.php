<?php
require_once('cabecalho.php');
require_once('conexao.php');

$categorias = $pdo->query("SELECT * FROM categoria_veiculo ORDER BY nome")->fetchAll();
$msg = ''; $tipo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campos = ['placa','modelo','marca','ano','cor','km_atual','status','categoria_id'];
    $dados = [];
    foreach ($campos as $c) $dados[$c] = trim($_POST[$c] ?? '');
    try {
        $stmt = $pdo->prepare("INSERT INTO veiculo (placa, modelo, marca, ano, cor, km_atual, status, categoria_id) VALUES (?,?,?,?,?,?,?,?)");
        if ($stmt->execute(array_values($dados))) {
            header('Location: veiculos.php?ok=1');
            exit();
        }
    } catch (Exception $e) {
        $msg = 'Erro: ' . $e->getMessage(); $tipo = 'danger';
    }
}
?>

<div class="page-header">
  <h1 class="page-title">🚙 Novo Veículo</h1>
  <a href="veiculos.php" class="btn-outline-frota">← Voltar</a>
</div>

<?php if ($msg): ?>
  <div class="alert-frota alert-<?= $tipo ?>"><?= $tipo=='success'?'✅':'⚠️' ?> <?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="card-frota">
  <form method="post">
    <div class="form-grid">
      <div>
        <label class="form-label-frota">Placa *</label>
        <input type="text" name="placa" class="form-control-frota" placeholder="ABC-1234" required maxlength="10" style="text-transform:uppercase">
      </div>
      <div>
        <label class="form-label-frota">Modelo *</label>
        <input type="text" name="modelo" class="form-control-frota" placeholder="Ex: Gol, HB20, Strada..." required>
      </div>
      <div>
        <label class="form-label-frota">Marca *</label>
        <input type="text" name="marca" class="form-control-frota" placeholder="Ex: Volkswagen, Hyundai..." required>
      </div>
      <div>
        <label class="form-label-frota">Ano *</label>
        <input type="number" name="ano" class="form-control-frota" placeholder="2024" min="1990" max="<?= date('Y')+1 ?>" required>
      </div>
      <div>
        <label class="form-label-frota">Cor</label>
        <input type="text" name="cor" class="form-control-frota" placeholder="Branco, Prata, Preto...">
      </div>
      <div>
        <label class="form-label-frota">KM Atual</label>
        <input type="number" name="km_atual" class="form-control-frota" placeholder="0" min="0" step="0.01" value="0">
      </div>
      <div>
        <label class="form-label-frota">Status *</label>
        <select name="status" class="form-control-frota" required>
          <option value="disponivel">Disponível</option>
          <option value="em_uso">Em uso</option>
          <option value="manutencao">Manutenção</option>
          <option value="inativo">Inativo</option>
        </select>
      </div>
      <div>
        <label class="form-label-frota">Categoria *</label>
        <select name="categoria_id" class="form-control-frota" required>
          <option value="">Selecione...</option>
          <?php foreach ($categorias as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div style="margin-top:24px;display:flex;gap:12px;">
      <button type="submit" class="btn-primary-frota">💾 Salvar Veículo</button>
      <a href="veiculos.php" class="btn-outline-frota">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once('rodape.php'); ?>