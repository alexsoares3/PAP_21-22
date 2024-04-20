<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Equipamento - Editar';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Obter ID pelo URL de forma segura
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";

$sql1 ="SELECT * FROM categorias ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql1\n";
$listCat = $pdo->query($sql1)->fetchAll();

$sql2 ="SELECT * FROM espaco ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql2\n";
$listEspaco = $pdo->query($sql2)->fetchAll();


// Verificar se foi feito submit ao formulário
$update = filter_input(INPUT_POST, 'update', FILTER_SANITIZE_STRING);
if ($update) {

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);
    $modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING);
    $categorias_ID = filter_input(INPUT_POST, 'categorias_ID', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING);

    
    $sql = "UPDATE equipamento SET 
                MARCA = :MARCA,
                MODELO = :MODELO,
                categorias_ID = :categorias_ID,
                ANO = :ANO
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
    $stmt->bindValue(":MARCA", $marca, PDO::PARAM_STR);
    $stmt->bindValue(":MODELO", $modelo, PDO::PARAM_STR);
    $stmt->bindValue(":categorias_ID", $categorias_ID, PDO::PARAM_STR);
    $stmt->bindValue(":ANO", $ano, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->execute()) {
        $result .= '<div class="alert-success">Registo atualizado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao atualizar registo.</div>';
    }
}

// Criar query para apresentação de dados para edição no Formulário
$sql = "SELECT * FROM equipamento WHERE id = :ID LIMIT 1";

// Preparar Query
$stmt = $pdo->prepare($sql);

// Associar valor do ID
$stmt->bindValue(':ID', $id, PDO::PARAM_INT);

// Executar query
if ($stmt->execute()) {
    $reg = $stmt->fetch();
    $DEBUG .= "Obter dados da BD: " . print_r($reg, true) . "\n";
} else {
    $result .= '<div class="alert alert-danger">Ocorreu um erro ao ler registo da Base de Dados.</div>';
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

<form action="?m=<?= $module ?>&a=update&id=<?= $id ?>" role="form" method="post">
    <div class="form-group">
        <label for="id">ID</label>
        <input name="id" id="id" value="<?= $reg['ID'] ?>" type="text" readonly class="form-control">
    </div>
    <div class="form-group">
        <label for="marca">Marca</label>
        <input name="marca" id="marca" value="<?= $reg['MARCA'] ?>" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="categorias_ID">Categorias</label>
        <select name="categorias_ID" id="categorias_ID" class="form-control">
            <?php
            foreach ($listCat as $categorias){
                if ($categorias['ID'] == $reg['categorias_ID']){
                    // Selected
                    ?>
                    <option value="<?= $categorias['ID'] ?>" selected><?= $categorias['NOME'] ?></option>            
                <?php
                }else{
                    // normal
                    ?>
                    <option value="<?= $categorias['ID'] ?>" ><?= $categorias['NOME'] ?></option>
                <?php
                }
                ?>  
                <?php
            }   
                ?>
        </select>
    </div>
    <div class="form-group">
        <label for="modelo">Modelo</label>
        <input name="modelo" id="modelo" value="<?= $reg['MODELO'] ?>" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="ano">Ano</label>
        <input name="ano" id="ano" value="<?= $reg['ANO'] ?>" type="text" required="" class="form-control">
    </div>
    
    <button type="submit" name="update" class="btn btn-primary" value="update" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>
