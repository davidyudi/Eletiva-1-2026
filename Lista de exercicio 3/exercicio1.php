<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercicio 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Exercicio 1</h1>
        <form method="POST">
            <?php for ($i = 1; $i <= 7; $i++): ?>
                <label class="form-label">Informe o <?php echo $i; ?>º valor:</label>
                <input class="form-control mb-3" type="number" name="valores[]" required><br>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $lista = $_POST["valores"];
            $menorValor = min($lista);
            $posicaoMenor = array_search($menorValor, $lista);
            echo "O menor valor é $menorValor e ele está no input " . ($posicaoMenor + 1);
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>