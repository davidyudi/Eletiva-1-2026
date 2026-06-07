<?php
include('cabecalho.php');
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

$estadosPorSigla = [];
foreach ($estados as $e) {
    $estadosPorSigla[$e['sigla']] = $e['id'];
}
$estadosJson = json_encode($estados, JSON_UNESCAPED_UNICODE);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 px-2">| Nova Rota</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post">

                        <p class="fw-bold text-uppercase" style="font-size:.75rem;letter-spacing:1px;color:#888;margin-bottom:8px;">Ponto de Início</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="estado_inicio_sel" class="form-label">Estado</label>
                                <select id="estado_inicio_sel" name="estado_inicio" class="form-select" required
                                    onchange="carregarCidades(this.value, 'cidade_inicio_id', 'cidade_inicio_label')">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($estados as $e): ?>
                                        <option value="<?= $e['sigla'] ?>" data-id="<?= $e['id'] ?>">
                                            <?= $e['sigla'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="cidade_inicio_id" class="form-label">Cidade</label>
                                <select id="cidade_inicio_id" name="cidade_inicio_id" class="form-select" required disabled>
                                    <option value="">Selecione o estado primeiro...</option>
                                </select>
                                <input type="hidden" id="cidade_inicio_label" name="cidade_inicio_nome">
                            </div>
                        </div>

                        <p class="fw-bold text-uppercase" style="font-size:.75rem;letter-spacing:1px;color:#888;margin-bottom:8px;">Ponto de Fim</p>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="estado_fim_sel" class="form-label">Estado</label>
                                <select id="estado_fim_sel" name="estado_fim" class="form-select" required
                                    onchange="carregarCidades(this.value, 'cidade_fim_id', 'cidade_fim_label')">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($estados as $e): ?>
                                        <option value="<?= $e['sigla'] ?>" data-id="<?= $e['id'] ?>">
                                            <?= $e['sigla'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="cidade_fim_id" class="form-label">Cidade</label>
                                <select id="cidade_fim_id" name="cidade_fim_id" class="form-select" required disabled>
                                    <option value="">Selecione o estado primeiro...</option>
                                </select>
                                <input type="hidden" id="cidade_fim_label" name="cidade_fim_nome">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
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
    const estadosList = <?= $estadosJson ?>;

    function carregarCidades(sigla, selectCidadeId, hiddenNomeId) {
        const selectCidade = document.getElementById(selectCidadeId);
        const hiddenNome = document.getElementById(hiddenNomeId);

        selectCidade.innerHTML = '<option value="">Selecione a cidade...</option>';
        selectCidade.disabled = true;
        hiddenNome.value = '';

        if (!sigla) return;

        const estado = estadosList.find(e => e.sigla === sigla);
        if (!estado) return;

        const cidades = cidadesPorEstado[estado.id] || [];
        cidades.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.nome;
            selectCidade.appendChild(opt);
        });

        selectCidade.disabled = false;

        selectCidade.onchange = function() {
            const opt = this.options[this.selectedIndex];
            hiddenNome.value = opt ? opt.textContent : '';
        };
    }
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cidade_inicio = $_POST['cidade_inicio_nome'];
    $estado_inicio = $_POST['estado_inicio'];
    $cidade_fim    = $_POST['cidade_fim_nome'];
    $estado_fim    = $_POST['estado_fim'];
    try {
        $stmt = $conexao->prepare(
            'INSERT INTO rotas (Cidade_inicio, Estado_inicio, Cidade_fim, Estado_fim) VALUES (?,?,?,?);'
        );
        if ($stmt->execute([$cidade_inicio, $estado_inicio, $cidade_fim, $estado_fim])) {
            echo "<p>Cadastro Realizado!</p>";
        } else {
            echo "<p>Erro ao cadastrar! Tente novamente.</p>";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
<?php include('rodape.php'); ?>