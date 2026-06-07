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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid px-4">

        <a class="navbar-brand fw-bold fs-2 me-5" href="principal.php">
            Sistema de Frotas
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSistema">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSistema">

            <ul class="navbar-nav gap-2">

                <li class="nav-item">
                    <a href="crud_motoristas.php"
                       class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_motoristas.php' ? 'active fw-bold bg-primary rounded' : '' ?>">
                        Motoristas
                    </a>
                </li>

                <li class="nav-item">
                    <a href="crud_veiculos.php"
                       class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_veiculos.php' ? 'active fw-bold bg-primary rounded' : '' ?>">
                        Veículos
                    </a>
                </li>

                <li class="nav-item">
                    <a href="crud_rotas.php"
                       class="nav-link fs-4 px-4 py-3 <?= $pagina == 'crud_rotas.php' ? 'active fw-bold bg-primary rounded' : '' ?>">
                        Rotas
                    </a>
                </li>

            </ul>

            <div class="ms-auto">
                <a href="logout.php"
                   class="btn btn-danger fs-5 px-4 py-2">
                    Sair
                </a>
            </div>

        </div>

    </div>
</nav>

<main class="container-fluid py-4">