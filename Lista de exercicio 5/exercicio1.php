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
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <label class="form-label">Informe o <?php echo $i; ?>º Nome: </label>
                <input class="form-control mb-3" type="text" name="nome[]" required><br>
                <label class="form-label">Informe o <?php echo $i; ?>º Telefone: </label>
                <input class="form-control mb-3" type="text" name="tel[]" required><br>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nomes = $_POST["nome"];
            $tels = $_POST["tel"];
            $mapaOrdenado = [];
            for ($i = 0; $i < count($nomes); $i++) {
                $nome = trim($nomes[$i]);
                $telefone = trim($tels[$i]);
                $mapaOrdenado[$nome] = $telefone;
            }
            ksort($mapaOrdenado);
            foreach ($mapaOrdenado as $chave => $valor) {
                echo "<p><strong>Nome:</strong> $chave <strong>| Telefone:</strong> $valor</p>";
            }
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>