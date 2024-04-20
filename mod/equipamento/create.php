<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Equipamento - Adicionar';
$pdo = connectDB($db);


$sql1 ="SELECT * FROM categorias ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql1\n";
$listCat = $pdo->query($sql1)->fetchAll();

// Verificar se foi feito submit ao formulário
$add = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
if ($add) {
    $result = '';
    $DEBUG .= "Ligar à BD\n";
    

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);
    $modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING);
    $categorias_ID = filter_input(INPUT_POST, 'categorias_ID', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO equipamento(MARCA, MODELO, categorias_ID, ANO) VALUES(:MARCA, :MODELO, :categorias_ID, :ANO)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":MARCA", $marca, PDO::PARAM_STR);
    $stmt->bindValue(":MODELO", $modelo, PDO::PARAM_STR);
    $stmt->bindValue(":categorias_ID", $categorias_ID, PDO::PARAM_STR);
    $stmt->bindValue(":ANO", $ano, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result .= '<div class="alert-success">Registo adicionado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao adicionar registo.</div>';
    }   
}
?>
<div class="row">
    <div class="col-sm-auto"><h3><?= $TITLE ?></h3></div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=read" class="btn" title="Fechar"><i class="fi fi-close"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <?= isset($result) ? $result : '' ?>
    </div>
</div>

<form action="?m=<?= $module ?>&a=create" role="form" method="post">
    <div class="form-group">
        <label for="username">Marca</label>
        <input name="marca" id="marca" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="username">Modelo</label>
        <input name="modelo" id="modelo" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="categorias_ID">Categorias</label>
        <select name="categorias_ID" id="categorias_ID" class="form-control">
            <?php
            foreach ($listCat as $categorias){ ?>
            <option value="<?= $categorias['ID'] ?>"><?= $categorias['ID'] ?> &lt;<?= $categorias['NOME'] ?>&gt;</option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Ano</label>
        <input name="ano" id="ano" type="number" required="" class="form-control">
    </div>
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>