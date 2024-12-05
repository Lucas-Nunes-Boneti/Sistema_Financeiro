<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a receber</title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>
    <form action="contasapagar2.php" method="post">
        <p>Contas a receber</p>
        <div class="container">
            <img src="" alt="">
            <div>
            <label for="data">Data:
                <input type="date" id="data_inicial" name="data_inicial">
            </label> 
        </div>
             
           <div>
            <?php
            include("../banco_de_dados/conexao.php");
            $sql = "SELECT nome FROM tb_usuario";
            $result = $conexao->query($sql);
            ?>
    
            <label for="cpf">Cliente:</label>
            <select id="cpf" name="cpf">
                <option value="">Selecione o Cliente:</option>
                <?php 
                if ($result->num_rows > 0) { 
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['cpf'] . '">' . $row['nome'] . '</option>';
                    }
                } else {
                    echo '<option value="">Nenhuma cliente encontrada</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <label for="nome">Descrição: 
                <input type="text" id="nome" name="nome"  >
            </label> 
        </div>
        <div>
            <label for="data">Data de Vencimento:
                <input type="date" id="data_vencimento" name="data_vencimento">
            </label> 
        </div>

        <div>
            <label for="valor">Valor:
                <input type="number" id="valor" name="valor"  >
            </label> 
        </div>
        <div>
            <label for="status">Situação:
                <input type="radio" id="pendente" name="status"  >Pendente &nbsp;&nbsp;
                <input type="radio" id="baixada" name="status"  >Baixada&nbsp;&nbsp;
                <input type="radio" id="vencida" name="status"  >Vencida
            </label>
        </div>

        <button type="submit" >Registrar</button>
       
    </form>
</body>
</html>
