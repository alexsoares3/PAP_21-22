<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Kits - Editar';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);


// Obter ID pelo URL de forma segura
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";

$sql1 ="SELECT * FROM espaco ORDER BY ID ASC";
$DEBUG .= "Query SQL: $sql1\n";
$listEspaco = $pdo->query($sql1)->fetchAll();
/*print_r($listEspaco);*/

// Verificar se foi feito submit ao formulário
$update = filter_input(INPUT_POST, 'update', FILTER_SANITIZE_STRING);
if ($update) {

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $espaco_ID = filter_input(INPUT_POST, 'espaco_ID', FILTER_SANITIZE_STRING);
    /*$espaco_ID = 1;*/

    $sql = "UPDATE kit SET 
                NOME = :NOME,
                espaco_ID = :espaco_ID
            WHERE ID = :ID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);
    $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);
    $stmt->execute();

    $sql2 = "UPDATE equipamento SET 
        espaco_ID = :espaco_ID
        WHERE kit_ID = :ID";
        $stmt = $pdo->prepare($sql2);
        $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
        $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_INT);
        $stmt->execute();
    if ($stmt->execute()) {
        $result .= '<div class="alert-success">Registo atualizado com sucesso!</div>';
    } else {
        $result .= '<div class="alert-danger">Erro ao atualizar registo.</div>';
    }
}

// Criar query para apresentação de dados para edição no Formulário
$sql = "SELECT * FROM kit WHERE id = :ID LIMIT 1";

// Preparar Query
$stmt = $pdo->prepare($sql);

// Associar valor do ID
$stmt->bindValue(':ID', $id, PDO::PARAM_INT);

// Executar query
if ($stmt->execute()) {
    $reg = $stmt->fetch();
    $DEBUG .= "Obter dados da BD: " . print_r($reg, true) . "\n";
} else {
    $result .= '<div class="alert alert-danger">Ocorreu um erro ao ler registo da Base de Dados.</div>';
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

<form action="?m=<?= $module ?>&a=update&id=<?= $id ?>" role="form" method="post">
    <div class="form-group">
        <label for="id">ID</label>
        <input name="id" id="id" value="<?= $reg['ID'] ?>" type="text" readonly class="form-control">
    </div>
    <div class="form-group">
        <label for="nome">Nome</label>
        <input name="nome" id="nome" value="<?= $reg['NOME'] ?>" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="espaco_ID">Espaços</label>
        <select name="espaco_ID" id="espaco_ID" class="form-control">
            <?php
            foreach ($listEspaco as $espaco){ ?>
            <option value="<?= $espaco['ID'] ?>"><?= $espaco['ID'] ?> &lt;<?= $espaco['NOME'] ?>&gt;</option>
                <?php
            }
            ?>
        </select>
    </div>
    <button type="submit" name="update" class="btn btn-primary" value="update" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>


