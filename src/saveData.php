<?php

class SaveData 
{

	public function __construct()
	{
		$dados = file_get_contents("php://input");
		$fp = fopen('../database/bd.csv', "a+") or die(PHP_EOL . 'Erro: verifique se o arquivo está aberto por outro programa!');
		$obj = json_decode($dados);

		foreach ($obj as $value) {
			$valor = preg_replace( '/([^\d,])/',  '', $value->text->Valor);
			$valor = preg_replace('/[,]+/', ',', $valor);
			$fileName = date('Ymdhis')."-".$value->fileName;
			fwrite($fp, "{$value->text->Nome};{$value->text->Endereço};{$valor};{$value->text->Vencimento};{$fileName}\n");
			echo "Registro salvo com sucesso!".PHP_EOL;
			$this->saveFile($value->file, $fileName);
		}
		fclose($fp);
	}

	private function saveFile($file, $fileName) : void 
	 {
	    $fp = fopen("../files/{$fileName}","a+");
	    fwrite($fp, imap_base64($file));
	    fclose($fp);
	    echo "Anexo {$fileName} salvo com sucesso" . PHP_EOL;
	 }
}

new SaveData();