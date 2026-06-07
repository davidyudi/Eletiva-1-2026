<?php
    session_start();
    if (!isset($_SESSION['acesso']) || $_SESSION['acesso'] == false)
    {
        header('Location: index.php');
        exit;
    }
?>
<?php $pagina = basename($_SERVER['PHP_SELF']); ?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">

<a href="crud_motoristas.php"
   class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_motoristas.php' ? 'active' : '' ?>">
    Motoristas
</a>

<a href="crud_veiculos.php"
   class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_veiculos.php' ? 'active' : '' ?>">
    Veículos
</a>

<a href="crud_rotas.php"
   class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_rotas.php' ? 'active' : '' ?>">
    Rotas
</a>

        <a href="logout.php" class="btn btn-outline-danger ms-auto fs-4 px-5 py-3 me-3">
            Sair
        </a>

    </div>
</nav>
<main class="conteudo">