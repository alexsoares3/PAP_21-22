<?php //
if (count(get_included_files()) == 1) {
    header('Location: ../../index.php');
    exit("Direct access not permitted.");
}

$TITLE = 'Utilizadores - Adicionar';

// Verificar se foi feito submit ao formulário
$add = filter_input(INPUT_POST, 'add', FILTER_SANITIZE_STRING);
if ($add) {
    $result = '';
    $DEBUG .= "Ligar à BD\n";
    $pdo = connectDB($db);

    // Obter valores do Formulário de forma segura
    $DEBUG .= "Obter dados do Formulário:\n";
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);
    $avatar = filter_input(INPUT_POST, 'avatar', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
    
    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result .= '<div class="alert-danger">O email não é válido.</div>';
        $errors = true;
    }
    if ($username == '') {
        $result .= '<div class="alert-danger">Tem que definir um username.</div>';
        $errors = true;
    }
    if (strlen($password) < 8) {
        $result .= '<div class="alert-danger">Palavra-passe tem menos de 8 caracteres.</div>';
        $errors = true;
    }

    // Verificar se já foi registado um email
    $sql = "SELECT id FROM users WHERE email = :EMAIL LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result .= '<div class="alert-danger">O email indicado já se encontra registado.</div>';
        $errors = true;
    }

    // Se não tiver erros, Inserir
    if (!$errors) {
        $sql = "INSERT INTO users(username,email,password,profile,avatar) VALUES(:USERNAME,:EMAIL,:PASSWORD,:PROFILE,:AVATAR)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->bindValue(":PASSWORD", $password_hash_db, PDO::PARAM_STR);
        $stmt->bindValue(":PROFILE", $perfil, PDO::PARAM_STR);
        $stmt->bindValue(":AVATAR", $avatar, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result .= '<div class="alert-success">Utilizador criado com sucesso!</div>';
        } else {
            $result .= '<div class="alert-danger">Erro ao criar utilizador.</div>';
        }
    }    
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

<form action="?m=<?= $module ?>&a=create" role="form" method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input name="username" id="username" type="text" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" id="password" type="password" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" id="email" type="email" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="perfil">Perfil</label>
        <select name="perfil" id="perfil" class="form-control" >
            <option value="user">User</option> 
            <option value="admin">Admin</option>     
        </select>
    </div>
    <div class="form-group">
        <label for="avatar">Avatar</label>
        <input name="avatar" id="avatar" type="text" class="form-control">
    </div>
    <button type="submit" name="add" class="btn btn-primary" value="add" title="Guardar"><i class="fi fi-save"></i> Guardar</button>
    <a href="?m=<?= $module ?>&a=read" class="btn btn-secondary" title="Cancelar"> Cancelar</a>
</form>