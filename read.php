<?php
require 'banco.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
} else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = 'SELECT p.id, p.nome_projeto, p.gerente_projeto, p.id_montadora, p.responsavel_montadora, p.email_montadora, p.telefone_montadora, p.part_number_oem, p.part_number_usinado, p.part_number_fundido, m.nome AS nome_montadora FROM projeto p LEFT JOIN montadora m ON(p.id_montadora = m.id) WHERE  p.id = ? ORDER BY p.id ASC';
    $sql = 'SELECT id, product_ID, nome, imagem, preco, prime, estrelas, avaliacoes , STR_TO_DATE(datas, "%d/%m/%Y") AS datas, horas FROM produto WHERE  Product_id = ? AND preco != 0 ORDER BY datas DESC, horas DESC';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Banco::desconectar();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/customStyle.css">
    <title>Informações do Projeto</title>
</head>

<body>
<div class="container">
    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well">Histórico de preço do Produto</h3>
            </div>
            <div class="container">
                <aside>
                <?php  echo '<a class="imgHolder" href="https://www.amazon.com.br/dp/'.$data['product_ID'].'/"> <img class="img" src="'. $data['imagem'] . '">  </img></a>'; ?>
                            
                </aside>
                
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nome</label>
                        <div class="controls form-control">
                            <label class="carousel-inner">
                                <?php echo $data['nome']; ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Estrelas</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['estrelas']; ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">N° de Avaliações</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['avaliacoes']; ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>  

                    <table class="table table-striped">
                        <thead>                        
                            <tr>
                                <!--<th scope="col">Id</th>-->
                                <th scope="col">Data</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Prime</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            
                            foreach($q as $row) {
                                echo '<tr>';
                                //echo '<th scope="row">'. $row['id'] . '</th>';
                                echo '<td >'. $row['datas'] . '</td>';
                                echo '<td >'. $row['horas'] . '</td>';
                                echo '<td>'. $row['preco'] . '</td>';
                                echo '<td>'. $row['prime'] . '</td>';
                                echo '<td width=200>';
                                echo '<a class="btn btn-warning" href="update.php?id='.$row['id'].'">Editar</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Excluir</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            
                            ?>
                        </tbody>
                    </table>

                    <!-- <div class="control-group">
                        <label class="control-label">Resp. montadora</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['responsavel_montadora']; ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">E-mail montadora</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['email_montadora']; ?>
                            </label>
                        </div>
                    </div>
					
					<div class="control-group">
                        <label class="control-label">Tel. montadora</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['telefone_montadora']; ?>
                            </label>
                        </div>
                    </div>
					
					
					
					<div class="control-group">
                        <label class="control-label">Part Number OEM</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['part_number_oem']; ?>
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Part Number fundido</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['part_number_fundido']; ?>
                            </label>
                        </div>
                    </div>

					<div class="control-group">
                        <label class="control-label">Part Number usinado</label>
                        <div class="controls form-control disabled">
                            <label class="carousel-inner">
                                <?php echo $data['part_number_usinado']; ?>
                            </label>
                        </div>
                    </div> -->

                    <!-- Tabela de preços -->
		 
                    <br/>
                    <div class="form-actions">
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
