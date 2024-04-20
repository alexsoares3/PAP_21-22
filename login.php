<?php
session_start();
define('DESC', 'Fazer login de um utilizador');
$html = '';
$htmlErrors = '';

require_once './config.php';
require_once './core.php';

$login = filter_input(INPUT_POST, 'login');
if ($login) {
    $pdo = connectDB($db);
    $html .= debug() ? '<p>Utilizador: <code>' . $db['username'] . '</code> Base de Dados: <code>' . $db['dbname'] . '</code></p>' : '';

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_hash_db = password_hash($password, PASSWORD_DEFAULT);
    $html .= debug() ? "<br><code>FORMULÁRIO:<br>email: $email <br> pwd: $password <br> hash: $password_hash_db</code>" : '';

    $errors = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $htmlErrors .= '<div class="container alert-danger">O email não é válido.</div>';
        $errors = true;
    }
    
    if (!$errors) {
        $sql = "SELECT * FROM `users` WHERE `email` = :EMAIL LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":EMAIL", $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
            $htmlErrors .= '<div class="container alert-danger">O email indicado não se encontra registado.</div>';
            $errors = true;
        } else {
            $row = $stmt->fetch();
            $html .= debug() ? '<br><code>BASE DE DADOS:<br>id: '.$row['id'].'<br> username: '.$row['username'].'<br> password: '.$row['password'].'</code>' : '';
        }
    }
    
    if (!$errors) {
        if (!password_verify($password, $row['password'])) {
            $htmlErrors .= '<div class="container alert-danger">Palavra-passe incorreta.</div>';
            sleep(random_int(1, 3));
        } else {
            $_SESSION['uid'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['profile'] = $row['profile'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['avatar'] = $row['avatar'] != '' ? $row['avatar'] : 'avatar.png';
            $html .= '<div class="container alert-success" style="margin-top:20px;">Login com sucesso! <br> <b>' . $_SESSION['username'] . '</b></div>';
            if ($_SESSION['profile'] == "userTickets") {
              header("location: tickets/index.php");
              exit();
            } else {
              header("location: index.php");
              exit();
            } 
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login - Sistema de Gestão de Equipamentos</title>
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
    <h1>Login</h1>
    <div class="content">
      <div class="input-field">
        <input type="email" placeholder="Email" autocomplete="nope" name="email" id="email">
      </div>
      <div class="input-field">
        <input type="password" placeholder="Password" autocomplete="new-password" name="password" id="password">
      </div>
      <div class="container" style="color:red;"><?= $htmlErrors ?></div>
    </div>

    
    <div class="action">
        <button type="submit" name="login" value="Login">Login</button>
        <button onclick="window.location.href=('register.php'); return false;">Registar</button>
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
