<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kit -';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";



// Criar query
$sql ="SELECT equipamento.ID AS equipID,equipamento.MARCA,equipamento.MODELO,equipamento.ANO,categorias.NOME AS catNome, kit.ID,kit.NOME 
FROM equipamento,categorias,kit WHERE equipamento.kit_ID=$id AND equipamento.categorias_ID=categorias.ID AND equipamento.kit_ID=kit.ID ORDER BY equipamento.ID ASC";
$DEBUG .= "Query SQL: $sql\n";
$list = $pdo->query($sql)->fetchAll();

$sql1 = "SELECT NOME FROM kit WHERE ID=$id";
$NomeKit = $pdo->query($sql1)->fetchAll();

// Executar query e obter dados da Base de Dados


// Contar número de registos
$num = count($list);
$DEBUG .= "Número de registos: $num\n";

?>
<div class="row">
    <div class="col-sm-auto">
        <h3><?= $TITLE ?> <?= $NomeKit[0]['NOME']?></h3>
    </div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=SelectKit&id=<?= $id ?>" class="btn btn-primary" title="Adicionar Equipamento"><i class="fi fi-plus-a"></i> Adicionar<br> Equipamento</a>
        <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Voltar"> Voltar</a>
    </div>
</div>
<div class="table-responsive-md">
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th class="align-middle">ID</th>
            <th class="align-middle">Marca</th>
            <th class="align-middle">Modelo</th>
            <th class="align-middle">Ano</th>
            <th class="align-middle">Categoria</th>
            <th class="align-middle">Operações</th>
        </tr>
    </thead>
    <tbody>
        
    <?php
    if ($num > 0) {
        foreach ($list as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['equipID'] ?></td>
                <td class="align-middle"><?= $reg['MARCA'] ?></td>
                <td class="align-middle"><?= $reg['MODELO'] ?></td>
                <td class="align-middle"><?= $reg['ANO'] ?></td>
                <td class="align-middle"><?= $reg['catNome'] ?></td>
                <td class="align-middle">
                    <a href="?m=<?= $module ?>&a=delEquipKit&equipId=<?= $reg['ID'] ?>&kitId=<?= $id ?>" title="Remover" class="btn btn-danger"
                        onclick="return confirm('Pretende remover o equipamento <?= $reg['ID'] ?> - <?= $reg['NOME'] ?> deste kit?');">
                        <i class="fi fi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
            <tr>
                <td colspan="6">Sem registos</td>
            </tr>
        <?php 
    }
    ?>
    </tbody>
</table>
</div>