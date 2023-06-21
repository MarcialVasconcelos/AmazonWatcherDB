<?php
require 'banco.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    $productIdErro = null;
    $nomeErro = null;
    $primeErro = null;
    $imagemErro = null;
    $estrelasErro = null;
    $avaliacoesErro = null;
	$precoErro = null;
	$dataErro = null;
	$horaErro = null;

    // $id = $_POST['id'];
    $Product_ID = $_POST['product_ID'];
    $nome = $_POST['nome'];
    $prime = $_POST['prime'];
    $imagem = $_POST['imagem'];
    $estrelas = $_POST['estrelas'];
	$avaliacoes = $_POST['avaliacoes'];
	$preco = $_POST['preco'];
    $datas = $_POST['datas'];
	$horas = $_POST['horas'];

    //Validação
    $validacao = true;
	
    if (empty($Product_ID)) {
        $productIdErro = 'Por favor digite o ID do produto!';
        $validacao = False;
    }
    
    if (empty($nome)) {
        $nomeErro = 'Por favor digite o nome do produto!';
        $validacao = False;
    }

    if (empty($prime) && $prime!=0 ) {
        $primeErro = 'Por favor selecione uma opção';
        $validacao = False;
    }

    if (empty($imagem)) {
        $imagemErro = 'Por favor digite o link da imagem!';
        $validacao = False;
    }

    if (empty($estrelas)) {
        $estrelasErro = 'Por favor digite a nota do produto!';
        $validacao = False;
    }

    if (empty($avaliacoes)) {
        $avaliacoesErro = 'Por favor digite o número de avaliações!';
        $validacao = False;
    }
    
    if (empty($preco)) {
        $precoErro = 'Por favor digite o preço!';
        $validacao = False;
    }

    if (empty($datas)) {
        $dataErro = 'Por favor digite uma data!';
        $validacao = False;
    }
    
    if (empty($horas)) {
        $horaErro = 'Por favor digite um horário!';
        $validacao = False;
    }

    // update data
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE produto set product_ID = ?, nome = ?, prime = ?, imagem = ?, estrelas = ?, avaliacoes = ?, preco = ?, datas = ?, horas = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($Product_ID, $nome, $prime, $imagem, $estrelas, $avaliacoes, $preco, $datas, $horas,$id));
        Banco::desconectar();
        // header("Location: index.php");
        header('Location: read.php?id='.$Product_ID.'');
    }
}
else {
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM produto WHERE  id = ? AND preco != 0 ORDER BY datas DESC, horas DESC';
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    
    $Product_ID = $data['product_ID'];
    $nome = $data['nome'];
    $prime = $data['prime'];
    $imagem = $data['imagem'];
    $estrelas = $data['estrelas'];
    $avaliacoes = $data['avaliacoes'];
    $preco = $data['preco'];
    $datas = $data['datas'];
    $horas = $data['horas'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- using new bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Atualizar produto</title>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Atualizar produto </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

                    <div class="control-group  <?php echo !empty($productIdErro) ? 'error ' : ''; ?>">
                        <label class="control-label">ID do produto*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="product_ID" type="text" placeholder="ID"
                                   value="<?php echo !empty($Product_ID) ? $Product_ID : ''; ?>">
                            <?php if (!empty($productIdErro)): ?>
                                <span class="text-danger"><?php echo $productIdErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                
                    <div class="control-group  <?php echo !empty($nomeErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nome produto*</label>
                        <div class="controls">
                            <input size="50" class="form-control" name="nome" type="text" placeholder="Nome do produto"
                                   value="<?php echo !empty($nome) ? $nome : ''; ?>">
                            <?php if (!empty($nomeErro)): ?>
                                <span class="text-danger"><?php echo $nomeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($primeErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Prime*</label>
                        <div class="controls">
                                <input size="50" class="form-control" name="prime" type="text" placeholder="Prime? (Digite 1 ou 0)"
                                    value="<?php echo !empty($prime)||$prime==0 ? $prime : ''; ?>">
                                <?php if (!empty($primeErro)): ?>
                                    <span class="text-danger"><?php echo $primeErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($imagemErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Link da Imagem*</label>
                        <div class="controls">
                            <input size="80" class="form-control" name="imagem" type="text" placeholder="Link da imagem"
                                   value="<?php echo !empty($imagem) ? $imagem : ''; ?>">
                            <?php if (!empty($imagemErro)): ?>
                                <span class="text-danger"><?php echo $imagemErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
					
					<div class="control-group <?php echo !empty($estrelasErro) ? 'error ' : ''; ?>">
                        <label class="control-label">Nº de Estrelas*</label>
                        <div class="controls">
                            <input size="35" class="form-control" name="estrelas" type="text" placeholder="Estrelas"
                                   value="<?php echo !empty($estrelas) ? $estrelas : ''; ?>">
                            <?php if (!empty($estrelasErro)): ?>
                                <span class="text-danger"><?php echo $estrelasErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php !empty($avaliacoesErro) ? '$avaliacoesErro ' : ''; ?>">
                        <label class="control-label">N° de avaliações*</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="avaliacoes" type="text" placeholder="Avaliações"
                                   value="<?php echo !empty($avaliacoes) ? $avaliacoes : ''; ?>">
                            <?php if (!empty($avaliacoesErro)): ?>
                                <span class="text-danger"><?php echo $avaliacoesErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

					<div class="control-group <?php !empty($precoErro) ? '$precoErro ' : ''; ?>">
                        <label class="control-label">Preço*</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="preco" type="text" placeholder="R$ 00,00"
                                   value="<?php echo !empty($preco) ? $preco : ''; ?>">
                            <?php if (!empty($precoErro)): ?>
                                <span class="text-danger"><?php echo $precoErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

					<div class="control-group <?php !empty($dataErro) ? '$dataErro ' : ''; ?>">
                        <label class="control-label">Data*</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="datas" type="text" placeholder="DD/MM/AAAA"
                                   value="<?php echo !empty($datas) ? $datas : ''; ?>">
                            <?php if (!empty($dataErro)): ?>
                                <span class="text-danger"><?php echo $dataErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

					<div class="control-group <?php !empty($horaErro) ? '$horaErro ' : ''; ?>">
                        <label class="control-label">Horário*</label>
                        <div class="controls">
                            <input size="40" class="form-control" name="horas" type="text" placeholder="HH:MM:SS"
                                   value="<?php echo !empty($horas) ? $horas : ''; ?>">
                            <?php if (!empty($horaErro)): ?>
                                <span class="text-danger"><?php echo $horaErro; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <br/>
                        <button type="submit" class="btn btn-success">Atualizar</button>                        
                        <?php echo '<a href="read.php?id=' .$Product_ID. '" type="btn" class="btn btn-default">Voltar</a>' ?>
                        <!-- <a href="index.php" type="btn" class="btn btn-default">Voltar</a> -->
                    </div>
                </form>
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
