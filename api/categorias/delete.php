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
$result_array["title"] = "Apagar Categoria";

// Obter categoria
$id = ($data!=null &&property_exists($data,"id") ? filter_var($data->id,FILTER_SANITIZE_NUMBER_INT) : '');

if ($id!='') {

    // Criar query para inserir na BD
    $sql = $sql ="DELETE FROM categorias WHERE ID = :ID";;    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":ID", $id, PDO::PARAM_INT);

    // Executar query
    if ( ($stmt->execute()) && ($stmt->rowCount()>0) ) {
        http_response_code(200);
        $result_array["message"] = "Categoria apagada com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao apagar categoria";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro pedido sem a informação necessária";
    echo json_encode($result_array);
}