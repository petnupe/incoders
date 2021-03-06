<?php
getConfig();

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
            $unseenMessages = @imap_search($this->mailBox, TYPE_MESSAGES); //UNSEEN

            if (is_array($unseenMessages) > 0) {
                foreach ($unseenMessages as $message) {
                    $body = quoted_printable_decode(imap_fetchbody($this->mailBox, $message, 1));
                    $file = imap_fetchbody($this->mailBox, $message, 2);
                    if (trim($file)) {
                        $struct = imap_fetchstructure($this->mailBox, $message);
                        $fileName = $struct->parts[1]->dparameters[0]->value;
                        $this->final[] = array("text" => parse_ini_string($this->searchText($body)), "fileName" => $fileName, "file" => $file);
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
        $content = substr($texto, $ini, ($fim - $ini));
        $parse = str_replace(':', '=', $content);
        return $parse;
    }

    private function saveData() : void
    {
        $data =  json_encode($this->final);
        $curlInit = curl_init('http://localhost/saveData.php');
        curl_setopt($curlInit, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlInit, CURLOPT_PORT, PORT_IMAP);
        curl_setopt($curlInit, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlInit, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data))); 
        $result = curl_exec($curlInit);
        if ($result === false) {
            throw new Exception(curl_error($curlInit), curl_errno($curlInit));
        }
        echo $result;
        curl_close($curlInit);
    }
}

function getConfig() {
    set_time_limit(0);
    $cfgData = parse_ini_file('./config/config.ini');
    foreach ($cfgData as $key => $value) {
        define($key, $value);
    }
}

while (true) {
    new MailReader();
    sleep(TIME_READ);
}