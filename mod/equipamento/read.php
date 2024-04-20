<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Equipamento';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$order = filter_input(INPUT_POST, 'orderButton', FILTER_SANITIZE_STRING);
$search = filter_input(INPUT_POST, 'searchButton', FILTER_SANITIZE_STRING);

// Criar query
$sql ="SELECT equipamento.ID,equipamento.MARCA,equipamento.MODELO,equipamento.ANO,categorias.NOME AS catNome FROM equipamento,categorias
 WHERE equipamento.categorias_ID=categorias.ID " ; #FILTRAR AND equipamento.espaco_ID=espaco.ID
  if($order) {
        $atributo = filter_input(INPUT_POST,'orderField');
        $sql .= "ORDER BY $atributo $order";
    } else if ($search) {
        $searchQuery = filter_input(INPUT_POST,'searchField');
        $searchType = filter_input(INPUT_POST,'searchTypeField');
        $sql .= "AND $searchType LIKE '%{$searchQuery}%'";
    }
$DEBUG .= "Query SQL: $sql\n";

// Executar query e obter dados da Base de Dados
$list = $pdo->query($sql)->fetchAll();

// Contar número de registos
$num = count($list);
$DEBUG .= "Número de registos: $num\n";


?>
<div class="row">
    <div class="col-sm-auto">
        <h3><?= $TITLE ?>&nbsp</h3>
    </div>
    <div class="ml-sm-auto">
        <a href="?m=<?= $module ?>&a=create" class="btn btn-primary" title="Novo"><i class="fi fi-plus-a"></i> Novo</a>
    </div>
</div>
<div class="row">
    <!--Ordernar Por-->
    <div class="col-sm-auto">
            <form action="?m=<?= $module ?>&a=read" role="form" method="post">
            <label for="orderField">Ordenar Por:</label>
            <select id="orderField" name="orderField">
                <option value="ID">ID</option>
                <option value="marca">Marca</option>
                <option value="modelo">Modelo</option>
                <option value="ano">Ano</option>
                <option value="nome">Categoria</option>
            </select>
            <button type="submit" name="orderButton" value="ASC">&nbsp<i class="fi fi-angle-up" title="Crescente"></i>&nbsp</button>
            <button type="submit" name="orderButton" value="DESC">&nbsp<i class="fi fi-angle-down" title="Descrescente"></i>&nbsp</button>
            </form>
    </div>
    &nbsp
    &nbsp
        <?php
        if ($num > 0) {
            foreach ($list as $reg) {
        ?>
            <option value="<?= $reg['MARCA'] ?>"><?= $reg['MARCA'] ?></option>
        <?php
            } 
        }
        ?>
    &nbsp
    &nbsp
    <!--Search Filter-->
    <div class="col-sm-auto">
            <form action="?m=<?= $module ?>&a=read" role="form" method="post">
                <label for="searchField">Procurar:</label>
                <input type="text" id="searchField" name="searchField">

                <select id="searchTypeField" name="searchTypeField">
                    <option value="equipamento.ID">ID</option>
                    <option value="marca">Marca</option>
                    <option value="modelo">Modelo</option>
                    <option value="ano">Ano</option>
                    <option value="nome">Categoria</option>
                </select>

                <button type="submit" name="searchButton" value="search" title="Procurar">&nbsp<i class="fi fi-search"></i>&nbsp</button>
            </form>
    </div>

    <div class="ml-sm-auto">
    <button type="submit" name="searchButton" value="search" title="Procurar"><a href="?m=<?= $module ?>&a=read" title="Novo" style="text-decoration: none; color: inherit;">&nbsp Repor Filtros &nbsp</a></button>
        
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
            <!--<th class="align-middle">Espaco</th>-->
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
                <td class="align-middle"><?= $reg['MARCA'] ?></td>
                <td class="align-middle"><?= $reg['MODELO'] ?></td>
                <td class="align-middle"><?= $reg['ANO'] ?></td>
                <td class="align-middle"><?= $reg['catNome'] ?></td>
                <!--<td class="align-middle"><?= $reg['espacoNome'] ?></td>-->
                <td class="align-middle">
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