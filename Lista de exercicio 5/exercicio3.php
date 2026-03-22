<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercicio 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Exercicio 3</h1>
        <form method="POST">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                 <h3><?php echo $i?>º Produto:</h3>
                <label class="form-label">Código: </label>
                <input class="form-control mb-3" type="number" name="cod[]" required><br>

                <label class="form-label">Nome: </label>
                <input class="form-control mb-3" type="text" name="nome[]" required><br>

                <label class="form-label">Preço: </label>
                <input class="form-control mb-3" type="text" name="preco[]" required><br>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $codigos = $_POST["cod"];
            $nomes = $_POST["nome"];
            $precos = $_POST["preco"];
            $catalogo = array();
            for ($i = 0; $i < count($codigos); $i++) {
                $codigo = trim($codigos[$i]);                
                $catalogo[$codigo] = array(
                    "nome" => trim($nomes[$i]),
                    "preco" => (float)$precos[$i]
                );
            }
            foreach ($catalogo as $codigo => $produto) {
                if ($produto["preco"] > 100.00) {
                    $catalogo[$codigo]["preco"] *= 0.90; 
                }
            }
            uasort($catalogo, function($a, $b) {
                return strcmp($a["nome"], $b["nome"]);
            });
            echo "<h3 class='mt-4'>Catálogo de Produtos:</h3>";
            echo "<div class='llist-group'>";
            foreach ($catalogo as $codigo => $item) {
                $precoFormatado = number_format($item["preco"], 2, ',', '.');
                echo "<p><strong>Código:</strong> $codigo | <strong>Produto:</strong> {$item['nome']} | <strong>Preço Final:</strong> R$ $precoFormatado</p>";
            }
        }
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>
    </div>
</body>

</html>
