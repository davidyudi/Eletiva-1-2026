<?php
session_start();
if (!isset($_SESSION['acesso']) || $_SESSION['acesso'] == false) {
    header('Location: index.php');
    exit();
}
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Frota System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR FLUTUANTE -->
<nav class="navbar-frota">
  <a href="principal.php" class="nav-brand">
    <div class="brand-icon">🚗</div>
    <span><b>Frota</b>System</span>
  </a>

  <ul class="nav-links">
    <li>
      <a href="principal.php" class="<?= $pagina_atual=='principal.php'?'active':'' ?>">
        <span class="nav-icon">🏠</span> Início
      </a>
    </li>
    <li class="nav-dropdown">
      <a href="#" class="<?= in_array($pagina_atual,['veiculos.php','motoristas.php','categoria_veiculo.php'])?'active':'' ?>">
        <span class="nav-icon">⚙️</span> Cadastros
      </a>
      <div class="dropdown-menu-frota">
        <a href="veiculos.php">🚙 Veículos</a>
        <a href="motoristas.php">👤 Motoristas</a>
        <a href="categoria_veiculo.php">📂 Categorias</a>
      </div>
    </li>
    <li class="nav-dropdown">
      <a href="#" class="<?= in_array($pagina_atual,['viagens.php','abastecimentos.php','manutencoes.php'])?'active':'' ?>">
        <span class="nav-icon">📋</span> Operações
      </a>
      <div class="dropdown-menu-frota">
        <a href="viagens.php">🗺️ Viagens</a>
        <a href="abastecimentos.php">⛽ Abastecimentos</a>
        <a href="manutencoes.php">🔧 Manutenções</a>
      </div>
    </li>
    <li>
      <a href="relatorios.php" class="<?= $pagina_atual=='relatorios.php'?'active':'' ?>">
        <span class="nav-icon">📊</span> Relatórios
      </a>
    </li>
  </ul>

  <a href="logout.php" class="nav-logout">
    🚪 Sair
  </a>

  <!-- Hambúrguer mobile -->
  <button class="nav-toggle" onclick="toggleMenu()" aria-label="Menu">☰</button>
</nav>

<!-- Menu mobile -->
<div class="nav-mobile-menu" id="mobileMenu">
  <a href="principal.php">🏠 Início</a>
  <hr>
  <a href="veiculos.php">🚙 Veículos</a>
  <a href="motoristas.php">👤 Motoristas</a>
  <a href="categoria_veiculo.php">📂 Categorias</a>
  <hr>
  <a href="viagens.php">🗺️ Viagens</a>
  <a href="abastecimentos.php">⛽ Abastecimentos</a>
  <a href="manutencoes.php">🔧 Manutenções</a>
  <hr>
  <a href="relatorios.php">📊 Relatórios</a>
  <a href="logout.php" style="color:#E05252;">🚪 Sair</a>
</div>

<script>
function toggleMenu() {
  document.getElementById('mobileMenu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
  const menu = document.getElementById('mobileMenu');
  const btn = document.querySelector('.nav-toggle');
  if (!menu.contains(e.target) && !btn.contains(e.target)) {
    menu.classList.remove('open');
  }
});
</script>

<div class="page-wrapper">