<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kits - Adicionar';

$pdo = connectDB($db);

// Verificar se foi feito submit ao formulário
$add = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
if ($add) {
    $result = '';
    $DEBUG .= "Ligar à BD\n";
    
    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $espaco = filter_input(INPUT_POST, 'espaco', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO kit(NOME,espaco_ID) VALUES(:NOME,:ESPACO)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);
    $stmt->bindValue(":ESPACO", $espaco, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result .= '<div class="alert-success">Registo adicionado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao adicionar registo.</div>';
    }
    // Obter lista de Equipamentos
}

$sql1 ="SELECT * FROM espaco ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql1\n";
$listEspaco = $pdo->query($sql1)->fetchAll();
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
        <label for="username">Nome</label>
        <input name="nome" id="nome" type="text" required="" class="form-control">
    </div>
    
    <label for="espaco">Espaços</label>
        <select name="espaco" id="espaco" class="form-control">
            <?php
            foreach ($listEspaco as $espaco){ ?>
            <option value="<?= $espaco['ID'] ?>"><?= $espaco['NOME'] ?></option>
                <?php
            }
            ?>
        </select>
        <br>
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>