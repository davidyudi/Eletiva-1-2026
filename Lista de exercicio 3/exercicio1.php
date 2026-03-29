<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exercício 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-3">
        <h1>Exercício 1</h1>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Informe o 1º valor:</label>
                <input class="form-control" type="number" name="v1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 2º valor:</label>
                <input class="form-control" type="number" name="v2" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 3º valor:</label>
                <input class="form-control" type="number" name="v3" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 4º valor:</label>
                <input class="form-control" type="number" name="v4" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 5º valor:</label>
                <input class="form-control" type="number" name="v5" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 6º valor:</label>
                <input class="form-control" type="number" name="v6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Informe o 7º valor:</label>
                <input class="form-control" type="number" name="v7" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>

        <hr>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $v1 = $_POST["v1"];
            $v2 = $_POST["v2"];
            $v3 = $_POST["v3"];
            $v4 = $_POST["v4"];
            $v5 = $_POST["v5"];
            $v6 = $_POST["v6"];
            $v7 = $_POST["v7"];
            $menor = $v1;
            $posicao = 1;
            if ($v2 < $menor) {
                $menor = $v2;
                $posicao = 2;
            }
            if ($v3 < $menor) {
                $menor = $v3;
                $posicao = 3;
            }
            if ($v4 < $menor) {
                $menor = $v4;
                $posicao = 4;
            }
            if ($v5 < $menor) {
                $menor = $v5;
                $posicao = 5;
            }
            if ($v6 < $menor) {
                $menor = $v6;
                $posicao = 6;
            }
            if ($v7 < $menor) {
                $menor = $v7;
                $posicao = 7;
            }
            echo "<p>O menor valor digitado foi: <strong>$menor</strong></p>";
            echo "<p>Ele foi informado na posição: <strong>$posicao</strong></p>";
        }
        ?>
    </div>
</body>

</html>