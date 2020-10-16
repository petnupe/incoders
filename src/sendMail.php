<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->SMTPSecure = 'ssl';
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->Username = "tecnologia@tecbiz.com.br";
	$mail->Password = "tecbiz16";
	$mail->SMTPAuth = true;
    //Recipients
    $mail->setFrom('pemadata@gmail.com', 'Mailer');
    $mail->addAddress('rrdasoliveiras@gmail.com', 'Joe User');    
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = "Bom dia,<br />
    Segue meus dados de contato e informações para pagamento<br />
    Nome: Guarida Imóveis<br />
    Endereço: Protásio alves, 1309<br />
    Valor: R$ ".number_format(rand(1.00, 9999.99), 2, ',', '.')."<br />
    Vencimento:".rand(1,12)."/".rand(20, 22)."<br />
    Att.<br />
    Peterson.png<br />
    Peterson Nunes<br />";
    
    
    if(rand(1,2) == 2)
    $mail->addAttachment('./README.md');
    
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: <pre>{$mail->ErrorInfo}</pre>";
}