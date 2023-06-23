<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/customStyle.css">
    <title>Página Inicial</title>
</head>

<body>
        <div class="container">
          <div class="jumbotron">
            <div class="row">
                <h2>Cadastro de Produtos</h2>
            </div>
          </div>
            </br>
            <div class="row">
                <p>
                    <a href="create.php" class="btn btn-success">Novo produto</a>
                </p>
                <table class="table table-striped">
                    <thead>                        
                        <tr>
                            <!--<th scope="col">Id</th>-->
                            <th scope="col">Imagem</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Prime</th>
                            <th scope="col">Última Data</th>
                            <th scope="col">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'banco.php';
                        $pdo = Banco::conectar();
                        // $sql = 'SELECT product_ID, nome, imagem, preco, prime, data, hora (SELECT * , ROW_NUMBER() OVER (PARTITION BY product_ID ORDER BY data DESC)FROM produto ORDER BY nome DESC, hora DESC LIMIT 100) AS a';
                        $sql = 'SELECT DISTINCT product_ID, nome, imagem, preco, prime, estrelas, datas AS datas FROM (SELECT id, product_ID, nome, imagem, preco, prime, estrelas, avaliacoes , STR_TO_DATE(datas, "%d/%m/%Y") AS datas, horas FROM produto ORDER BY datas DESC, horas DESC) prod ORDER BY estrelas DESC';

                        foreach($pdo->query($sql)as $row) {
                            echo '<tr>';
			                //echo '<th scope="row">'. $row['id'] . '</th>';
                            echo '<td> <a class="imgHolder" href="https://www.amazon.com.br/dp/'.$row['product_ID'].'/"> <img class="img" src="'. $row['imagem'] . '">  </img></a> </td>';
                            echo '<td>'. $row['nome'] . '</td>';
                            echo '<td>'. $row['preco'] . '</td>';
                            echo '<td>'. $row['prime'] . '</td>';
                            echo '<td width=120>'. $row['datas'] . '</td>';
                            echo '<td >';
                            echo '<a class="btn btn-primary" href="read.php?id='.$row['product_ID'].'">Info</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Banco::desconectar();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
