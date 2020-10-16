<?php

header("Access-Control-Allow-Origin: *");
header('Cache-Control: no-cache, must-revalidate'); 
header("Content-Type: text/plain; charset=UTF-8");
header("HTTP/1.1 200 OK");

$dados = file_get_contents("php://input");

$fp = fopen('./database/bd.csv', "a+") or die('erro');
	fwrite($fp, $dados);

	fwrite($fp, 'recebenfo');
//$dados =  json_decode($_REQUEST['dados'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

//fwrite($fp, $_REQUEST['dados'].PHP_EOL);
/*




foreach ($dados as $dado) {
//	$linha = implode(";", (array)$dado);
	
}
*/

//fclose($fp);


fclose($fp);