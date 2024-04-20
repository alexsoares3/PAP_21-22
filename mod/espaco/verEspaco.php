<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Espaço ';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";



// Criar query
$sql ="SELECT equipamento.ID,equipamento.MARCA,equipamento.espaco_ID,equipamento.MODELO,equipamento.ANO,categorias.NOME AS catNome FROM equipamento,categorias
 WHERE equipamento.categorias_ID=categorias.ID AND equipamento.espaco_ID=$id" ;
$DEBUG .= "Query SQL: $sql\n";
$list = $pdo->query($sql)->fetchAll();

$sql1 = "SELECT NOME FROM espaco WHERE ID=$id";
$NomeEspaco = $pdo->query($sql1)->fetchAll();

// Executar query e obter dados da Base de Dados


// Contar número de registos
$num = count($list);
$DEBUG .= "Número de registos: $num\n";

?>
<div class="row">
    <div class="col-sm-auto">
        <h3><?= $TITLE ?> <?= $NomeEspaco[0]['NOME']?> - Equipamentos</h3>
    </div>
    <div class="ml-sm-auto">
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
        </tr>
    </thead>
    <tbody>
        
    <?php
    if ($num > 0) {
        foreach ($list as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['ID'] ?></td>
                <td class="align-middle"><?= $reg['MARCA'] ?></td>
                <td class="align-middle"><?= $reg['MODELO'] ?></td>
                <td class="align-middle"><?= $reg['ANO'] ?></td>
                <td class="align-middle"><?= $reg['catNome'] ?></td>
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