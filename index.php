<form>
    <input type="hidden" name="modo" value="1">
    <input type="submit" value="Ler">
</form>
<button onclick="window.open('./index.php', '_self');">Enviar email</button>
<?php

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
        $data =  html_entity_decode((json_encode($this->final, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
        $host = "http://localhost:8080/saveData.php?dados=" . $data;

        die($host);
        fopen($data, 'r');
    }
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_REQUEST['modo'])) {
    $read = new MailReader();
    $read->Read();
} else {
    include_once("./sendMail.php");
}
