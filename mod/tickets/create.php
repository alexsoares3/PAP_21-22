<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Criar Ticket';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);


$sql1 ="SELECT * FROM espaco ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql1\n";
$listEspaco = $pdo->query($sql1)->fetchAll();

$espacoSelecionado = filter_input(INPUT_POST, 'espacoSelecionado', FILTER_SANITIZE_STRING);

$sql2="SELECT * FROM equipamento WHERE espaco_ID=1";
$DEBUG .= "Query SQL: $sql2\n";
$listEquip = $pdo->query($sql2)->fetchAll();

// Verificar se foi feito submit ao formulário
$add = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
if ($add) {
    

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO espaco(NOME) VALUES(:NOME)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);
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
        <label for="descricao">Descrição</label>
        <textarea rows="4" cols="50" class="form-control" name="descricao" id="descricao" required=""></textarea>
        <!--<input name="descricao" id="descricao" type="text" required="" class="form-control">-->
    </div>
    
    <label for="espaco">Espaços</label>
    <select name="espacoSelecionado" id="espacoSelecionado" class="form-control">
        <?php
        foreach ($listEspaco as $espaco){ ?>
        <option value="<?= $espaco['ID'] ?>"><?= $espaco['NOME'] ?></option>
        <?php
        }
        ?>
    </select>
    <br>
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar Espaço" ><i class="fi fi-save"></i> Guardar Espaço</button>
    <br>
    <br>

    <label for="equipamento">Equipamentos</label>
    <select name="equipSelecionado" id="equipSelecionado" class="form-control">
        <?php
        foreach ($listEquip as $equip){ ?>
        <option value="<?= $equip['ID'] ?>"><?= $equip['ID'] ?> <> <?= $equip['MARCA'] ?> - <?= $equip['MODELO'] ?></option>
        <?php
        }
        ?>
    </select>
    <br>

    
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>