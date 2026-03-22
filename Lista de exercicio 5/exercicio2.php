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
                <label class="form-label">Informe o <?php echo $i; ?>º nome do aluno: </label>
                <input class="form-control mb-3" type="text" name="nome[]" required><br>
                <?php for ($j = 1; $j <= 3; $j++): ?>
                <label class="form-label">Informe a <?php echo $j; ?>ª nota do <?php echo $i?>º aluno: </label>
                <input class="form-control mb-3" type="text" name="notas[]" required><br>
                <?php endfor; ?>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nomes = $_POST["nome"];
            $notas = $_POST["notas"];
            $mapaOrdenado = [];
            $posNota = 0;
            for ($i = 0; $i < count($nomes); $i++) {
                $nome = trim($nomes[$i]);
                $media = 0;
                for ($j = 0; $j < 3; $j++) {
                $media += $notas[$posNota];
                $posNota++;
                }
                $media = $media/3;
                $mapaOrdenado[$nome] = $media;
            }
            arsort($mapaOrdenado);
            foreach ($mapaOrdenado as $chave => $valor) {
                $valorFormatado = number_format((float)$valor, 1, ',', '.');
                echo "<p><strong>Nome:</strong> $chave <strong>| Média:</strong> $valorFormatado</p>";
            }
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>