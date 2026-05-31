<?php
require_once('cabecalho.php');
require_once('conexao.php');

try {
    $total_veiculos    = $pdo->query("SELECT COUNT(*) FROM veiculo")->fetchColumn();
    $disponiveis       = $pdo->query("SELECT COUNT(*) FROM veiculo WHERE status='disponivel'")->fetchColumn();
    $em_uso            = $pdo->query("SELECT COUNT(*) FROM veiculo WHERE status='em_uso'")->fetchColumn();
    $manutencao        = $pdo->query("SELECT COUNT(*) FROM veiculo WHERE status='manutencao'")->fetchColumn();
    $total_motoristas  = $pdo->query("SELECT COUNT(*) FROM motorista WHERE status='ativo'")->fetchColumn();
    $total_viagens     = $pdo->query("SELECT COUNT(*) FROM viagem")->fetchColumn();
    $viagens_mes       = $pdo->query("SELECT COUNT(*) FROM viagem WHERE MONTH(data_saida)=MONTH(NOW()) AND YEAR(data_saida)=YEAR(NOW())")->fetchColumn();
    $gasto_abastec     = $pdo->query("SELECT COALESCE(SUM(valor_total),0) FROM abastecimento WHERE MONTH(data_abastecimento)=MONTH(NOW()) AND YEAR(data_abastecimento)=YEAR(NOW())")->fetchColumn();
    $gasto_manutencao  = $pdo->query("SELECT COALESCE(SUM(valor),0) FROM manutencao WHERE MONTH(data_entrada)=MONTH(NOW()) AND YEAR(data_entrada)=YEAR(NOW())")->fetchColumn();

    // Últimas viagens
    $ultimas_viagens = $pdo->query("
        SELECT v.*, ve.placa, ve.modelo, m.nome AS motorista_nome
        FROM viagem v
        JOIN veiculo ve ON v.veiculo_id = ve.id
        JOIN motorista m ON v.motorista_id = m.id
        ORDER BY v.data_saida DESC LIMIT 5
    ")->fetchAll();

    // Veículos em manutenção
    $em_manutencao = $pdo->query("
        SELECT ma.*, ve.placa, ve.modelo
        FROM manutencao ma
        JOIN veiculo ve ON ma.veiculo_id = ve.id
        WHERE ma.status = 'aberta'
        ORDER BY ma.data_entrada DESC LIMIT 5
    ")->fetchAll();

} catch (Exception $e) {
    echo '<div class="alert-frota alert-danger">⚠️ ' . $e->getMessage() . '</div>';
}

function statusBadge($s) {
    $map = ['disponivel'=>'Disponível','em_uso'=>'Em uso','manutencao'=>'Manutenção','inativo'=>'Inativo','ativo'=>'Ativo','concluida'=>'Concluída','aberta'=>'Aberta','cancelada'=>'Cancelada','em_andamento'=>'Em andamento'];
    return '<span class="badge-frota badge-'.htmlspecialchars($s).'">'.($map[$s]??$s).'</span>';
}
?>

<div class="page-header">
  <div>
    <h1 class="page-title">Painel de Controle</h1>
    <p style="color:var(--text-muted);font-size:.88rem;margin:4px 0 0;font-weight:600;">
      Olá, <?= htmlspecialchars($_SESSION['nome']) ?>! Bem-vindo ao FrotaSystem 🚗
    </p>
  </div>
  <span style="font-size:.82rem;color:var(--text-muted);font-weight:600;"><?= date('d/m/Y') ?></span>
</div>

<!-- STATS FROTA -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
  <div class="stat-card">
    <div class="stat-icon green">🚗</div>
    <div class="stat-info">
      <div class="stat-value"><?= $total_veiculos ?></div>
      <div class="stat-label">Veículos na Frota</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">✅</div>
    <div class="stat-info">
      <div class="stat-value"><?= $disponiveis ?></div>
      <div class="stat-label">Disponíveis</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange">🔑</div>
    <div class="stat-info">
      <div class="stat-value"><?= $em_uso ?></div>
      <div class="stat-label">Em Uso</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">🔧</div>
    <div class="stat-info">
      <div class="stat-value"><?= $manutencao ?></div>
      <div class="stat-label">Em Manutenção</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">👤</div>
    <div class="stat-info">
      <div class="stat-value"><?= $total_motoristas ?></div>
      <div class="stat-label">Motoristas Ativos</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">🗺️</div>
    <div class="stat-info">
      <div class="stat-value"><?= $viagens_mes ?></div>
      <div class="stat-label">Viagens no Mês</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange">⛽</div>
    <div class="stat-info">
      <div class="stat-value">R$ <?= number_format($gasto_abastec,0,'.','.') ?></div>
      <div class="stat-label">Abastec. no Mês</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">🔩</div>
    <div class="stat-info">
      <div class="stat-value">R$ <?= number_format($gasto_manutencao,0,'.','.') ?></div>
      <div class="stat-label">Manutenção Mês</div>
    </div>
  </div>
</div>

<!-- AÇÕES RÁPIDAS -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:28px;">
  <?php
  $acoes = [
    ['href'=>'nova_viagem.php',        'icon'=>'🗺️', 'label'=>'Nova Viagem'],
    ['href'=>'novo_abastecimento.php', 'icon'=>'⛽', 'label'=>'Abastecimento'],
    ['href'=>'nova_manutencao.php',    'icon'=>'🔧', 'label'=>'Manutenção'],
    ['href'=>'novo_veiculo.php',       'icon'=>'🚙', 'label'=>'Novo Veículo'],
    ['href'=>'novo_motorista.php',     'icon'=>'👤', 'label'=>'Novo Motorista'],
    ['href'=>'relatorios.php',         'icon'=>'📊', 'label'=>'Relatórios'],
  ];
  foreach ($acoes as $a): ?>
    <a href="<?= $a['href'] ?>" style="
      display:flex;flex-direction:column;align-items:center;gap:8px;
      background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);
      padding:20px 12px;text-decoration:none;color:var(--text);font-weight:700;font-size:.88rem;
      text-align:center;transition:all .2s;
    " onmouseover="this.style.boxShadow='var(--shadow-md)';this.style.transform='translateY(-3px)';this.style.borderColor='var(--primary)'"
       onmouseout="this.style.boxShadow='';this.style.transform='';this.style.borderColor='var(--border)'">
      <span style="font-size:26px;"><?= $a['icon'] ?></span>
      <?= $a['label'] ?>
    </a>
  <?php endforeach; ?>
</div>

<!-- TABELAS: Últimas viagens + Manutenções abertas -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

  <!-- Últimas Viagens -->
  <div class="card-frota">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
      <h2 style="font-size:1rem;font-weight:700;margin:0;">🗺️ Últimas Viagens</h2>
      <a href="viagens.php" class="btn-sm-view" style="font-size:.75rem;">Ver todas</a>
    </div>
    <?php if (empty($ultimas_viagens)): ?>
      <div class="empty-state"><p>Nenhuma viagem registrada</p></div>
    <?php else: ?>
      <table class="table-frota">
        <thead><tr><th>Veículo</th><th>Motorista</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach ($ultimas_viagens as $v): ?>
            <tr>
              <td><strong><?= htmlspecialchars($v['placa']) ?></strong><br><small style="color:var(--text-muted)"><?= htmlspecialchars($v['modelo']) ?></small></td>
              <td><?= htmlspecialchars($v['motorista_nome']) ?></td>
              <td><?= statusBadge($v['status']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <!-- Manutenções Abertas -->
  <div class="card-frota">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
      <h2 style="font-size:1rem;font-weight:700;margin:0;">🔧 Manutenções Abertas</h2>
      <a href="manutencoes.php" class="btn-sm-view" style="font-size:.75rem;">Ver todas</a>
    </div>
    <?php if (empty($em_manutencao)): ?>
      <div class="empty-state"><p>Nenhuma manutenção em aberto ✅</p></div>
    <?php else: ?>
      <table class="table-frota">
        <thead><tr><th>Veículo</th><th>Tipo</th><th>Entrada</th></tr></thead>
        <tbody>
          <?php foreach ($em_manutencao as $m): ?>
            <tr>
              <td><strong><?= htmlspecialchars($m['placa']) ?></strong><br><small style="color:var(--text-muted)"><?= htmlspecialchars($m['modelo']) ?></small></td>
              <td><span style="text-transform:capitalize"><?= htmlspecialchars($m['tipo']) ?></span></td>
              <td><?= date('d/m/Y', strtotime($m['data_entrada'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>

<?php require_once('rodape.php'); ?>