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
        <h1>Exercicio 3</h1>
        <form method="post">
            <div class="mb-3">
                <label for="fahrenheit" class="form-label">Informe a temperatura em Fahrenheit</label>
                <input type="number" id="fahrenheit" name="fahrenheit" class="form-control" required="">
            </div>
            <button type="submit" class="btn btn-primary">Converter</button>
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $fahrenheit = $_POST['fahrenheit'];
                $conv = ($fahrenheit - 32) * 5/9;
                echo "A conversão resulta em $conv";
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
</body>
</html>