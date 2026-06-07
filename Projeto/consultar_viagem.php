<?php
include('cabecalho.php');
require_once('conexao.php');

try {

    $stmt = $conexao->prepare("
            SELECT
                v.*,
                m.nome,
                ve.Placa,
                r.Cidade_inicio,
                r.Estado_inicio,
                r.Cidade_fim,
                r.Estado_fim
            FROM viagens v
            INNER JOIN motoristas m
                ON m.id = v.Motoristas_id
            INNER JOIN Veiculos ve
                ON ve.id = v.Veiculos_id
            INNER JOIN rotas r
                ON r.id = v.rotas_id
            WHERE v.id = ?
        ");

    $stmt->execute([$_GET['id']]);

    $resultado = $stmt->fetch();
} catch (Exception $e) {
    echo "Erro! " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];

    try {

        $sql = "DELETE FROM viagens WHERE id = ?";

        $stmt = $conexao->prepare($sql);

        if ($stmt->execute([$id])) {
            header('Location: crud_viagem.php');
            exit;
        } else {
            echo "Erro ao excluir";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow rounded-4 border-0">

                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Consultar Viagem</h5>
                </div>

                <div class="card-body p-4">

                    <form
                        id="formExcluir"
                        method="post"
                        action="consultar_viagem.php?id=<?= $resultado['id'] ?>">

                        <div class="row g-3 mb-3">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Motorista
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($resultado['nome']) ?>"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Veículo
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($resultado['Placa']) ?>"
                                    readonly>
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Rota
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="<?= htmlspecialchars($resultado['Cidade_inicio']) ?> - <?= htmlspecialchars($resultado['Estado_inicio']) ?> → <?= htmlspecialchars($resultado['Cidade_fim']) ?> - <?= htmlspecialchars($resultado['Estado_fim']) ?>"
                                readonly>

                        </div>

                        <div class="row g-3 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Data de Saída
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($resultado['data_saida']) ?>"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Data de Chegada
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($resultado['data_chegada']) ?>"
                                    readonly>
                            </div>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#modalExcluir">
                                Excluir
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

<div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Você tem certeza que deseja remover esta viagem? Esta operação é permanente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="document.getElementById('formExcluir').submit();" class="btn btn-danger">Sim, Excluir</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once('rodape.php');
?>