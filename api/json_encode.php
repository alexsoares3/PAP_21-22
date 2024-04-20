<?php
$cores = array(
    array("nome" => "Azul", "RGB" => "#0000AA"),
    array("nome" => "Verde", "RGB" => "#00AA00"),
    array("nome" => "Vermelho", "RGB" => "#AA0000"),
);

// Preparar resposta
$response["message"] = "Paleta de Cores";
$response["count"] = count($cores);
$response["data"] = $cores;

// Definir resposta
header("Content-Type: application/json; charset=UTF-8");
http_response_code(200);

// Escrever resposta
echo json_encode($response);