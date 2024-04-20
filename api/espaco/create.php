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
$result_array["title"] = "Adicionar Espaço";

// Obter categoria
$nome = (property_exists($data,"nome") ? filter_var($data->nome,FILTER_SANITIZE_STRING) : '');

if ($nome!='') {

    // Criar query para inserir na BD
    $sql = "INSERT INTO 
                espaco(NOME)
                VALUES(:NOME)";
    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);

    // Executar query
    if ($stmt->execute()) {
        http_response_code(200);
        $result_array["message"] = "Espaço criado com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao criar Espaço";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro Espaco por definir";
    echo json_encode($result_array);
}
?>