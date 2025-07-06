<?php
    require_once 'Conexao.php';
    require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/../phpmailer/src/SMTP.php';
    require_once __DIR__ . '/../phpmailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    class Email extends Conexao{
        private $email; 

        public function __construct() {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.skymail.net.br';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'ti@chesiquimica.com.br';
        $this->mail->Password   = '$v4[j9?x@';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port       = 465;
        $this->mail->setFrom('ti@chesiquimica.com.br', 'TI Chesiquimica');
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