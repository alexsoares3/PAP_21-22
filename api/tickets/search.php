<?php

// Carregar configurações
require_once '../../config.php';
require_once '../../core.php';
$pdo = connectDB($db);

// Definição do cabeçalho
header("Content-Type: application/json; charset=UTF-8");

// Obter dados do POST
$data = json_decode(file_get_contents("php://input"));
// Obter keywords
$search = filter_var($data->s,FILTER_SANITIZE_STRING);

if (!empty($search)) {
    // Criar SQL
    $sql = "SELECT * FROM tickets WHERE DESCRICAO LIKE :PESQUISA";

    // Preparar query e afetar a pesquisa
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':PESQUISA', "%".$search."%");

    // Executar e obter registos
    if($stmt->execute()){
        $list = $stmt->fetchAll();
    }else{
        $list = [];
    }
    $num = count($list);

    // Preparar resposta
    $result_array = array();
    $result_array["title"] = "Pesquisa: $search";
    $result_array["count"] = $num;
    $result_array["data"] = array();

    // Verificar se existem registos
    if ($num > 0) {
        // Obter registos
        foreach ($list as $registo){
            $product_item = array(
                "ID" => $registo['ID'],
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
        echo json_encode($result_array);
    }
} else {
    // Erros no pedido - 400 bad request
    http_response_code(400);
    echo json_encode(array("message" => 'Pedido sem informação.'));
}