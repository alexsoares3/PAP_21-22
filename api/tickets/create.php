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
$result_array["title"] = "Adicionar Ticket";

// Obter categoria
$titulo = (property_exists($data,"titulo") ? filter_var($data->titulo,FILTER_SANITIZE_STRING) : '');
$descricao = (property_exists($data,"descricao") ? filter_var($data->descricao,FILTER_SANITIZE_STRING) : '');
$espaco_ID = (property_exists($data,"espaco_ID") ? filter_var($data->espaco_ID,FILTER_SANITIZE_STRING) : '');
$estado = (property_exists($data,"estado") ? filter_var($data->estado,FILTER_SANITIZE_STRING) : '');
$users_id = (property_exists($data,"users_id") ? filter_var($data->users_id,FILTER_SANITIZE_STRING) : '');

if ($descricao!='') {

    // Criar query para inserir na BD
    $sql = "INSERT INTO 
                tickets(TITULO,DESCRICAO,espaco_ID,DATAHORA,ESTADO,users_id)
                VALUES(:TITULO,:DESCRICAO,:espaco_ID,NOW(),:ESTADO,:users_id)";
    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":TITULO", $titulo, PDO::PARAM_STR);
    $stmt->bindValue(":DESCRICAO", $descricao, PDO::PARAM_STR);
    $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);
    $stmt->bindValue(":ESTADO", $estado, PDO::PARAM_STR);
    $stmt->bindValue(":users_id", $users_id, PDO::PARAM_STR);

    // Executar query
    if ($stmt->execute()) {
        http_response_code(200);
        $result_array["message"] = "Ticket criado com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao criar Ticket";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro Ticket por definir";
    echo json_encode($result_array);
}
?>