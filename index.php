<?php

    require 'db/conexao.php';
    
    $pdo = new PDO('mysql:host='.$DBHOST.';dbname='.$DBNAME.'', $DBUSER, $DBPASS);

    // Inserindo Informações
    if (isset($_POST['nome'])) {
        $sqlInsert = $pdo->prepare("INSERT INTO tb_pessoa (nomePessoa, sobrenomePessoa, dtanascimentoPessoa, cpfPessoa) VALUES ('".$_POST['nome']."', '".$_POST['sobrenome']."', '".$_POST['dtanascimento']."', '".$_POST['cpfPessoa']."');");
        $sqlInsert->execute();

        if ($sqlInsert->rowCount() > 0) {
            $retornoInsert = '<h6><br>Pessoa cadastrada com sucesso!<br></h6>';
        } else {
            $retornoInsert = '<h6><br>Erro ao inserir pessoa!<br></h6>';
        }
    }

    //Deletando Informações
    if (isset($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $sqlDelete = $pdo->prepare("DELETE FROM tb_pessoa WHERE idPessoa=$id;");
        $sqlDelete->execute();

        if ($sqlDelete->rowCount() > 0) {
            $retornoDelete = '<h6><br>Pessoa deletada com sucesso!<br></h6>';
        } else {
            $retornoDelete = '<h6><br>Erro ao deletar pessoa!<br></h6>';
        }
    }

    // Atualizando Informações
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <title>CRUD - PHP</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main>
        <form method="POST">
            <div class="form-group">
                <label for="nome" style="color: white;">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nome" placeholder="Nome">
            </div>
            <div class="form-group">
                <label for="sobrenome"  style="color: white;">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome">
            </div>
            <div class="form-group">
                <label for="dtanascimento"  style="color: white;">Data de Nascimento</label>
                <input type="text" class="form-control" id="dtanascimento" name="dtanascimento" placeholder="00/00/0000" maxlength="10">
            </div>
            <div class="form-group">
                <label for="cpfPessoa"  style="color: white;">CPF</label>
                <input type="text" class="form-control" id="cpfPessoa" name="cpfPessoa" placeholder="000.000.000-00">
            </div>
            <button type="submit" class="btn btn-primary" style="display: block; margin: 0 auto;">Cadastre-se</button>
        </form>

        <div class="pessoasCadastradas">
            <hr>
            <h5>Lista de Pessoas:</h5>
            <?php 
            
                $sql = $pdo->prepare("SELECT * FROM tb_pessoa;");
                $sql->execute();

                $fetchPessoas = $sql->fetchAll();

                foreach ($fetchPessoas as $key => $value) {
                    echo '<a href="?delete='.$value['idPessoa'].'"> (X) <a/> - '.$value['nomePessoa'].' '.$value['sobrenomePessoa'] .' (CPF: '.$value['cpfPessoa'].')';
                    echo '<br>';
                }

            ?>
        </div>

        <div class="retorno">
            <?php if (isset($_POST['nome'])) { echo $retornoInsert; header ("refresh:2;url=index.php"); }?>
            <?php if (isset($_GET['delete'])) { echo $retornoDelete; header ("refresh:2;url=index.php"); }?>
        </div>
    </main>
</body>
</html>