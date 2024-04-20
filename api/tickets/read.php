<?php
require_once '../../config.php';
require_once '../../core.php';
$pdo = connectDB($db);

// Criar query
$sql ="SELECT * FROM tickets";

// Executar query e obter dados da Base de Dados
$list = $pdo->query($sql)->fetchAll();

// Contar número de registos
$num = count($list);
if ($num > 0) {

    // Array de produtos
    $result_array = array();
    $result_array["title"] = 'Tickets';
    $result_array["count"] = $num;
    $result_array["data"] = array();

 // Obter registos
    foreach ($list as $registo){
        $product_item = array(
            "ID" => $registo['ID'],
            "TITULO" => $registo['TITULO'],
            "DESCRICAO" => $registo['DESCRICAO'],
            "espaco_ID" => $registo['espaco_ID'],
            "DATAHORA" => $registo['DATAHORA'],
            "ESTADO" => $registo['ESTADO'],
            "users_id" => $registo['users_id'],
        );
        array_push($result_array["data"], $product_item);
     }
    // Definir resposta - 200 OK
    http_response_code(200);
    echo json_encode($result_array);
} else {
    // Não encontrou produtos - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Sem registos."));
}
?>