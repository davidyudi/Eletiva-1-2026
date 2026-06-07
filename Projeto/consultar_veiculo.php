<?php
    include('cabecalho.php');
    require_once('conexao.php');
    try{
        $stmt = $conexao->prepare('SELECT * FROM Veiculos WHERE id=?');
        $stmt->execute([$_GET['id']]);
        $resultado = $stmt->fetch();
    } catch(Exception $e){
        echo "Erro!".$e->getMessage();
    }
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_GET['id'];
        try{
            $sql = "DELETE FROM Veiculos WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            if($stmt->execute([$id])){
                header('Location:crud_veiculos.php');
            }
            else{
                echo "Erro ao excluir";
            }
        } catch(Exception $e){
            echo "Erro: ".$e->getMessage();
        }
    }
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-header bg-dark text-white py-3 rounded-top-4">
                        <h5 class="mb-0 px-2">| Consultar Veículo</h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="formExcluir" method="post" action ="consultar_veiculo.php?id=<?=  $resultado['id'] ?>">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="placa" class="form-label">Placa</label>
                                    <input value="<?= $resultado['Placa'] ?>" type="text" id="placa" name="placa" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input value="<?= $resultado['Modelo'] ?>" type="text" id="modelo" name="modelo" class="form-control" readonly>
                                </div>
                            </div>

                            <div class ="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="cor" class="form-label">Cor</label>
                                    <input value="<?= $resultado['Cor'] ?>" type="text" id="cor" name="cor" class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="fabricante" class="form-label">Fabricante</label>
                                    <input value="<?= $resultado['Fabricante'] ?>" type="text" id="fabricante" name="fabricante" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-danger" data-bs-toggle = "modal" data-bs-target="#modalExcluir">Excluir</button>
                                <a href="crud_veiculos.php" class="btn btn-secondary">Voltar</a>
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
        Você tem certeza que deseja remover este veículo? Esta operação é permanente.
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
