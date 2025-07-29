<?php
require_once 'Conexao.php';
require_once __DIR__ . '/../vendor/autoload.php'; // carrega o autoloader do composer
require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/src/SMTP.php';
require_once __DIR__ . '/../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class Email extends Conexao {
    private $mail;

    public function __construct() {
        // Carrega variáveis do .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.skymail.net.br';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['EMAIL_USER'];
        $this->mail->Password   = $_ENV['EMAIL_PASS'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = 465;
        $this->mail->setFrom($_ENV['EMAIL_USER'], 'TI Chesiquimica');
    }

    public function enviarEmail($para, $assunto, $corpoHtml) {
        try {
            $this->mail->CharSet = 'UTF-8';
            $this->mail->clearAddresses();
            $this->mail->addAddress($para);
            $this->mail->isHTML(true);
            $this->mail->Subject = $assunto;
            $this->mail->Body    = $corpoHtml;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar email: " . $this->mail->ErrorInfo);
            return false;
        }
    }
}
