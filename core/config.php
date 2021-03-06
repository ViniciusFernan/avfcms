<?php
/**
 * Arquivo de Configuração do Sistema.
 * @package Sistema Base
 * @author AVFWEB
 * @version 1.0
 */
date_default_timezone_set('America/Sao_Paulo'); // Seta a timezone

/** URL da home */
$url = App['Application']['app_url'];

define('HOME_URI', $url);
/**PROJECT DIRETORIES */
define('PROJECT',  $_SERVER['SERVER_NAME'] );

/** Caminho para a raiz */
define('BASEPATH', $_SERVER['DOCUMENT_ROOT']);

/** APP_DIR */
define('APP', BASEPATH.'/app');

/** Caminho para a pasta do tema */
define('THEME_DIR', APP . '/view');

/** URL do tema */
define('THEME_URI', HOME_URI . '/app/view');

/** Caminho para a pasta de uploads */
define('UPLOAD', BASEPATH . '/_uploads');

/** Caminho para a pasta de uploads */
define('UP_URI', HOME_URI . '/_uploads');

/** Criptografia da senha [502ff82f7f1f8218dd41201fe4353687] */
define('HASH', App['Application']['app_hash']);

/** Nome do site ou sistema aparecerá nos emails enviados */
define('PROJECT_NAME', App['Application']['project_name']);

/** Deve ser true quando sistema necessita de login */
define('AUTH', true);

/**Configurações da conexão com o banco de dados*/
define('HOSTNAME', App['DataBase']['db_host']);
define('DB_NAME', App['DataBase']['db_name']);
define('DB_USER', App['DataBase']['db_user']);
define('DB_PASSWORD',  App['DataBase']['db_password']);
define('DB_CHARSET', 'utf8');
define('PORTA', App['DataBase']['db_port']);

/** CONFIGURAÇÕES DE ENVIO DE EMAIL **/
define('MAIL_HOST', App['EmailConfg']['mail_host']);
define('MAIL_USER', App['EmailConfg']['mail_user']);
define('MAIL_PASS', App['EmailConfg']['mail_pass']);
define('MAIL_SMTP_AUTH', true);
define('MAIL_SMTP_SECURE', false);
define('MAIL_PORT', App['EmailConfg']['mail_port']);
define('MAIL_FROM', App['EmailConfg']['mail_send']);
define('MAIL_FROM_NAME', App['EmailConfg']['mail_send_name']);
define('MAIL_DEBUG', false); //Debug

/**  Se você estiver desenvolvendo, o valor deve ser true */
$debug = (empty($_GET['avfTeste']) == '1' ? true : false);
define('DEBUG', $debug);

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