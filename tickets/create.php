<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Criar Ticket';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);
$espaco_ID = filter_input(INPUT_GET, 'espacoID', FILTER_SANITIZE_NUMBER_INT);

$sql2="SELECT * FROM equipamento WHERE espaco_ID=$espaco_ID";
$DEBUG .= "Query SQL: $sql2\n";
$listEquip = $pdo->query($sql2)->fetchAll();

$sql3="SELECT * FROM espaco WHERE ID=$espaco_ID"; 
$DEBUG .= "Query SQL: $sql3\n";
$espacoNome = $pdo->query($sql3)->fetchAll();

// Verificar se foi feito submit ao formulário
$add = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
if ($add) {
    

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $estado = "Aberto";
    $users_id = $_SESSION['uid'];
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    


    $sql = "INSERT INTO tickets(DESCRICAO,espaco_ID,DATAHORA,ESTADO,users_id,TITULO) VALUES(:DESCRICAO,:espaco_ID,NOW(),:ESTADO,:users_id,:TITULO)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":DESCRICAO", $descricao, PDO::PARAM_STR);
    $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);
    $stmt->bindValue(":ESTADO", $estado, PDO::PARAM_STR);
    $stmt->bindValue(":users_id", $users_id, PDO::PARAM_STR);
    $stmt->bindValue(":TITULO", $titulo, PDO::PARAM_STR);
    
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result .= '<div class="alert-success">Registo adicionado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao adicionar registo.</div>';
    }   
}
?>
<div class="row">
    <div class="col-sm-auto"><h3><?= $TITLE ?> - <?= $espacoNome[0]['NOME'] ?></h3></div>
    <div class="ml-sm-auto">
        <a href="./index.php" class="btn" title="Fechar"><i class="fi fi-close"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <?= isset($result) ? $result : '' ?>
    </div>
</div>

<form action="?m=<?= $module ?>&a=create&espacoID=<?=$espaco_ID?>" role="form" method="post">

    <div class="form-group">
        <label for="titulo">Título</label>
        <input name="titulo" id="titulo" type="text" required="" class="form-control" placeholder="Insira um título breve com a descrição do problema">
    </div>
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea rows="4" cols="50" class="form-control" name="descricao" id="descricao" required="" placeholder="Descrição do problema, indique também o equipamento em causa"></textarea>
        <!--<input name="descricao" id="descricao" type="text" required="" class="form-control">-->
    </div>

    <!--<label for="equipamento">Equipamentos</label>
    <select name="equipSelecionado" id="equipSelecionado" class="form-control">
        <?php
        foreach ($listEquip as $equip){ ?>
        <option value="<?= $equip['ID'] ?>"><?= $equip['ID'] ?> <> <?= $equip['MARCA'] ?> - <?= $equip['MODELO'] ?></option>
        <?php
        }
        ?>
    </select>
    <br>-->

    
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="./index.php" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>