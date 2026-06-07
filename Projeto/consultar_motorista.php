<?php
include('cabecalho.php');
require_once('conexao.php');
try {
    $stmt = $conexao->prepare('SELECT * FROM motoristas WHERE id=?');
    $stmt->execute([$_GET['id']]);
    $resultado = $stmt->fetch();
} catch (Exception $e) {
    echo "Erro!" . $e->getMessage();
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    try {
        $sql  = "DELETE FROM motoristas WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([$id])) {
            header('Location: crud_motoristas.php?msg=excluido');
            exit;
        } else {
            header('Location: crud_motoristas.php?msg=erro');
            exit;
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
                    <h5 class="mb-0 px-2">| Consultar Motorista</h5>
                </div>
                <div class="card-body p-4">
                    <form id="formExcluir" method="post" action="consultar_motorista.php?id=<?= $resultado['id'] ?>">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome</label>
                                <input value="<?= htmlspecialchars($resultado['nome']) ?>" type="text" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Data de Nascimento</label>
                                <input value="<?= htmlspecialchars($resultado['data_nascimento']) ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">CPF</label>
                                <input value="<?= htmlspecialchars($resultado['cpf']) ?>" type="text" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CNH</label>
                                <input value="<?= htmlspecialchars($resultado['cnh']) ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input value="<?= htmlspecialchars($resultado['email']) ?>" type="text" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input value="<?= htmlspecialchars($resultado['telefone']) ?>" type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
                            <a href="crud_motoristas.php" class="btn btn-secondary">Voltar</a>
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
                Você tem certeza que deseja remover este motorista? Esta operação é permanente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="document.getElementById('formExcluir').submit();" class="btn btn-danger">Sim, Excluir</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('rodape.php'); ?>