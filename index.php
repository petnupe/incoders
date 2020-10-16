<form>
    <input type="hidden" name="modo" value="1">
    <input type="submit" value="Ler">
</form>
<button onclick="window.open('./index.php', '_self');">Enviar email</button>
<?php

//set_time_limit(300);
ini_set('allow_url_fopen', 0);
DEFINE('SERVER', 'imap.gmail.com');
DEFINE('PORT', '993');
DEFINE('USER', 'rrdasoliveiras@gmail.com');
DEFINE('PASS', 'PeM@D@100408');

class MailReader
{
    public $mailBox = null;
    public $final = array();

    public function __construct()
    {



$this->saveData();

die();

        $this->mailBox = imap_open("{" . SERVER . ":" . PORT . "/imap/ssl/novalidate-cert}INBOX", USER, PASS);
        $errors = imap_errors();

        if (is_array($errors)) {
            $this->showErrors($errors);
        } else {
            $this->Read();
            if (is_array($this->final))
                $this->saveData();
        }
    }

    public  function Read()
    {
        if ($this->mailBox) {
            $unseenMessages = @imap_search($this->mailBox, 'ALL'); //UNSEEN

            if (is_array($unseenMessages) > 0) {
                foreach ($unseenMessages as $message) {
                    $struct = imap_fetchstructure($this->mailBox, $message);
                    if (@trim($struct->parts[1]->parameters[0]->value)) {
                        $body = imap_fetchbody($this->mailBox, $message, 1);
                        $this->final[] = parse_ini_string($this->searchText($body));
                    }
                }
            }
            @imap_close($this->mailBox); //, CL_EXPUNGE
        }
    }

    private function showErrors($errors)
    {
        echo "<pre>";
        print_r($errors);
        echo "</pre>";
    }

    private function searchText($texto)
    {
        $ini = strpos($texto, "Nome");
        $fim = stripos($texto, "Att.");

        $conteudo = substr($texto, $ini, ($fim - $ini));
        $parse = str_replace(':', '=', $conteudo);
        return $parse;
    }

    private function saveData()
    {
        $this->final = array('nome' => 'peterosn', "sobre" => "pedroso");
        $data =  json_encode($this->final, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $ch = curl_init('http://localhost:8888/saveData.php');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));  

ini_set('display_errors', 1);
error_reporting(~0);
$result = curl_exec($ch);
if ($result === false) {
        throw new Exception(curl_error($ch), curl_errno($ch));
    }
curl_close($ch);
var_dump($result);

      die('passando');
        //die($url);
        /*
        $options = array(
                    'http' => 
                    array(
                        'method'  => 'POST', 
                        'content' => $data,
                        'header'  =>  "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
                    )
            );

        $context = stream_context_create($options);
        */

        $return = file_get_contents($url);

    die($return);
    }
}


if (isset($_REQUEST['modo'])) {
    $read = new MailReader();
    $read->Read();
} else {
    //include_once("./sendMail.php");
}
