<?php
require_once('cabecalho.php');
require_once('conexao.php');
$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome            = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf             = $_POST['cpf'];
    $email           = $_POST['email'];
    $telefone        = $_POST['telefone'];
    $cnh             = $_POST['cnh'];
    $id              = $_GET['id'];
    try {
        $sql  = "UPDATE motoristas SET nome=?, data_nascimento=?, cpf=?, email=?, telefone=?, cnh=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([$nome, $data_nascimento, $cpf, $email, $telefone, $cnh, $id])) {
            $mensagem = "<p>Alteração Realizada!</p>";
        } else {
            $mensagem = "<p>Erro ao Alterar! Tente novamente.</p>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
try {
    $stmt = $conexao->prepare("SELECT * FROM motoristas WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $resultado = $stmt->fetch();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Alterar Motorista</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input value="<?= htmlspecialchars($resultado['nome']) ?>" type="text" id="nome" name="nome" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input value="<?= htmlspecialchars($resultado['data_nascimento']) ?>" type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF</label>
                                <input value="<?= htmlspecialchars($resultado['cpf']) ?>" type="text" id="cpf" name="cpf" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cnh" class="form-label">CNH</label>
                                <input value="<?= htmlspecialchars($resultado['cnh']) ?>" type="text" id="cnh" name="cnh" class="form-control" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input value="<?= htmlspecialchars($resultado['email']) ?>" type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input value="<?= htmlspecialchars($resultado['telefone']) ?>" type="text" id="telefone" name="telefone" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Alterar</button>
                            <a href="crud_motoristas.php" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $mensagem; ?>
<?php require_once('rodape.php'); ?>