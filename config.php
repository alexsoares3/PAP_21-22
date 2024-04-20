<?php

/* Descrição: Configurações da aplicação
 * Autor: Mário Pinto
 * 
 */
$db = [
    'host' => 'localhost',
    'port' => '3306',
    'charset' => 'utf8',    
    'dbname' => 'sibd_alexandresoares',
    'username' => 'sibd_alexandresoares',
    'password' => 'cGT51ehaYJOh5nJl'
];

// Modo de DEBUG
define('DEBUG', false);

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Constantes Gerais da Aplicação
define('SUBJ', 'SIBD');
define('AUTHOR', 'Alexandre Soares');
define('ANO_LETIVO', '2021.2022');

$DEBUG = ' -=[ D E B U G ]=-&nbsp; <br>';