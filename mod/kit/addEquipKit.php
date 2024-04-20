<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kit - Adicionar Equipamento';


$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Obter ID pelo URL de forma segura
$equipId = filter_input(INPUT_GET, 'equipId', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: EquipId=$equipId\n";
$kitId = filter_input(INPUT_GET, 'kitId', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: KitId=$kitId\n";

$sql0 ="SELECT espaco_ID FROM kit WHERE ID=:kit_ID";
$stmt = $pdo->prepare($sql0);
    $stmt->bindValue(":kit_ID", $kitId, PDO::PARAM_STR);
    $stmt->execute();
    $espacoID =$stmt->fetchAll();

    $sql = "UPDATE equipamento SET 
                kit_ID = :kit_ID
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $equipId, PDO::PARAM_INT);
    $stmt->bindValue(":kit_ID", $kitId, PDO::PARAM_STR);
    $stmt->execute();

    $sql1 = "UPDATE equipamento SET 
                espaco_ID = :espaco_ID
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql1);
    $stmt->bindValue(":ID", $equipId, PDO::PARAM_INT);
    $stmt->bindValue(":espaco_ID", $espacoID[0], PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->execute()) {
        $result = '<div class="alert alert-success">Equipamento adicionado com sucesso.</div>';
    }else{
        $result = '<div class="alert alert-danger">Ocorreu um erro ao adicionar o equipamento.</div>';
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
