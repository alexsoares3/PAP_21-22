<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Editar Ticket';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);
$ticketID = filter_input(INPUT_GET, 'ticketID', FILTER_SANITIZE_NUMBER_INT);

$sql="SELECT * FROM tickets WHERE ID=$ticketID"; 
$DEBUG .= "Query SQL: $sql\n";
$tickets = $pdo->query($sql)->fetchAll();

// Verificar se foi feito submit ao formulário
$update = filter_input(INPUT_POST, 'update', FILTER_SANITIZE_STRING);
if ($update) {

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

    $sql = "UPDATE tickets SET 
                TITULO = :TITULO,
                DESCRICAO = :DESCRICAO
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
    $stmt->bindValue(":TITULO", $titulo, PDO::PARAM_STR);
    $stmt->bindValue(":DESCRICAO", $descricao, PDO::PARAM_STR);

    $stmt->execute();
    if ($stmt->execute()) {
        $result .= '<div class="alert-success">Registo atualizado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao atualizar registo.</div>';
    }
}
?>
<div class="row">
    <div class="col-sm-auto"><h3><?= $TITLE ?> - <?= $tickets[0]['TITULO'] ?></h3></div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=read" class="btn" title="Fechar"><i class="fi fi-close"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <?= isset($result) ? $result : '' ?>
    </div>
</div>

<form role="form" method="post">


    <div class="form-group">
        <label for="id">ID</label>
        <input name="id" id="id" type="text" required="" class="form-control" readonly value="<?= $tickets[0]['ID'] ?>">
    </div>
    <div class="form-group">
        <label for="titulo">Título</label>
        <input name="titulo" id="titulo" type="text" required="" class="form-control" maxlength="15" value="<?= $tickets[0]['TITULO'] ?>">
    </div>
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <input name="descricao" id="descricao" type="text" required="" class="form-control" maxlength="200" value="<?= $tickets[0]['DESCRICAO']?>">
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

    
    <button type="submit" name="update" class="btn btn-primary" value="update" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?a=read" class="btn btn-secondary" title="Voltar"> Voltar</a>
</form>