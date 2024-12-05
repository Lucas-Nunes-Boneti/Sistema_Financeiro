<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas a Pagar</title>
    <link rel="stylesheet" href="../html/cadastro.css">
</head>
<body>
    <form action="../php/contasapagar2.php" method="post">
        <p>Contas a Pagar</p>
        <div class="container">
            <img src="" alt="">
   
        <div>
            <label for="nome">Nome: 
                <input type="text" id="nome" name="nome" required>
            </label><br><br>
        </div>
        
      
        <div>
            <label for="data">Data de Vencimento:
                <input type="date" id="data" name="data">
            </label><br><br>
        </div>

        <div>
            <label for="descricao">Descrição:
                <input type="text" id="descricao" name="descricao" >
            </label><br><br>
        </div>

        <div>
            <label for="valor">Valor:
                <input type="number" id="valor" name="valor" min="0" step="0.01" >
            </label><br><br>
        </div>
        <div>
           <?php
            include("../banco_de_dados/conexao.php");
            $sql = "SELECT * FROM tb_fornecedor";
            $result = $conexao->query($sql);
            ?>
    
            <label for="fornecedor">Fornecedor:</label>
            <select id="fornecedor" name="fornecedor">
                <option value="">Selecione o Fornecedor</option>
                <?php
                 
                if ($result->num_rows > 0) {
                    // loop que verifica se há categorias
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_cnpj'] . '">' . $row['nome'] . '</option>';
                    }
                } else {
                    echo '<option value="">Nenhuma Fornecedor encontrado</option>';
                }
                ?>
            </select>
            <br>
        </div>
        
        <div>
            <?php
            include("../banco_de_dados/conexao.php");
            $sql = "SELECT * FROM tb_categoria";
            $result = $conexao->query($sql);
            ?>
    
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria">
                <option value="">Selecione a categoria</option>
                <?php
                // Verifica se há dados retornados pela consulta
                if ($result->num_rows > 0) {
                    // loop que verifica se há categorias
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_categoria'] . '">' . $row['nome_categoria'] . '</option>';
                    }
                } else {
                    echo '<option value="">Nenhuma categoria encontrada</option>';
                }
                ?>
            </select>
        </div>
        <div>
           <label for="status">Status
                <input type="radio" name="status" id="pendente" value="pendente">Pendente
                <input type="radio" name="status" id="vencido" value="vencido">Vencido
                <input type="radio" name="status" id="recebido"  value="recebido">Recebido
            </label>
        </div>

        <button type="submit" name="cadastrar">Registrar</button>
       
    </form>
</body>
</html>
