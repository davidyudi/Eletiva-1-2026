<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FrotaSystem – Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { padding-top: 0; background: linear-gradient(135deg, #1F5C52 0%, #2E7D6E 50%, #3D9D8A 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .login-card { background: rgba(255,255,255,.95); backdrop-filter: blur(20px); border-radius: 24px; box-shadow: 0 24px 64px rgba(0,0,0,.2); padding: 44px 40px; width: 100%; max-width: 420px; }
    .login-logo { text-align: center; margin-bottom: 32px; }
    .login-logo .icon { width: 64px; height: 64px; background: var(--primary); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; margin-bottom: 12px; }
    .login-logo h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--text); margin: 0; }
    .login-logo p { color: var(--text-muted); font-size: .88rem; margin: 4px 0 0; font-weight: 500; }
    .mb-4 { margin-bottom: 18px; }
    .btn-login { width: 100%; padding: 13px; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-sm); font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .2s; margin-top: 8px; }
    .btn-login:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .login-footer { text-align: center; margin-top: 20px; font-size: .85rem; color: var(--text-muted); font-weight: 600; }
    .login-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
    .login-footer a:hover { text-decoration: underline; }
    .hint { background: rgba(46,125,110,.08); border-radius: var(--radius-sm); padding: 10px 14px; font-size: .82rem; color: var(--text-muted); margin-top: 16px; text-align: center; font-weight: 600; }
  </style>
</head>
<body>
<div class="login-card">
  <div class="login-logo">
    <div class="icon">🚗</div>
    <h1>FrotaSystem</h1>
    <p>Controle de Frotas</p>
  </div>

  <?php
  require_once('conexao.php');
  session_start();
  $erro = '';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email'] ?? '');
      $senha = $_POST['senha'] ?? '';
      try {
          $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = ?");
          $stmt->execute([$email]);
          $usuario = $stmt->fetch();
          if ($usuario && password_verify($senha, $usuario['senha'])) {
              $_SESSION['nome']   = $usuario['nome'];
              $_SESSION['email']  = $usuario['email'];
              $_SESSION['perfil'] = $usuario['perfil'];
              $_SESSION['acesso'] = true;
              header('Location: principal.php');
              exit();
          } else {
              $erro = 'E-mail ou senha inválidos.';
          }
      } catch (Exception $e) {
          $erro = 'Erro: ' . $e->getMessage();
      }
  }
  if ($erro): ?>
    <div class="alert-frota alert-danger">⚠️ <?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-4">
      <label class="form-label-frota">E-mail</label>
      <input type="email" name="email" class="form-control-frota" placeholder="seu@email.com" required>
    </div>
    <div class="mb-4">
      <label class="form-label-frota">Senha</label>
      <input type="password" name="senha" class="form-control-frota" placeholder="••••••••" required>
    </div>
    <button type="submit" class="btn-login">Entrar →</button>
  </form>

  <div class="hint">💡 Padrão: admin@frota.com / password</div>

  <div class="login-footer">
    Não tem conta? <a href="cadastro.php">Cadastre-se</a>
  </div>
</div>
</body>
</html>