<?php
// Obter dados enviados pelo Cliente
$data = json_decode(file_get_contents("php://input"));

// Definir resposta
header("Content-Type: application/text; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

// Escrever resposta
echo "Produto: ". $data->product;
echo "\nDescrição: ". $data->description;
echo "\nPreço: ". $data->price ."€";