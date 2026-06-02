<?php
    require_once('cabecalho.php');
?>

<h1>Nova Categoria</h1>
<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o nome</label>
        <input type="text" id="descricao" name="nome" class="form-control" required="">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        require_once('conexao.php');
        $nome = $_POST['nome'];
        try
            {
                $stmt = $conexao->prepare('INSERT INTO categoria (nome) VALUES (?);');//? -> apelido pra n colocar direto a variavle do bd
                if($stmt->execute([$nome]))
                {
                    echo "<p>Cadastro realizado!</p>";
                }
                else
                {
                    echo "<p>Erro ao cadastrar! Tente novamente</p>";
                }
            }
        catch(Exception $e)
            {
                echo "Erro: ".$e->getMessage();
            }
            }
        ?>

<?php
    require_once('rodape.php');
?>