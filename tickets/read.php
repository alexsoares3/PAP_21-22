<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Tickets';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

$search = filter_input(INPUT_POST, 'searchButton', FILTER_SANITIZE_STRING);

$users_id = $_SESSION['uid'];
$admin = $_SESSION['profile'];

// Criar query

if ($_SESSION['profile'] == 'Admin') {
    $sql ="SELECT tickets.ID AS ticketID,tickets.DESCRICAO,tickets.DATAHORA,tickets.ESTADO,tickets.TITULO,tickets.espaco_ID,tickets.users_ID,
    tickets.TITULO,users.ID,users.username AS userNome,espaco.ID,espaco.NOME AS espacoNome FROM tickets,users,espaco WHERE tickets.espaco_ID=espaco.ID 
    AND tickets.users_ID=users.id ORDER BY tickets.ESTADO"; 
    } else {
    $sql ="SELECT tickets.ID AS ticketID,tickets.DESCRICAO,tickets.DATAHORA,tickets.ESTADO,tickets.TITULO,tickets.espaco_ID,tickets.users_ID,
    tickets.TITULO,users.ID,users.username AS userNome,espaco.ID,espaco.NOME AS espacoNome FROM tickets,users,espaco WHERE tickets.espaco_ID=espaco.ID 
    AND tickets.users_ID=users.id AND tickets.users_ID=$users_id ORDER BY tickets.ESTADO"; 
$DEBUG .= "Query SQL: $sql\n";
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
        <a href="./index.php" class="btn btn-primary" title="Novo"><i class="fi fi-plus-a"></i> Novo</a>
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
            <th class="align-middle">Título</th>
            <th class="align-middle">Espaço</th>
            <th class="align-middle">Data/Hora</th>
            <th class="align-middle">Estado</th>
            <th class="align-middle">Utilizador</th>
            <th class="align-middle">Operações</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($num > 0) {
        foreach ($list as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['ticketID'] ?></td>
                <td class="align-middle"><?= $reg['TITULO'] ?></td>
                <td class="align-middle"><?= $reg['espacoNome'] ?></td>
                <td class="align-middle"><?= $reg['DATAHORA'] ?></td>
                <td class="align-middle"><?= $reg['ESTADO'] ?></td>
                <td class="align-middle"><?= $reg['userNome'] ?></td>
                <td class="align-middle">
                    <a href="?a=VerTicket&ticketID=<?= $reg['ticketID'] ?>" title="Ver Ticket" class="btn btn-secondary">
                        <i class="fi fi-eye"></i> Ver Ticket
                    </a>
                    <?php if($reg['ESTADO'] != "Fechado") {
                        ?>
                        <a href="?a=update&ticketID=<?= $reg['ticketID'] ?>" title="Editar" class="btn btn-secondary">
                        <i class="fi fi-prescription"></i>  Editar
                    </a>
                    <?php
                    } ?>
                        
                    <a href="?a=delete&ticketID=<?= $reg['ticketID'] ?>" title="Eliminar" class="btn btn-danger" onclick="return confirm('Pretende eliminar o registo <?= $reg['ID'] ?> - <?= $reg['NOME'] ?>?');">
                        <i class="fi fi-trash"></i>
                    </a>                   
                </td>
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