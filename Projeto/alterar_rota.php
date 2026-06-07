<?php
    require_once('cabecalho.php');
    require_once('conexao.php');

    $estados = $conexao->query(
        'SELECT e.id, e.sigla FROM estados e ORDER BY e.sigla'
    )->fetchAll(PDO::FETCH_ASSOC);

    $todasCidades = $conexao->query(
        'SELECT c.id, c.nome, c.estado_id FROM cidades c ORDER BY c.nome'
    )->fetchAll(PDO::FETCH_ASSOC);

    $cidadesPorEstado = [];
    foreach ($todasCidades as $c) {
        $cidadesPorEstado[$c['estado_id']][] = ['id' => $c['id'], 'nome' => $c['nome']];
    }
    $cidadesJson = json_encode($cidadesPorEstado, JSON_UNESCAPED_UNICODE);
    $estadosJson = json_encode($estados, JSON_UNESCAPED_UNICODE);

    $mensagem = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cidade_inicio = $_POST['cidade_inicio_nome'];
        $estado_inicio = $_POST['estado_inicio'];
        $cidade_fim    = $_POST['cidade_fim_nome'];
        $estado_fim    = $_POST['estado_fim'];
        $id            = $_GET['id'];
        try {
            $sql  = "UPDATE rotas SET Cidade_inicio=?, Estado_inicio=?, Cidade_fim=?, Estado_fim=? WHERE id=?";
            $stmt = $conexao->prepare($sql);
            if ($stmt->execute([$cidade_inicio, $estado_inicio, $cidade_fim, $estado_fim, $id])) {
                $mensagem = "<p>Alteração Realizada!</p>";
            } else {
                $mensagem = "<p>Erro ao Alterar! Tente novamente.</p>";
            }
        } catch(Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    // Busca rota atual
    $stmt = $conexao->prepare("SELECT * FROM rotas WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $resultado = $stmt->fetch();

    // Busca estado_id pelo estado_sigla atual para pré-selecionar
    $stE = $conexao->prepare('SELECT id FROM estados WHERE sigla = ?');
    $stE->execute([$resultado['Estado_inicio']]);
    $estadoInicioId = $stE->fetchColumn();
    $stE->execute([$resultado['Estado_fim']]);
    $estadoFimId = $stE->fetchColumn();

    // Busca id da cidade atual pelo nome e estado
    $stC = $conexao->prepare('SELECT id FROM cidades WHERE nome = ? AND estado_id = ?');
    $stC->execute([$resultado['Cidade_inicio'], $estadoInicioId]);
    $cidadeInicioId = $stC->fetchColumn();
    $stC->execute([$resultado['Cidade_fim'], $estadoFimId]);
    $cidadeFimId = $stC->fetchColumn();
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Alterar Rota</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post">

                        <!-- INÍCIO -->
                        <p class="fw-bold text-uppercase" style="font-size:.75rem;letter-spacing:1px;color:#888;margin-bottom:8px;">Ponto de Início</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select id="estado_inicio_sel" name="estado_inicio" class="form-select" required
                                    onchange="carregarCidades(this.value, 'cidade_inicio_id', 'cidade_inicio_label', null)">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($estados as $e): ?>
                                        <option value="<?= $e['sigla'] ?>" data-id="<?= $e['id'] ?>"
                                            <?= $e['sigla'] == $resultado['Estado_inicio'] ? 'selected' : '' ?>>
                                            <?= $e['sigla'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Cidade</label>
                                <select id="cidade_inicio_id" name="cidade_inicio_id" class="form-select" required>
                                    <option value="">Carregando...</option>
                                </select>
                                <input type="hidden" id="cidade_inicio_label" name="cidade_inicio_nome"
                                    value="<?= htmlspecialchars($resultado['Cidade_inicio']) ?>">
                            </div>
                        </div>

                        <!-- FIM -->
                        <p class="fw-bold text-uppercase" style="font-size:.75rem;letter-spacing:1px;color:#888;margin-bottom:8px;">Ponto de Fim</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select id="estado_fim_sel" name="estado_fim" class="form-select" required
                                    onchange="carregarCidades(this.value, 'cidade_fim_id', 'cidade_fim_label', null)">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($estados as $e): ?>
                                        <option value="<?= $e['sigla'] ?>" data-id="<?= $e['id'] ?>"
                                            <?= $e['sigla'] == $resultado['Estado_fim'] ? 'selected' : '' ?>>
                                            <?= $e['sigla'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Cidade</label>
                                <select id="cidade_fim_id" name="cidade_fim_id" class="form-select" required>
                                    <option value="">Carregando...</option>
                                </select>
                                <input type="hidden" id="cidade_fim_label" name="cidade_fim_nome"
                                    value="<?= htmlspecialchars($resultado['Cidade_fim']) ?>">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Alterar</button>
                            <a href="crud_rotas.php" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const cidadesPorEstado = <?= $cidadesJson ?>;
const estadosList      = <?= $estadosJson ?>;

function carregarCidades(sigla, selectCidadeId, hiddenNomeId, preSelectCidadeId) {
    const selectCidade = document.getElementById(selectCidadeId);
    const hiddenNome   = document.getElementById(hiddenNomeId);

    selectCidade.innerHTML = '<option value="">Selecione a cidade...</option>';
    selectCidade.disabled  = true;
    if (!preSelectCidadeId) hiddenNome.value = '';

    if (!sigla) return;

    const estado = estadosList.find(e => e.sigla === sigla);
    if (!estado) return;

    const cidades = cidadesPorEstado[estado.id] || [];
    cidades.forEach(c => {
        const opt = document.createElement('option');
        opt.value       = c.id;
        opt.textContent = c.nome;
        if (preSelectCidadeId && c.id == preSelectCidadeId) {
            opt.selected    = true;
            hiddenNome.value = c.nome;
        }
        selectCidade.appendChild(opt);
    });

    selectCidade.disabled = false;

    selectCidade.onchange = function() {
        const opt = this.options[this.selectedIndex];
        hiddenNome.value = opt ? opt.textContent : '';
    };
}

// Pré-carrega cidades ao abrir a página com os valores atuais
window.addEventListener('DOMContentLoaded', function() {
    carregarCidades(
        '<?= addslashes($resultado['Estado_inicio']) ?>',
        'cidade_inicio_id',
        'cidade_inicio_label',
        <?= (int)$cidadeInicioId ?>
    );
    carregarCidades(
        '<?= addslashes($resultado['Estado_fim']) ?>',
        'cidade_fim_id',
        'cidade_fim_label',
        <?= (int)$cidadeFimId ?>
    );
});
</script>

<?php echo $mensagem; ?>
<?php require_once('rodape.php'); ?>
