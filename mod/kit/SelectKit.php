<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Adicionar Equipamento - Kit ';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";

// Criar query 
$sql ="SELECT equipamento.ID AS equipID,equipamento.MARCA,equipamento.MODELO,equipamento.ANO,equipamento.kit_ID,equipamento.categorias_ID,categorias.ID AS catID, categorias.NOME AS catNome 
FROM equipamento,categorias 
WHERE equipamento.kit_ID IS NULL 
AND equipamento.categorias_ID=categorias.ID 
ORDER BY equipamento.ID ASC";

$DEBUG .= "Query SQL: $sql\n";
// Executar query e obter dados da Base de Dados
$listNoKit = $pdo->query($sql)->fetchAll();

$sql1 ="SELECT equipamento.ID AS equipID,equipamento.MARCA,equipamento.MODELO,equipamento.ANO,equipamento.kit_ID,equipamento.categorias_ID,categorias.ID AS catID, categorias.NOME AS catNome, kit.ID, kit.NOME AS kitNome
FROM equipamento,categorias,kit 
WHERE (equipamento.kit_ID IS NOT NULL 
AND equipamento.kit_ID!=$id) 
AND equipamento.categorias_ID=categorias.ID 
AND equipamento.kit_ID=kit.ID 
ORDER BY equipamento.ID ASC";

$DEBUG .= "Query SQL: $sql1\n";
// Executar query e obter dados da Base de Dados
$listComKit = $pdo->query($sql1)->fetchAll();

// Contar número de registos
$num = count($listNoKit);
$DEBUG .= "Número de registos sem Kit: $num\n";
$num1 = count($listComKit);
$DEBUG .= "Número de registos com Kit: $num1\n";


?>
<div class="row">
    <div class="col-sm-auto">
        <h3><?= $TITLE ?></h3>
    </div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=VerKit&id=<?= $id ?>" class="btn" title="Fechar"><i class="fi fi-close"></i></a>
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
        foreach ($listNoKit as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['equipID'] ?></td>
                <td class="align-middle"><?= $reg['MARCA'] ?></td>
                <td class="align-middle"><?= $reg['MODELO'] ?></td>
                <td class="align-middle"><?= $reg['ANO'] ?></td>
                <td class="align-middle"><?= $reg['catNome'] ?></td>
                <td class="align-middle">
                    
                <a href="?m=<?= $module ?>&a=addEquipKit&equipId=<?= $reg['equipID'] ?>&kitId=<?= $id ?>" class="btn btn-secondary" title="Adicionar Equipamento"><i class="fi fi-plus-a"></i> Adicionar<br> Equipamento</a>
                
            </tr>
            <?php
        }
    }else {
        ?>
            <tr>
                <td colspan="6">Sem registos</td>
            </tr>
        <?php 
    }
    ?>
    </tbody>
</table>

<h3>Equipamentos noutros Kits</h3>
<div class="table-responsive-md">
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th class="align-middle">ID</th>
            <th class="align-middle">Marca</th>
            <th class="align-middle">Modelo</th>
            <th class="align-middle">Ano</th>
            <th class="align-middle">Categoria</th>
            <th class="align-middle">Kit Atual</th>
            <th class="align-middle">Operações</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($num > 0) {
        foreach ($listComKit as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['equipID'] ?></td>
                <td class="align-middle"><?= $reg['MARCA'] ?></td>
                <td class="align-middle"><?= $reg['MODELO'] ?></td>
                <td class="align-middle"><?= $reg['ANO'] ?></td>
                <td class="align-middle"><?= $reg['catNome'] ?></td>
                <td class="align-middle"><?= $reg['kitNome'] ?></td>
                <td class="align-middle">
                    
                <a href="?m=<?= $module ?>&a=addEquipKit&equipId=<?= $reg['equipID'] ?>&kitId=<?= $id ?>" class="btn btn-secondary" title="Adicionar Equipamento"><i class="fi fi-plus-a"></i> Adicionar<br> Equipamento</a>
                
            </tr>
            <?php
        }
    }else {
        ?>
            <tr>
                <td colspan="7">Sem registos</td>
            </tr>
        <?php 
    }
    ?>
    </tbody>
</table>
</div>