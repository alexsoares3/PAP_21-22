<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kit - Remover Equipamento';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Obter ID pelo URL de forma segura
$equipId = filter_input(INPUT_GET, 'equipId', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: EquipId=$equipId\n";
$kitId = filter_input(INPUT_GET, 'kitId', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: KitId=$kitId\n";

    $sql = "UPDATE equipamento SET 
                kit_ID = NULL
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $equipId, PDO::PARAM_INT);
    $stmt->execute();
    $sql = "UPDATE equipamento SET 
                espaco_ID = 1
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $equipId, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->execute()) {
        $result = '<div class="alert alert-success">Equipamento removido com sucesso.</div>';
    }else{
        $result = '<div class="alert alert-danger">Ocorreu um erro ao remover o equipamento.</div>';
    }
?>

<div class="row">
    <div class="col-sm-auto"><h3><?= $TITLE ?></h3></div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=VerKit&id=<?= $kitId ?>" class="btn" title="Fechar"><i class="fi fi-close"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?= isset($result) ? $result : '' ?>
    </div>
</div>
