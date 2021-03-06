<?php


die('poota');
getConfig();
set_time_limit(0);
ini_set('allow_url_fopen', 0);


class MailReader
{
    public $mailBox = null;
    public $final = array();

    public function __construct()
    {
        $this->mailBox = imap_open("{" . SERVER . ":" . PORT . "/imap/ssl/novalidate-cert}INBOX", USER, PASS);
        $errors = imap_errors();

        if (is_array($errors)) {
            $this->showErrors($errors);
        } else {
            $this->Read();
            if (count($this->final) > 0) {
                $this->saveData();
            } else {
                echo "Sem novos emails!".PHP_EOL;
            }
        }
    }

    public  function Read()
    {
        if ($this->mailBox) {
            $unseenMessages = @imap_search($this->mailBox, 'UNSEEN'); //UNSEEN

            if (is_array($unseenMessages) > 0) {
                foreach ($unseenMessages as $message) {
                    
                    $body = quoted_printable_decode(imap_fetchbody($this->mailBox, $message, 1));
                    if (imap_base64(imap_fetchbody($this->mailBox, $message,2))) {
                        $this->final[] = parse_ini_string($this->searchText($body));
                    } else {
                        echo "E-mail sem anexo" . PHP_EOL;
                    }
                }
            }

            @imap_close($this->mailBox); //, CL_EXPUNGE
        }
    }

    private function showErrors($errors) : void
    {
        echo "<pre>";
        print_r($errors);
        echo "</pre>";
    }

    private function searchText($texto) : String
    {
        $ini = strpos($texto, "Nome");
        $fim = stripos($texto, "Att.");

        $conteudo = substr($texto, $ini, ($fim - $ini));

        $parse = str_replace(':', '=', $conteudo);
        return $parse;
    }

    private function saveData() : void
    {
        $data =  strip_tags(json_encode($this->final, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $ch = curl_init('http://localhost/saveData.php');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_PORT, "8080");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data))); 
        $result = curl_exec($ch);
        if ($result === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        echo $result;
        
        curl_close($ch);
    }
}

function getConfig() {

$dados = parse_ini_file('./config/config.ini');

var_dump($dados);

DEFINE('SERVER', 'imap.gmail.com');
DEFINE('PORT', '993');
DEFINE('USER', 'petersontesteicrs@gmail.com');
DEFINE('PASS', 'incoders2020');

}
/*
while (1 == 1) {
    $read = new MailReader();
    sleep(5);
}
*/
//$read = new MailReader();