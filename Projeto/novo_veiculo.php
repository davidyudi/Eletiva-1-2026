<?php
include('cabecalho.php');
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Novo Veículo</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" id="placa" name="placa" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" id="modelo" name="modelo" class="form-control" required="">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="cor" class="form-label">Cor</label>
                                <input type="text" id="cor" name="cor" class="form-control" required="">
                            </div>

                            <div class="col-md-6">
                                <label for="fabricante" class="form-label">Fabricante</label>
                                <input type="text" id="fabricante" name="fabricante" class="form-control" required="">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="crud_veiculos.php" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('conexao.php');
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $cor = $_POST['cor'];
    $fabricante = $_POST['fabricante'];
    try {
        $stmt = $conexao->prepare('INSERT INTO Veiculos (placa,modelo,cor,fabricante) VALUES (?,?,?,?);');
        if ($stmt->execute([$placa, $modelo, $cor, $fabricante])) {
            echo "<p>Cadastro Realizado!</p>";
        } else {
            echo "<p>Erro ao cadastrar! Tente novamente</p>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<?php
include('rodape.php');
?>