<?php

    $dominio = "mysql:host=127.0.0.1;dbname=projetophp";//SGBD/ onde ta hospedado o meu banco de dados/dbname
    $usuario = "root";
    $senha = "";

    try {
        $conexao = new PDO($dominio,$usuario,$senha);//PHP data object
    } catch(Exception $e){
        die("Erro ao conectar ao banco: ".$e->getMessage());
    }
