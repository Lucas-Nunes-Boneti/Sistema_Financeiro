<?php


session_start();
include("..\banco_de_dados/conexao.php");
//verifica se campos validos
if (isset($_POST['cpf']) && isset($_POST['senha'])) {
   //entrada de dados vindos do HTML
   $cpf = $_POST['cpf'];
   $senha = $_POST['senha'];
   //verifica se campos nao estão vazios
   if (empty($cpf) || empty($senha)){
       $_SESSION['msg'] = "<p> Preencha seus dados</p>";
       header("Location: homePage.html");
       exit;
   }

   $resultQuery = " select * from tb_cliente where
       cpf = '$cpf' and senha = '$senha'";

   $resultadoLogin = mysqli_query($conexao, $resultQuery);
  
   if (mysqli_num_rows($resultadoLogin) == 1) {
       $usuario = mysqli_fetch_assoc($resultadoLogin);
       $_SESSION['cpf'] = $usuario['cpf'];
       $_SESSION['senha'] = $usuario['senha'];
       header("Location: usuario.html");
   } else {
       // CPF ou senha incorretos
       $_SESSION['msg'] = "CPF ou senha incorretos.";
       header("Location: erro.html");
   }
} else {
   $_SESSION['msg'] = "Acesso inválido.";
   header("Location: erro.html");


}
?>
