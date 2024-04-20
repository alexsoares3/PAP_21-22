<?php
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Utilizadores - Editar';

$result = '';
$DEBUG .= "Ligar à BD\n";
$pdo = connectDB($db);

// Obter ID pelo URL de forma segura
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$DEBUG .= "Obter dados do URL: id=$id\n";


// Verificar se foi feito submit ao formulário
$update = filter_input(INPUT_POST, 'update', FILTER_SANITIZE_STRING);
if ($update) {

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $avatar = filter_input(INPUT_POST, 'avatar', FILTER_SANITIZE_STRING);

    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result .= '<div class="alert-danger">O email não é válido.</div>';
        $errors = true;
    }
    if ($username == '') {
        $result .= '<div class="alert-danger">Tem que definir um username.</div>';
        $errors = true;
    }

    $sql = "SELECT id FROM users WHERE email = :EMAIL AND id <> :ID LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result .= '<div class="alert-danger">O email indicado já se encontra registado.</div>';
        $errors = true;
    }

    if (!$errors) {
        $sql = "UPDATE users SET 
                    username = :USERNAME,
                    email = :EMAIL,
                    profile = :PROFILE,
                    avatar = :AVATAR
                WHERE id = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
        $stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->bindValue(":PROFILE", $perfil, PDO::PARAM_STR);
        $stmt->bindValue(":AVATAR", $avatar, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->execute()) {
            $result .= '<div class="alert-success">Utilizador atualizado com sucesso!</div>';
        } else {
            $result .= '<div class="alert-danger">Erro ao atualizar utilizador.</div>';
        }
    }
}

// Criar query para apresentação de dados para edição no Formulário
$sql = "SELECT * FROM users WHERE id = :ID LIMIT 1";

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
        <input name="id" id="id" value="<?= $reg['id'] ?>" type="text" readonly class="form-control">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input name="username" id="username" value="<?= $reg['username'] ?>" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="email" value="<?= $reg['email'] ?>" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="perfil">Perfil</label>
        <select name="perfil" id="perfil" class="form-control" >
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="userTickets">UserTickets</option>   
        </select>
    </div>
    <div class="form-group">
        <label for="avatar">Avatar (Inserir link da imagem e reiniciar sessão para aplicar)</label>
        <input name="avatar" id="avatar" type="text" value="<?= $reg['avatar'] ?>" class="form-control">
    </div>
    <button type="submit" name="update" class="btn btn-primary" value="update" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>
