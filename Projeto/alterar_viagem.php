<?php
require_once('cabecalho.php');
require_once('conexao.php');

$motoristas = $conexao->query(
    "SELECT id, nome FROM motoristas ORDER BY nome"
)->fetchAll();

$veiculos = $conexao->query(
    "SELECT id, Placa FROM Veiculos ORDER BY Placa"
)->fetchAll();

$rotas = $conexao->query(
    "SELECT * FROM rotas ORDER BY Cidade_inicio"
)->fetchAll();

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id             = $_GET['id'];
    $Motoristas_id  = $_POST['Motoristas_id'];
    $Veiculos_id    = $_POST['Veiculos_id'];
    $rotas_id       = $_POST['rotas_id'];
    $data_saida     = $_POST['data_saida'];
    $data_chegada   = $_POST['data_chegada'];

    try {

        $sql = "
                UPDATE viagens
                SET
                    Veiculos_id = ?,
                    Motoristas_id = ?,
                    rotas_id = ?,
                    data_saida = ?,
                    data_chegada = ?
                WHERE id = ?
            ";

        $stmt = $conexao->prepare($sql);

        if (
            $stmt->execute([
                $Veiculos_id,
                $Motoristas_id,
                $rotas_id,
                $data_saida,
                $data_chegada,
                $id
            ])
        ) {
            header("Location: crud_viagem.php?msg=editado");
            exit;
        } else {
            header("Location: crud_viagem.php?msg=erro");
            exit;
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

try {

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: crud_viagem.php?msg=erro");
        exit;
    }

    $id = $_GET['id'];

    $stmtSelect = $conexao->prepare("SELECT * FROM viagens WHERE id = ?");
    $stmtSelect->execute([$id]);

    $resultado = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        header("Location: crud_viagem.php?msg=erro");
        exit;
    }
} catch (Exception $e) {
    header("Location: crud_viagem.php?msg=erro");
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow rounded-4 border-0">

                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Alterar Viagem</h5>
                </div>

                <div class="card-body p-4">

                    <form method="post">

                        <div class="row g-3 mb-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Motorista
                                </label>

                                <select name="Motoristas_id"
                                    class="form-select"
                                    required>

                                    <?php foreach ($motoristas as $m): ?>

                                        <option
                                            value="<?= $m['id'] ?>"
                                            <?= $m['id'] == $resultado['Motoristas_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($m['nome']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Veículo
                                </label>

                                <select name="Veiculos_id"
                                    class="form-select"
                                    required>

                                    <?php foreach ($veiculos as $v): ?>

                                        <option
                                            value="<?= $v['id'] ?>"
                                            <?= $v['id'] == $resultado['Veiculos_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($v['Placa']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Rota
                            </label>

                            <select name="rotas_id"
                                class="form-select"
                                required>

                                <?php foreach ($rotas as $r): ?>

                                    <option
                                        value="<?= $r['id'] ?>"
                                        <?= $r['id'] == $resultado['rotas_id'] ? 'selected' : '' ?>>

                                        <?= $r['Cidade_inicio'] ?>
                                        -
                                        <?= $r['Estado_inicio'] ?>

                                        →

                                        <?= $r['Cidade_fim'] ?>
                                        -
                                        <?= $r['Estado_fim'] ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="row g-3 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Data de Saída
                                </label>

                                <input
                                    type="date"
                                    name="data_saida"
                                    class="form-control"
                                    value="<?= $resultado['data_saida'] ?>"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Data de Chegada
                                </label>

                                <input
                                    type="date"
                                    name="data_chegada"
                                    class="form-control"
                                    value="<?= $resultado['data_chegada'] ?>">
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">
                                Alterar
                            </button>

                            <a
                                href="crud_viagem.php"
                                class="btn btn-secondary">
                                Voltar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

<?= $mensagem ?>

<?php
require_once('rodape.php');
?>