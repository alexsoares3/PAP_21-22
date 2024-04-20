<?php
define('DESC', 'Registar um novo utilizador');
$html = '';
$htmlErrors = '';

require_once './config.php';
require_once './core.php';

// Verificar se o formulário foi submetido
$register = filter_input(INPUT_POST, 'register');
if ($register) {
    $pdo = connectDB($db);
    $html .= debug() ? '<p>Utilizador: <code>' . $db['username'] . '</code> Base de Dados: <code>' . $db['dbname'] . '</code></p>' : '';

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $html .= debug() ? "<code>FORMULÁRIO:<br>email: $email <br> username: $username <br> pwd: $password <br> hash: $password_hash_db</code>" : '';

    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $htmlErrors .= '<div class="alert-danger">O email não é válido.</div>';
        $errors = true;
    }
    if ($username == '') {
        $htmlErrors .= '<div class="alert-danger">Tem que definir um username.</div>';
        $errors = true;
    }
    if (strlen($password) < 8) {
        $htmlErrors .= '<div class="alert-danger">Palavra-passe tem menos de 8 caracteres.</div>';
        $errors = true;
    }

    $sql = "SELECT id FROM users WHERE email = :EMAIL LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $htmlErrors .= '<div class="alert-danger">O email indicado já se encontra registado.</div>';
        $errors = true;
    }

    if (!$errors) {
        $html .= '<p>Informação válida proceder ao registo.</p>';
        $sql = "INSERT INTO users(username,email,password,profile) VALUES(:USERNAME,:EMAIL,:PASSWORD,'user')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":USERNAME", $username, PDO::PARAM_STR);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->bindValue(":PASSWORD", $password_hash_db, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $htmlErrors .= '<div class="container alert-success" style="color:green;">Utilizador criado com sucesso!</div>';
        } else {
            $htmlErrors .= '<div class="container alert-danger">Erro ao inserir na Base de Dados.</div>';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Simple Login Form Example</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'><link rel="stylesheet" href="./styleLogin.css">

</head>
<body>

<table style="margin:auto;margin-top:30px;" >
  <tr>
    <td>
      <img src="./images/aesb_logo.png" style="width: 60px">
    </td>
    <td>
      <h1 style="font-weight: 300;">Sistema de Gestão de Equipamentos</h1>
    </td>
  </tr>
</table>
<!-- partial:index.partial.html -->
<div class="login-form">
  <form action="?" method="POST">
    <h1>Registar</h1>
    <div class="content">
      <div class="input-field">
        <input type="email" placeholder="Email" autocomplete="nope" name="email" id="email">
      </div>
      <div class="input-field">
        <input type="username" placeholder="username" autocomplete="username" name="username" id="username">
      </div>
      <div class="input-field">
        <input type="password" placeholder="Password" autocomplete="new-password" name="password" id="password">
      </div>
      <div class="container" style="color:red;"><?= $htmlErrors ?></div>
    </div>
    <div class="action">
      <button onclick="window.location.href=('login.php'); return false;" name="login" value="Login">Login</button>
      <button type="submit" name="register" value="Registar">Registar</button>
    </div>
  </form>
</div>
<div class="container"><?= $html ?></div>
<!-- partial -->
  <script  src="./scriptLogin.js"></script>

  <div class="container">
            <?= debug() ? '<div><code>POST: ' . print_r($_POST, true) . '<br>GET: ' . print_r($_GET, true) . '<br>SESSION: ' . print_r($_SESSION, true) . '</code></div>' : '' ?>
        </div>
</body>
</html>
