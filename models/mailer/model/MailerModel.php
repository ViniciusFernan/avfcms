<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */
require_once ABSPATH . '/lib/PHPMailer/class.phpmailer.php';
require_once ABSPATH . '/lib/PHPMailer/class.smtp.php';

class Mailer {
    /* Configuracao de Conexão */

    private $Host;
    private $Username;
    private $Password;
    private $SMTPAuth;
    private $SMTPSecure;
    private $Port;


    /* Dados para Enviar */
    private $Assunto = "";
    private $Mensagem;
    private $Destinatario = [];
    private $DestinatarioCC = [];

    /* Remetente */
    private $EmailDe;
    private $NomeDe;

    /** Resultado do envio - Boolean */
    private $result;
    private $error;

    function __construct() {

        $this->Host = MAIL_HOST;
        $this->Username = MAIL_USER;
        $this->Password = MAIL_PASS;
        $this->SMTPAuth = MAIL_SMTP_AUTH;
        $this->SMTPSecure = MAIL_SMTP_SECURE;
        $this->Port = MAIL_PORT;

        $this->EmailDe = (defined('MAIL_FROM') ? MAIL_FROM : $this->Username);
        $this->NomeDe = (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : "");
    }

    /**
     * Insere um destinatario
     * @param String $Email
     * @param String $nome
     */
    public function setDestinatario($Email, $nome = NULL) {
        $this->Destinatario[] = ['email' => $Email, 'nome' => $nome];
    }

    /**
     * Insere um destinatario CC
     * @param String $email
     * @param String $nome
     */
    public function setDestinatarioCC($email, $nome = NULL) {
        $this->DestinatarioCC[] = ['email' => $email, 'nome' => $nome];
    }

    /**
     * Seta o Assunto da Mensagem
     * @param String $Assunto
     */
    function setAssunto($Assunto) {
        $this->Assunto = $Assunto;
    }

    /**
     * Seta a mensagem em HTML
     * @param String $Mensagem
     */
    function setMensagem($Mensagem) {
        $this->Mensagem = $Mensagem;
    }

    /**
     * Nome de quem envia o email
     * @param String $NomeDe
     */
    function setNomeDe($NomeDe) {
        $this->NomeDe = $NomeDe;
    }

    /**
     * Retorna true para envio ok
     * @return Boolean - True para envio ok
     */
    function getResult() {
        return $this->result;
    }

    /**
     * Caso Result = false, retorna a mensagem do erro
     * @return Boolean
     */
    function getError() {
        return $this->error;
    }

    public function Enviar() {

        try{
            $mail = new PHPMailer;

            $mail->SMTPDebug = 0;                           // Enable verbose debug output

            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $this->Host;                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->SMTPAuth;                               // Enable SMTP authentication
            $mail->Username = $this->Username;              // SMTP username
            $mail->Password = $this->Password;              // SMTP password
            $mail->SMTPSecure = $this->SMTPSecure;          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->Port;                      // TCP port to connect to
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($this->EmailDe, $this->NomeDe);

            if (empty($this->Destinatario)) throw new Exception("E-mail do destinatario nao informado");

            //DESTINATARIO
            foreach ($this->Destinatario as $destinatario) :
                if (empty($destinatario['email']) || !Util::Email($destinatario['email'])) throw new Exception("E-mail Invalido");

                if (!empty($destinatario['nome'])) $mail->addAddress($destinatario['email'], $destinatario['nome']);
                else $mail->addAddress($destinatario['email']);
            endforeach;

            //DESTINATARIO CC
            if (!empty($this->DestinatarioCC)):
                foreach ($this->DestinatarioCC as $destinatarioCC) :
                    if (empty($destinatarioCC['email']) || !Util::Email($destinatarioCC['email'])) throw new Exception("E-mail CC Invalido");

                    if (!empty($destinatarioCC['nome'])) $mail->addCC($destinatarioCC['email'], $destinatarioCC['nome']);
                    else $mail->addCC($destinatarioCC['email']);
                endforeach;
            endif;

//        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                             // Set email format to HTML

            $mail->Subject = $this->Assunto;
            $mail->Body = $this->Mensagem;
            $mail->AltBody = strip_tags(nl2br($this->Mensagem));

            if (!$mail->send()) {
                throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
            } else {
                return TRUE;
            }

        }catch (Exception $e){
            return $e;
        }
    }

}
