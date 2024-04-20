<?php //
// Carregar configurações
require_once '../../config.php';
require_once '../../core.php';
$pdo = connectDB($db);

// Definição do cabeçalho
header("Content-Type: application/json; charset=UTF-8");

// Obter dados do POST
$data = json_decode(file_get_contents("php://input"));

// Preparar resposta
$result_array = array();
$result_array["title"] = "Atualizar Equipamento";

// Obter categoria
$id = ($data!=null &&property_exists($data,"id") ? filter_var($data->id,FILTER_SANITIZE_NUMBER_INT) : '');

if ($id!='') {
    $marca = ($data!=null &&property_exists($data,"marca") ? filter_var($data->marca,FILTER_SANITIZE_STRING) : NULL);
    $modelo = ($data!=null &&property_exists($data,"modelo") ? filter_var($data->modelo,FILTER_SANITIZE_STRING) : NULL);
    $categorias_ID = ($data!=null &&property_exists($data,"categorias_ID") ? filter_var($data->categorias_ID,FILTER_SANITIZE_STRING) : NULL);
    $ano = ($data!=null &&property_exists($data,"ano") ? filter_var($data->ano,FILTER_SANITIZE_STRING) : NULL);
    $espaco_ID = (property_exists($data,"espaco_ID") ? filter_var($data->espaco_ID,FILTER_SANITIZE_STRING) : NULL);
    $kit_ID = ($data!=null &&property_exists($data,"kit_ID") ? filter_var($data->kit_ID,FILTER_SANITIZE_STRING) : NULL);

    // Criar query para inserir na BD
    $sql = "UPDATE equipamento SET ".(
                $marca != NULL ? "marca = :MARCA," : ''
                ).(
                $modelo != NULL ? "modelo = :MODELO," : ''
                ).(
                $categorias_ID   != NULL ? "categorias_ID = :categorias_ID," : ''
                ).(
                $ano   != NULL ? "ano = :ANO," : ''
                ).(
                $espaco_ID   != NULL ? "espaco_ID = :espaco_ID," : ''
                ).(
                $kit_ID   != NULL ? "kit_ID = :kit_ID" : ''
                ).
            " WHERE ID = :ID";    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);
    if($marca != NULL){
        $stmt->bindValue(":MARCA", $marca, PDO::PARAM_STR);
    }
    if($modelo!=NULL){
        $stmt->bindValue(":MODELO", $modelo, PDO::PARAM_STR);
    }
    if($categorias_ID!=NULL){
        $stmt->bindValue(":categorias_ID", $categorias_ID, PDO::PARAM_STR);
    }
    if($ano!=NULL){
        $stmt->bindValue(":ANO", $ano, PDO::PARAM_STR);
    }
    if($espaco_ID!=NULL){
        $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);
    }
    if($kit_ID!=NULL){
        $stmt->bindValue(":kit_ID", $kit_ID, PDO::PARAM_STR);
    }

    // Executar query
    if ( ($stmt->execute()) && ($stmt->rowCount()>0) ) {
        http_response_code(200);
        $result_array["message"] = "Equipamento atualizado com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao atualizar Equipamento";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro pedido sem a informação necessária";
    echo json_encode($result_array);
}