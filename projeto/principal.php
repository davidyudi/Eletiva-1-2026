<?php
include('cabecalho.php');
?>
<h2>Seja bem vindo <?= $_SESSION['nome'] ?></h2>
<?php

require_once('conexao.php');

echo $conexao->query("SELECT DATABASE()")->fetchColumn();

?>
<?php
include('rodape.php');
?>