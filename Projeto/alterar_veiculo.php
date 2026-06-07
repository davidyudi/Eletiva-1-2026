<?php
require_once('cabecalho.php');
require_once('conexao.php');
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $cor = $_POST['cor'];
    $fabricante = $_POST['fabricante'];
    $id = $_GET['id'];
    try {
        $sql = "UPDATE Veiculos SET placa = ?, modelo = ?, cor = ?, fabricante = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([$placa, $modelo, $cor, $fabricante, $id])) {
            header("Location: crud_veiculos.php?msg=editado");
            exit;
        } else {
            header("Location: crud_veiculos.php?msg=erro");
            exit;
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
try {
    $stmt = $conexao->prepare("SELECT * FROM Veiculos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $resultado = $stmt->fetch();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Alterar Veículo</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="placa" class="form-label">Placa</label>
                                <input value="<?= $resultado['Placa'] ?>" type="text" id="placa" name="placa" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input value="<?= $resultado['Modelo'] ?>" type="text" id="modelo" name="modelo" class="form-control" required="">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="cor" class="form-label">Cor</label>
                                <input value="<?= $resultado['Cor'] ?>" type="text" id="cor" name="cor" class="form-control" required="">
                            </div>

                            <div class="col-md-6">
                                <label for="fabricante" class="form-label">Fabricante</label>
                                <input value="<?= $resultado['Fabricante'] ?>" type="text" id="fabricante" name="fabricante" class="form-control" required="">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Alterar</button>
                            <a href="crud_veiculos.php" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $mensagem;
?>

<?php
require_once('rodape.php');
?>