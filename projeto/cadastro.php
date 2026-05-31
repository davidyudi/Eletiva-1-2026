<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FrotaSystem – Cadastro</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { padding-top: 0; background: linear-gradient(135deg, #1F5C52 0%, #2E7D6E 50%, #3D9D8A 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .login-card { background: rgba(255,255,255,.95); backdrop-filter: blur(20px); border-radius: 24px; box-shadow: 0 24px 64px rgba(0,0,0,.2); padding: 44px 40px; width: 100%; max-width: 420px; }
    .login-logo { text-align: center; margin-bottom: 28px; }
    .login-logo .icon { width: 64px; height: 64px; background: var(--primary); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; margin-bottom: 12px; }
    .login-logo h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--text); margin: 0; }
    .mb-4 { margin-bottom: 16px; }
    .btn-login { width: 100%; padding: 13px; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .2s; margin-top: 8px; }
    .btn-login:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .login-footer { text-align: center; margin-top: 20px; font-size: .85rem; color: var(--text-muted); font-weight: 600; }
    .login-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
  </style>
</head>
<body>
<div class="login-card">
  <div class="login-logo">
    <div class="icon">📝</div>
    <h1>Criar Conta</h1>
  </div>

  <?php
  $msg = ''; $tipo = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      require_once('conexao.php');
      $nome  = trim($_POST['nome']  ?? '');
      $email = trim($_POST['email'] ?? '');
      $senha = password_hash($_POST['senha'] ?? '', PASSWORD_BCRYPT);
      try {
          $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
          if ($stmt->execute([$nome, $email, $senha])) {
              $msg = 'Cadastro realizado! Faça o login.';
              $tipo = 'success';
          } else {
              $msg = 'Erro ao cadastrar. Tente novamente.';
              $tipo = 'danger';
          }
      } catch (Exception $e) {
          $msg = 'Erro: ' . $e->getMessage();
          $tipo = 'danger';
      }
  }
  if ($msg): ?>
    <div class="alert-frota alert-<?= $tipo ?>"><?= $tipo=='success'?'✅':'⚠️' ?> <?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-4">
      <label class="form-label-frota">Nome completo</label>
      <input type="text" name="nome" class="form-control-frota" placeholder="Seu nome" required>
    </div>
    <div class="mb-4">
      <label class="form-label-frota">E-mail</label>
      <input type="email" name="email" class="form-control-frota" placeholder="seu@email.com" required>
    </div>
    <div class="mb-4">
      <label class="form-label-frota">Senha</label>
      <input type="password" name="senha" class="form-control-frota" placeholder="Mínimo 6 caracteres" minlength="6" required>
    </div>
    <button type="submit" class="btn-login">Cadastrar →</button>
  </form>

  <div class="login-footer">
    Já tem conta? <a href="index.php">Faça login</a>
  </div>
</div>
</body>
</html>