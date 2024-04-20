<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Utilizadores';

$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Criar query
$sql ="SELECT * FROM users";
$DEBUG .= "Query SQL: $sql\n";

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
<div class="table-responsive-md">
<table class="table table-striped table-hover table-sm">
    <thead>
        <tr>
            <th class="align-middle">ID</th>
            <th class="align-middle">Username</th>
            <th class="align-middle">Email</th>
            <th class="align-middle">Perfil</th>
            <th class="align-middle">Operações</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($num > 0) {
        foreach ($list as $reg) {
            ?>
            <tr>
                <td class="align-middle"><?= $reg['id'] ?></td>
                <td class="align-middle"><img src="<?= $reg['avatar'] ?>" width="30" alt=""> &nbsp; <?= $reg['username'] ?></td>
                <td class="align-middle"><?= $reg['email'] ?></td>
                <td class="align-middle"><?= $reg['profile'] ?></td>
                <td class="align-middle">
                    <a href="?m=<?= $module ?>&a=update&id=<?= $reg['id'] ?>" title="Editar" class="btn btn-secondary">
                        <i class="fi fi-prescription"></i>  Editar
                    </a>
                    <?php
                    if ($reg['id']!=1){
                    ?>
                    <a href="?m=<?= $module ?>&a=delete&id=<?= $reg['id'] ?>" title="Eliminar" class="btn btn-danger"
                       onclick="return confirm('Pretende eliminar o registo <?= $reg['id'] ?> - <?= $reg['username'] ?>?');">
                        <i class="fi fi-trash"></i>
                    </a>
                    <?php
                    }
                    ?>
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