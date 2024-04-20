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
$result_array["title"] = "Adicionar Kit";

// Obter categoria
$nome = (property_exists($data,"nome") ? filter_var($data->nome,FILTER_SANITIZE_STRING) : '');
$espaco_ID = (property_exists($data,"espaco_ID") ? filter_var($data->espaco_ID,FILTER_SANITIZE_STRING) : '');

if ($nome!='') {

    // Criar query para inserir na BD
    $sql = "INSERT INTO 
                kit(NOME,espaco_ID)
                VALUES(:NOME,:espaco_ID)";
    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);
    $stmt->bindValue(":espaco_ID", $espaco_ID, PDO::PARAM_STR);

    // Executar query
    if ($stmt->execute()) {
        http_response_code(200);
        $result_array["message"] = "Kit criado com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao criar Kit";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro Kit por definir";
    echo json_encode($result_array);
}
?>