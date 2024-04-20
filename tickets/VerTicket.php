<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Ver Ticket';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$ticketID = filter_input(INPUT_GET, 'ticketID', FILTER_SANITIZE_NUMBER_INT);

$sql="SELECT * FROM tickets WHERE id=$ticketID";
$ticket = $pdo->query($sql)->fetchAll();



// Verificar se foi feito submit ao formulário
$update = filter_input(INPUT_POST, 'update', FILTER_SANITIZE_STRING);
if ($update) {

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);

    
    $sql1 = "UPDATE tickets SET 
                ESTADO = :ESTADO
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql1);
    $stmt->bindValue(":ID", $ticketID, PDO::PARAM_INT);
    $stmt->bindValue(":ESTADO", $estado, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->execute()) {
        $result .= '<div class="alert-success">Registo atualizado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao atualizar registo.</div>';
    }
}
?>
<div class="row">
    <div class="col-sm-auto"><h3><?= $TITLE ?> - <?= $ticket[0]['TITULO'] ?></h3></div>
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
        <label for="titulo">Título</label>
        <input name="titulo" id="titulo" type="text" required="" class="form-control" readonly placeholder="<?=$ticket[0]['TITULO']?>">
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea rows="4" cols="50" class="form-control" name="descricao" id="descricao" required="" readonly placeholder="<?=$ticket[0]['DESCRICAO']?>"></textarea>
        <!--<input name="descricao" id="descricao" type="text" required="" class="form-control">-->
    </div>

    <div class="form-group">
        <label for="equipamento">Equipamento</label>
        <input name="equipamento" id="equipamento" type="text" required="" class="form-control" readonly placeholder="<?=$ticket[0]['TITULO']?>">
    </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" id="estado" class="form-control">
            <option value="Aberto" >Aberto</option>            
            <option value="Em Processamento" >Em Processamento</option>
            <option value="Fechado" >Fechado</option>
        </select>
    </div>
    <br>

    
    <button type="submit" name="update" class="btn btn-primary" value="update" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?a=read" class="btn btn-secondary" title="Voltar"> Voltar</a>
</form>