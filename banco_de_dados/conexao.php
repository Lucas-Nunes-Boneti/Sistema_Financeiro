<?php

//dados para a conexão
$servidor = "localhost";
$usuario = "root";
$senha = ""; 
$banco = "db_sistema_financeiro";

$conexao =
  mysqli_connect($servidor, $usuario, $senha, $banco)
  or die("Não foi possivél conectar o banco de dados . Erro: " .
    mysqli_connect_error());

if (isset($conexao)) {
  echo "";
}
