

<?php
   session_start();
   if (!isset($_SESSION['uid'])) {
       session_destroy();
       header('Location: login.php');
       exit();
   }
   
   define('DESC', 'Sistema de Gestão de Equipamento');
   $html = '';
   
   require_once './config.php';
   require_once './core.php';
   
   // Obter módulo e ação a carregar
   $module = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_STRING);
   $action = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING);
   
   // Verificar módulo
   $module = ($module == '') ? 'home' : $module;
                                                                                                                                                                           
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?= DESC . ' | ' . AUTHOR ?></title>
      <meta name="description" content="<?= DESC ?>">
      <meta name="author" content="<?= AUTHOR ?>">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <link href="css/fontisto-3.0.4/fontisto.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/estilos.css">
      <script src="https://kit.fontawesome.com/41bcea2ae3.js"> </script>
   </head>
   <body id="body" style="background-color:#d3b3af">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <ul class="nav">
                  <div class="menu__side" id="menu_side">
                     <div class="name__page">
                        <img src="./images/aesb_logo.png" alt="Abrir Menu" style="width:50px;padding-right: 20px;" id="btn_open">
                        <h4><a href="./index.php" style="color: inherit; text-decoration: none;">Gestão de Equipamento</a></h4>
                     </div>
                     <div class="options__menu">
                        <?= is_admin() ? '
                           <a href="?m=users&a=read"> 
                               <div class="option">
                               <i class="fi fi-person" title="user"></i>
                                   <h4>Utilizadores</h4>
                               </div>
                           </a>' :''
                           ?>
                        <?= is_admin() ? '
                           <a href="?m=categorias&a=read">
                               <div class="option">
                               <i class="fi fi-archive" title="Categorias" ></i>
                                   <h4>Categorias</h4>
                               </div>
                           </a>' :''
                           ?>
                        <a href="?m=equipamento&a=read">
                           <div class="option">
                              <i class="fi fi-tv" title="Equipamento"></i>
                              <h4>Equipamento</h4>
                           </div>
                        </a>
                        <a href="?m=espaco&a=read">
                           <div class="option">
                              <i class="fa-solid fa-house" title="Espaços"></i>
                              <h4>Espaços</h4>
                           </div>
                        </a>
                        <a href="?m=kit&a=read">
                           <div class="option">
                              <i class="fa-solid fa-computer" title="Kits"></i>
                              <h4>Kits</h4>
                           </div>
                        </a>
                        <?= is_admin() ? '
                           <a href="./tickets">
                              <div class="option">
                              <i class="fa-solid fa-ticket" title="Tickets"></i>
                                 <h4>Tickets</h4>
                              </div>
                           </a>' :''
                        ?>
                        <a style="position: fixed;bottom: 15px;">
                           <div class="option">
                              <img src="<?= $_SESSION['avatar'] ?>" width="30" alt="avatar"> 
                              <!--<i class="fi fi-play-list" height="10px" title="Kits" style="padding-left:20px;"></i>-->
                              <i class="fa-solid fa-arrow-right-from-bracket" title="Logout" style="padding-left:20px;" onclick="window.location.href=('logout.php');"></i>
                              <h4 style="font-size: 18px;padding-left:5px;" onclick="window.location.href=('logout.php');">Terminar Sessão</h4>
                           </div>
                        </a>
                        <a style="font-size: smaller;position: fixed;bottom: 10px;">
                        <?= $_SESSION['username'] ?>   
                        </a>        
                     </div>
                  </div>
               </ul>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="jumbotron">
                  <?php
                     if ($module=='home'){
                         ?>
                  <h2><?= DESC ?></h2>
                  Utilize uma das opções disponíveis no menu lateral.  
                  <?php
                     }else{
                         require_once "./mod/$module/$action.php";
                     }
                     ?>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <?= debug() ? '<div class="jumbotron"><pre>'.$DEBUG.'<br>POST: ' . print_r($_POST, true) . '<br>GET: ' . print_r($_GET, true) . '<br>SESSION: ' . print_r($_SESSION, true) . '</pre></div>' : '' ?>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/scripts.js"></script>
      <script src="js/script.js"></script>
   </body>
</html>

