<?php
   session_start();
   if (!isset($_SESSION['uid'])) {
       session_destroy();
       header('Location: ../../login.php');
       exit();
   }
   
   define('DESC', 'Sistema de Gestão de Equipamento');
   $html = '';
   
   require_once '../../config.php';
   require_once '../../core.php';
   
   // Obter módulo e ação a carregar
   $module = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_STRING);
   $action = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING);
   
   // Verificar módulo
   $module = ($module == '') ? 'home' : $module;
   $action = ($action == '') ? 'home' : $action;
                                                                                                                                                                           
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?= DESC . ' | ' . AUTHOR ?></title>
      <meta name="description" content="<?= DESC ?>">
      <meta name="author" content="<?= AUTHOR ?>">
      <link href="../../css/bootstrap.min.css" rel="stylesheet">
      <link href="../../css/style.css" rel="stylesheet">
      <link href="../../css/fontisto-3.0.4/fontisto.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="../../css/estilos.css">
      <script src="https://kit.fontawesome.com/41bcea2ae3.js"> </script>
   </head>
   <body id="body" style="background-color:#d3b3af">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <ul class="nav">
                  <div class="menu__side" id="menu_side">
                     <div class="name__page">
                        <img src="../../images/aesb_logo.png" alt="Abrir Menu" style="width:50px;padding-right: 20px;" id="btn_open">
                        <h4><a href="../index.php" style="color: inherit; text-decoration: none;">Gestão de Equipamento</a></h4>
                     </div>
                     <div class="options__menu">
                        <a href="../?&a=read">
                           <div class="option">
                           <i class="fa-solid fa-ticket" title="Ver Tickets"></i>
                              <h4>Ver Tickets</h4>
                           </div>
                        </a>
                        <a href="../index.php">
                           <div class="option">
                           <i class="fa-solid fa-ticket-simple" title="Criar Tickets"></i>
                              <h4>Criar Ticket</h4>
                           </div>
                        </a>
                        
                        <?= is_admin() ? '
                           <a href="../../index.php">
                              <div class="option">
                              <i class="fi fi-tv" title="Tickets"></i>
                                 <h4>Gestão de Equipamentos</h4>
                              </div>
                           </a>' :''
                        ?>
                        
                        
                        
                        <a style="position: fixed;bottom: 15px;">
                           <div class="option">
                              <img src="<?= $_SESSION['avatar'] ?>" width="30" alt=""> 
                              <!--<i class="fi fi-play-list" height="10px" title="Kits" style="padding-left:20px;"></i>-->
                              <i class="fa-solid fa-arrow-right-from-bracket" title="Logout" style="padding-left:20px;" onclick="window.location.href=('../logout.php');"></i>
                              <h4 style="font-size: 18px;padding-left:5px;" onclick="window.location.href=('../logout.php');">Terminar Sessão</h4>
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
                     if ($module=='home' && $action=='home'){
                         ?>
                  <h2>Salas Bloco C</h2>
                  Utilize uma das opções disponíveis no menu lateral.
                  <div class="row" width="33%">
                  <!--Botoes Salas-->
                     <?php
                     $pdo = connectDB($db);
                     $sql="SELECT * FROM espaco WHERE NOME LIKE 'c%'"; //WHERE NOME LIKE 'a%'
                     $list = $pdo->query($sql)->fetchAll();
                    foreach ($list as $reg) {
                     ?>   
                        <div class="col-sm-2" style="padding:10px;">
                           <div class="card" style="padding:10px;">
                              <div class="card-body">                             
                              <a href="../?a=create&espacoID=<?= $reg['ID'] ?>" class="btn btn-primary btn-block"><?= $reg['NOME'] ?></a>
                              </div>
                           </div>
                        </div>  
                  <?php
                  } 
                  ?>
                        <div class="col-sm-2" style="padding:10px;">
                           <div class="card" style="padding:10px;">
                              <div class="card-body" style="backgroundColor:'red'">                             
                              <a href="../index.php" class="btn btn-primary btn-block">Voltar</a>
                              </div>
                           </div>
                        </div> 
                  </div>
                  <?php
                     }else{
                         require_once "./$action.php";
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
      <script src="../js/jquery.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/scripts.js"></script>
      <script src="../js/script.js"></script>
   </body>
</html>

