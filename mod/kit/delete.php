<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kits - Eliminar';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Obter ID pelo URL de forma segura
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";

$sql1 = "UPDATE equipamento SET 
                kit_ID = NULL
            WHERE kit_ID = :ID";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(":ID", $id, PDO::PARAM_INT);
    $stmt1->execute();

// Criar query
$sql ="DELETE FROM kit WHERE id = :ID";

// Preparar Query
$stmt = $pdo->prepare($sql);

// Associar valor do ID
$stmt->bindValue(':ID', $id,PDO::PARAM_INT);
$DEBUG .= "Executar query: ". print_r($stmt, true)."\n";

// Executar query
if ($stmt->execute()) {
    $result = '<div class="alert alert-success">Registo eliminado com sucesso.</div>';
}else{
    $result = '<div class="alert alert-danger">Ocorreu um erro ao eliminar o registo.</div>';
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

<a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Voltar"> Voltar</a>