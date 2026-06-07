<?php
include('cabecalho.php');
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
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow rounded-4 border-0">

                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Nova Viagem</h5>
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

                                    <option value="">
                                        Selecione...
                                    </option>

                                    <?php foreach ($motoristas as $m): ?>
                                        <option value="<?= $m['id'] ?>">
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

                                    <option value="">
                                        Selecione...
                                    </option>

                                    <?php foreach ($veiculos as $v): ?>
                                        <option value="<?= $v['id'] ?>">
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

                                <option value="">
                                    Selecione...
                                </option>

                                <?php foreach ($rotas as $r): ?>
                                    <option value="<?= $r['id'] ?>">

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

                                <input type="date"
                                    name="data_saida"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Data de Chegada
                                </label>

                                <input type="date"
                                    name="data_chegada"
                                    class="form-control">
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button type="submit"
                                class="btn btn-primary">
                                Cadastrar
                            </button>

                            <a href="crud_viagem.php"
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

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Motoristas_id = $_POST['Motoristas_id'];
    $Veiculos_id   = $_POST['Veiculos_id'];
    $rotas_id      = $_POST['rotas_id'];
    $data_saida    = $_POST['data_saida'];
    $data_chegada  = $_POST['data_chegada'];

    try {

        $stmt = $conexao->prepare(
            "INSERT INTO viagens
            (
                Veiculos_id,
                Motoristas_id,
                rotas_id,
                data_saida,
                data_chegada
            )
            VALUES (?,?,?,?,?)"
        );

        if (
            $stmt->execute([
                $Veiculos_id,
                $Motoristas_id,
                $rotas_id,
                $data_saida,
                $data_chegada
            ])
        ) {
            echo "<p>Cadastro Realizado!</p>";
        } else {
            echo "<p>Erro ao cadastrar!</p>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}

include('rodape.php');
?>