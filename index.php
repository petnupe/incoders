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
}

//ini_set('display_errors', 1); error_reporting(E_ALL);
$read = new MailReader();
$read->Read();