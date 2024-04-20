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
$result_array["title"] = "Adicionar Categoria";




// Obter categoria
$nome = (property_exists($data,"nome") ? filter_var($data->nome,FILTER_SANITIZE_STRING) : '');

/*
$sql="SELECT NOME FROM categorias"
$list = $pdo->query($sql)->fetchAll();
if (array_in_string($nome, $list)) {
    $match=true; 
} else {
    $match=false;
}
*/


if ($nome!='' ) {

    // Criar query para inserir na BD
    $sql = "INSERT INTO 
                categorias(NOME)
                VALUES(:NOME)";
    // Preparar query
    $stmt = $pdo->prepare($sql);
    // Associar valores aos placeholders
    $stmt->bindValue(":NOME", $nome, PDO::PARAM_STR);

    // Executar query
    if ($stmt->execute()) {
        http_response_code(200);
        $result_array["message"] = "Categoria criada com sucesso";
        echo json_encode($result_array);
    } else {
        http_response_code(500);
        $result_array["message"] = "Erro ao criar Categoria";
        echo json_encode($result_array);
    }
}else{
    http_response_code(400);
    $result_array["message"] = "Erro Categoria por definir";
    echo json_encode($result_array);
}
?>