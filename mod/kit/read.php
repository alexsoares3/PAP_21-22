<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kits';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);


$search = filter_input(INPUT_POST, 'searchButton', FILTER_SANITIZE_STRING);

// Criar query
$sql ="SELECT kit.ID,kit.NOME,espaco.NOME AS espaco FROM espaco,kit WHERE kit.espaco_ID=espaco.ID " ; #FILTRAR AND equipamento.espaco_ID=espaco.ID
  if ($search) {
        $searchQuery = filter_input(INPUT_POST,'searchField');
        $sql .= "AND kit.NOME LIKE '%{$searchQuery}%'";
    }

// Executar query e obter dados da Base de Dados
$list = $pdo->query($sql)->fetchAll();

// Contar número de registos
$num = count($list);
$DEBUG .= "Número de registos: $num\n";

?>
<div class="row">
    <div class="col-sm-auto">
        <h3><?= $TITLE ?></h3>
    </div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=create" class="btn btn-primary" title="Novo"><i class="fi fi-plus-a"></i> Novo</a>
    </div>
</div>

<div class="col-sm-auto">
    <form action="?m=<?= $module ?>&a=read" role="form" method="post">
        <label for="searchField">Procurar:</label>
        <input type="text" id="searchField" name="searchField">
        <button type="submit" name="searchButton" value="search" title="Procurar">&nbsp<i class="fi fi-search"></i>&nbsp</button>&nbsp
        <button type="submit"><a href="?m=<?= $module ?>&a=read" title="Repor Filtro" style="text-decoration: none; color: inherit;">&nbsp Repor Filtro &nbsp</a></button> 
    </form>
</div>


<div class="table-responsive-md">
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th class="align-middle">ID</th>
            <th class="align-middle">Nome</th>
            <th class="align-middle">Espaço</th>
            <th class="align-middle">Operações</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($num > 0) {
        foreach ($list as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['ID'] ?></td>
                <td class="align-middle"><?= $reg['NOME'] ?></td>
                <td class="align-middle"><?= $reg['espaco'] ?></td>
                <td class="align-middle">
                    <a href="?m=<?= $module ?>&a=VerKit&id=<?= $reg['ID'] ?>" title="Ver Kit" class="btn btn-secondary">
                        <i class="fi fi-eye"></i></i>  Ver Kit
                    </a>

                    <a href="?m=<?= $module ?>&a=update&id=<?= $reg['ID'] ?>" title="Editar" class="btn btn-secondary">
                        <i class="fi fi-prescription"></i>  Editar
                    </a>
                    
                    <a href="?m=<?= $module ?>&a=delete&id=<?= $reg['ID'] ?>" title="Eliminar" class="btn btn-danger"
                       onclick="return confirm('Pretende eliminar o registo <?= $reg['ID'] ?> - <?= $reg['NOME'] ?>?');">
                        <i class="fi fi-trash"></i>
                    </a>
                </td>
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
</div>