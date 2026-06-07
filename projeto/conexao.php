<?php

$dominio = "mysql:host=127.0.0.1;dbname=projetophp";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO($dominio, $usuario, $senha);
} catch (Exception $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}
