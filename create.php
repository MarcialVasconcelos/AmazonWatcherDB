<?php
require 'banco.php';
//Acompanha os erros de validação

// Processar so quando tenha uma chamada post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $productIdErro = null;
    $nomeErro = null;
    $primeErro = null;
    $imagemErro = null;
    $estrelasErro = null;
    $avaliacoesErro = null;
	$precoErro = null;
	$dataErro = null;
	$horaErro = null;

    if (!empty($_POST)) {
        $validacao = True;
        $novoUsuario = False;
				
        if (!empty($_POST['Product_ID'])) {
            $Product_ID = $_POST['Product_ID'];
        } else {
            $productIdErro = 'Por favor digite o ID do produto!';
            $validacao = False;
        }
		
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
        } else {
            $nomeErro = 'Por favor digite o nome do produto!';
            $validacao = False;
        }


        if (!empty($_POST['prime'])) {
            $prime = $_POST['prime'];
        } else {
            $primeErro = 'Por favor selecione uma opção';
            $validacao = False;
        }


        if (!empty($_POST['imagem'])) {
            $imagem = $_POST['imagem'];
        } else {
            $imagemErro = 'Por favor digite o link da imagem!';
            $validacao = False;
        }

		if (!empty($_POST['estrelas'])) {
            $estrelas = $_POST['estrelas'];
        } else {
            $estrelasErro = 'Por favor digite a nota do produto!';
            $validacao = False;
        }

        if (!empty($_POST['avaliacoes'])) {
            $avaliacoes = $_POST['avaliacoes'];
        } else {
            $avaliacoesErro = 'Por favor digite o número de avaliações!';
            $validacao = False;
        }
		
		if (!empty($_POST['preco'])) {
            $preco = $_POST['preco'];
        } else {
            $precoErro = 'Por favor digite o preço!';
            $validacao = False;
        }

		if (!empty($_POST['datas'])) {
            $datas = $_POST['datas'];
        } else {
            $dataErro = 'Por favor digite uma data!';
            $validacao = False;
        }
        
		if (!empty($_POST['horas'])) {
            $horas = $_POST['horas'];
        } else {
            $horaErro = 'Por favor digite um horário!';
            $validacao = False;
        }
    }

//Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO produto(Product_ID, nome, prime, id_montadora, estrelas, avaliacoes, preco) VALUES(?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($Product_ID, $nome, $prime, $imagem, $estrelas, $avaliacoes, $preco, $datas, $horas));
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Adicionar Projeto</title>
</head>

<body>
<div class="container">
    <div clas="span10 offset1">
        <div class="card">
            <div class="card-header">
                <h3 class="well"> Adicionar Projeto </h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="create.php" method="post">

                    <div class="control-group  <?php echo !empty($nomeProjetErro) ? 'error ' : ''; ?>">
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

                            <?php
                                echo '<select name="prime" size="1">';
                                echo '<option value="" disabled selected>Escolha uma opção</option>';
                                echo '<option value=0>Falso</option>';
                                echo '<option value=1>Verdadeiro</option>';
                                echo '</select>';
                            
                            if (!empty($primeErro)): ?>
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
                        <button type="submit" class="btn btn-success">Adicionar</button>
                        <a href="index.php" type="btn" class="btn btn-default">Voltar</a>
                    </div>
                </form>
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

