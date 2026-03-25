<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercicio 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Exercicio 4</h1>
        <form method="POST">
            <?php for ($i = 1; $i <= 2; $i++): ?>
                 <h3><?php echo $i?>º Produto:</h3>
                <label class="form-label">Nome: </label>
                <input class="form-control mb-3" type="text" name="nome[]" required><br>

                <label class="form-label">Preço: </label>
                <input class="form-control mb-3" type="text" name="preco[]" required><br>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nome = $_POST["nome"];
            $precos = $_POST["preco"];
            $mapa = [];
            for ($i = 0; $i < count($nome); $i++) {    
                $mapa[$nome[$i]] = $precos[$i] + ($precos[$i] * (15/100));
            }
            arsort($mapa);
            foreach ($mapa as $chave => $valor){
                $valorFormatado = number_format((float)$valor, 2, ',', '.');
                echo "<p><strong>Nome:</strong> $chave <strong>| Preço:</strong> $valorFormatado</p>";
            }
        }
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>
