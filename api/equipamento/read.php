<?php
require_once '../../config.php';
require_once '../../core.php';
$pdo = connectDB($db);

// Criar query
$sql ="SELECT equipamento.ID AS equipID,equipamento.MARCA,equipamento.MODELO,
equipamento.categorias_ID,equipamento.ANO,
categorias.NOME AS catNome,categorias.ID,equipamento.espaco_ID,equipamento.kit_ID,
espaco.NOME AS espacoNome,espaco.ID,kit.NOME AS kitNome, kit.ID 
FROM equipamento,categorias,espaco,kit 
WHERE equipamento.categorias_ID=categorias.ID AND espaco.ID=equipamento.espaco_ID AND equipamento.kit_ID=kit.ID";

// Executar query e obter dados da Base de Dados
$list = $pdo->query($sql)->fetchAll();

// Contar número de registos
$num = count($list);
if ($num > 0) {

    // Array de produtos
    $result_array = array();
    $result_array["title"] = 'Equipamentos';
    $result_array["count"] = $num;
    $result_array["data"] = array();

 // Obter registos
    foreach ($list as $registo){
        $product_item = array(
            "id" => $registo['equipID'],
            "marca" => $registo['MARCA'],
            "modelo" => $registo['MODELO'],
            "categorias_nome" => $registo['catNome'],
            "categorias_id" => $registo['categorias_ID'],
            "ano" => $registo['ANO'],
            "espaco_nome" => $registo['espacoNome'],
            "espaco_id" => $registo['espaco_ID'],
            "kit_nome" => $registo['kitNome'],
            "kit_id" => $registo['kit_ID'],
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