<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$fp = fopen('./database/bd.csv', "a+");

$dados =  json_decode($_REQUEST['dados'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

foreach ($dados as $dado) {
	$linha = implode(";", (array)$dado);
	fwrite($fp, utf8_decode($linha).PHP_EOL);
}

fclose($fp);