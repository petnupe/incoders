<?php

header("Access-Control-Allow-Origin: *");
header('Cache-Control: no-cache, must-revalidate'); 
header("Content-Type: text/plain; charset=UTF-8");
header("HTTP/1.1 200 OK");

$dados = file_get_contents("php://input");
$fp = fopen('./database/bd.csv', "a+") or die('erro');
$obj = json_decode($dados);

foreach ($obj as $value) {
	$valor = preg_replace( '/([^\d,])/',  '', $value->Valor);
	$valor = preg_replace('/[,]+/', ',', $valor); // F
	fwrite($fp, "{$value->Nome};{$value->Endereço};{$valor};{$value->Vencimento}\n");
}

fclose($fp);

echo "Dados gravados com sucesso!". PHP_EOL;