<?php
/**
 * Arquivo de Configuração do Sistema.
 *
 * @package Sistema de Lead
 * @author Inaweb
 * @version 1.0
 */

date_default_timezone_set('America/Sao_Paulo'); // Seta a timezone
/** URL da home */
$url = ($_SERVER['SERVER_NAME'] == 'localhost' ? 'http://localhost' : 'http://avfweb.com.br');

define('HOME_URI', $url);

/** Caminho para a raiz */
define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);

/** Caminho para a pasta do tema */
define('THEME_DIR', ABSPATH . '/view');

/** URL do tema */
define('THEME_URI', HOME_URI . '/view');

/** Caminho para a pasta de uploads */
define('UP_ABSPATH', ABSPATH . '/_uploads');

/** Caminho para a pasta de uploads */
define('UP_URI', HOME_URI . '/_uploads');

/** Criptografia da senha */
define('HASH', '502ff82f7f1f8218dd41201fe4353687');

/** Nome do site ou sistema aparecerá nos emails enviados */
define('PROJECT_NAME', 'AVF_CMS');



/** DEFINE SE ADMIN DEVE SER CHAMADO */
define('LOGIN_MODULE', true);


/**
 *  Configurações da conexão com o banco de dados
 */
if ($_SERVER['SERVER_NAME'] == 'localhost'):
    define('HOSTNAME', 'localhost'); //Hostname do banco
    define('DB_NAME', 'avf_cms'); // Nome do DB
    define('DB_USER', 'root'); // Usuário do DB
    define('DB_PASSWORD', ''); // Senha do DB
    define('DB_CHARSET', 'utf8'); // Charset da conexão PDO
    define('PORTA', '3307'); // Charset da conexão PDO
endif;


/** CONFIGURAÇÕES DE ENVIO DE EMAIL **/
define('MAIL_HOST', 'mail.gmail.com.br');
define('MAIL_USER', 'meuemail@gmail.com.br');
define('MAIL_PASS', 'sddssaassddssa');
define('MAIL_SMTP_AUTH', true);
define('MAIL_SMTP_SECURE', false);
define('MAIL_PORT', 587);
define('MAIL_FROM', 'meuemail@gmail.com.br'); //Email do Remetente
define('MAIL_FROM_NAME', 'SISTEMA'); //Nome do Remetente



/**  Se você estiver desenvolvendo, o valor deve ser true */
$debug = ($_SERVER['SERVER_NAME'] == 'localhost' ? true : false);
define('DEBUG', $debug);

//CORRIGE HORARIO DO SISTEMA
date_default_timezone_set("Brazil/East");

// Inicia a sessão se não estiver no diretorio de CRON
session_start();

/*  Ativa o Debug do PHP  */
if (!defined('DEBUG') || DEBUG === false) {
    // Esconde todos os erros
    error_reporting(0);
    ini_set("display_errors", 0);

} else {
    // Mostra todos os erros
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/*
 * TRATAMENTO DE ERROS
 * CSS constantes :: Mensagens de Erro
 */
define('ERR_ACCEPT', 'alert-success');
define('ERR_INFOR', 'alert-info');
define('ERR_ALERT', 'alert-warning');
define('ERR_ERROR', 'alert-danger');

/**
 * FrontErro :: Exibe erros lançados no Front (Com Estilo CSS)
 * @param String|Array $ErrMsg - Mensagem do Erro
 * @param String $ErrNo - Padrão de Erro PHP [E_USER_NOTICE | ERR_INFOR | E_USER_WARNING | ERR_ALERT]
 * @param boolean $ErrDie - True caso queira parar a execução da pagina
 */
function FrontErro($ErrMsg, $ErrNo, $ErrDie = null) {

    $CssClass = ($ErrNo == E_USER_NOTICE ? ERR_INFOR : ($ErrNo == E_USER_WARNING ? ERR_ALERT : ($ErrNo == E_USER_ERROR ? ERR_ERROR : $ErrNo)));
    echo '<div class="alert ' . $CssClass . ' alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  ' . $ErrMsg . '
                </div>';

    if ($ErrDie):
        die;
    endif;
}

/**
 * PHPErro :: personaliza o gatilho do PHP
 * Para disparar manualmente use no try catch: PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
 * @param String $ErrNo - Padrão de Erro PHP [E_USER_NOTICE | ERR_INFOR | E_USER_WARNING | ERR_ALERT]
 * @param String $ErrMsg - Mensagem do Erro
 * @param type $ErrFile - Arquivo do erro
 * @param type $ErrLine - Linha do erro
 */
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? ERR_INFOR : ($ErrNo == E_USER_WARNING ? ERR_ALERT : ($ErrNo == E_USER_ERROR ? ERR_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}


/**
 * Debugar Array
 * @param Array $array
 * @param Boolean $die = true para parar o codigo
 */
function pre($array, $die = false) {

    if (!is_array($array)):
        echo "NAO E UM ARRAY";
        return;
    elseif (empty($array)):
        echo "ARRAY VAZIO";
        return;
    endif;

    echo "<pre>";
    print_r($array);
    if ($die)
        die;
    echo "</pre>";
}