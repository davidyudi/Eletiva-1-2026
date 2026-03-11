<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Exercicio 4</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body> 
<div class="container py-3">
<h1>Exercicio 4</h1>
<form method="post">
<div class="mb-3">
              <label for="dia" class="form-label">Informe o dia</label>
              <input type="number" id="dia" name="dia" class="form-control" required="">
            </div><div class="mb-3">
              <label for="mes" class="form-label">Informe o mês</label>
              <input type="number" id="mes" name="mes" class="form-control" required="">
            </div><div class="mb-3">
              <label for="ano" class="form-label">Informe o ano</label>
              <input type="number" id="ano" name="ano" class="form-control" required="">
            </div>
<button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $dia = (int)$_POST['dia'];
        $mes = (int)$_POST['mes'];
        $ano = (int)$_POST['ano'];
        $mesescom31 = [1, 3, 5, 7, 8, 10, 12];
        $mesescom30 = [4, 6, 9, 11];
        $fev = [28, 29];
        if ($ano > 0 && $mes <= 12 && $mes >= 1 && $dia >= 1)
        {
            if (in_array($mes, $mesescom31) && $dia <= 31)
            {
                echo "<p>$dia/$mes/$ano</p>";
            }
            elseif (in_array($mes, $mesescom30) && $dia <= 30)
            {
                echo "<p>$dia/$mes/$ano</p>";
            }
            elseif  ($ano % 4 == 0 && in_array($dia, $fev))
            {
                if ($dia == 29)
                {
                    echo "<p>$dia/$mes/$ano</p>";
                }
                elseif ($dia == 28)
                {
                    echo "<p>$dia/$mes/$ano</p>";
                }
            }
            else echo "<p>Entrada inválida!</p>";
        }
        else echo "<p>Entrada inválida!</p>";
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>