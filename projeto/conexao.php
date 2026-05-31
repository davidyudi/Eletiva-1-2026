<?php
$dominio = "mysql:host=localhost;dbname=frota;charset=utf8mb4";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO($dominio, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}