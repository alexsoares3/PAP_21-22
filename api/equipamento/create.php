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
$result_array["title"] = "Adicionar Equipamento";

// Obter categoria
$marca = (property_exists($data,"marca") ? filter_var($data->marca,FILTER_SANITIZE_STRING) : '');
$modelo = (property_exists($data,"modelo") ? filter_var($data->modelo,FILTER_SANITIZE_STRING) : '');
$categorias_ID = (property_exists($data,"categorias_ID") ? filter_var($data->categorias_ID,FILTER_SANITIZE_STRING) : '');
$ano = (property_exists($data,"ano") ? filter_var($data->ano,FILTER_SANITIZE_STRING) : '');
$espaco_ID = (property_exists($data,"espaco_ID") ? filter_var($data->espaco_ID,FILTER_SANITIZE_STRING) : '');
$kit_ID = (property_exists($data,"kit_ID") ? filter_var($data->kit_ID,FILTER_SANITIZE_STRING) : '');

if ($marca!='') {

    // Criar query para inserir na BD
    $sql = "INSERT INTO 
                equipamento(MARCA,MODELO,categorias_ID,ANO,espaco_ID,kit_ID)
                VALUES(:MARCA,:MODELO,:categorias_ID,:ANO,:espaco_ID,:kit_ID)";
    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":MARCA", $marca, PDO::PARAM_STR);
    $stmt->bindValue(":MODELO", $modelo, PDO::PARAM_STR);
    $stmt->bindValue(":categorias_ID", $categorias_ID, PDO::PARAM_STR);
    $stmt->bindValue(":ANO", $ano, PDO::PARAM_STR);
    $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);
    $stmt->bindValue(":kit_ID", $kit_ID, PDO::PARAM_STR);

    // Executar query
    if ($stmt->execute()) {
        http_response_code(200);
        $result_array["message"] = "Equipamento criado com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao criar Equipamento";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro Equipamento por definir";
    echo json_encode($result_array);
}
?>