<?php

DEFINE('SERVER', 'pop.gmail.com'); 
DEFINE('PORT', '995');
DEFINE('USER', 'rrdasoliveiras@gmail.com');
DEFINE('PASS', 'PeM@D@100408');

class MailReader {
    private $mailBox = null;

    public function __construct() {
        $this->mailBox = imap_open("{" . SERVER . ":" . PORT . "/pop3/ssl/novalidate-cert}INBOX", USER, PASS);
        $errors = imap_errors();

        if (is_array($errors)) {
            $this->showErrors($errors);
        } else {
            $this->Read();
        }
    }

    public  function Read () {
        if ($this->mailBox) {
            $nOfMessages = imap_num_msg($this->mailBox);

            if ($nOfMessages > 0) {
                for ($message = 1; $message <= $nOfMessages; $message++) {
                    $body = imap_fetchbody($this->mailBox, $message, 1);
                    $this->pegaDados($body);
                }
            }
            imap_close($this->mailBox);
        }
    }

    private function showErrors($errors) {
            echo "<pre>";
            print_r($errors);
            echo "</pre>";
    }

    private function pegaDados($texto) {
        $ini = strpos($texto, "Nome");
        $fim = stripos($texto, "Att.");

        $conteudo = substr($texto, $ini, ($fim-$ini));
        die($conteudo);
        $parse = str_replace(':', '=', $conteudo);
        $final = parse_ini_string($parse);

        foreach ($final as $key => $value) {
            echo $key .' => ' .$value.'<br >';
        }

        echo "<br /><br />";
    }
}

ini_set('display_errors', 1); error_reporting(E_ALL);
$read = new MailReader();
$read->Read();

/*
$texto = 'Date: sex., 9 de out. de 2020 às 13:17
Subject: Teste
To: <rrdasoliveiras@gmail.com>
Bom dia,
Segue meus dados de contato e informações para pagamento
Nome: Guarida Imóveis
Endereço: Protásio alves, 1309
Valor: R$1.300,50
Vencimento:12/19
Att.
Peterson.png
Peterson Nunes';

*/