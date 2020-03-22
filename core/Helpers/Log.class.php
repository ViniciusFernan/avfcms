<?php

/**
 * Log.class [ HELPER ]
 * Classe responsável por receber informações globais do sistema!
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */
class Log {
    /*     * **
     * Ao Criar Log Informar:
     * String Name Controller
     * String Name Actin
     * String Name Parametros
     * String Name Tipo
     * String Name Descrição
     */

    /**
     * Cria log
     * Padrao: Usuario Acessou (tipo) A pagina leads (Descricao)
     * @param INTEGER $tipo - idLogsTipos da tabela logs_tipos
     * @param STRING $controller - Controller da pagina atual
     * @param STRING $action - Action da pagina atual
     * @param STRING $parametros - Padrao Parse (teste=teste&teste2=teste2)
     * @param STRING $descricao - Descreve o que está sendo feito
     * @return BOOLEAN - id do log para true
     */
    public static function criarLog($tipo, $controller, $action, $descricao, $parametros = null) {
        $browser = Util::getBrowser();
        $array['idUsuario'] = $_SESSION['usuario']['idUsuario'];

        $array['controller'] = $controller;
        $array['action'] = $action;
        $array['parametros'] = $parametros;

        $array['idLogsTipos'] = $tipo;
        $array['descricao'] = $descricao;

        $array['data'] = Date('Y-m-d H:i:s');
        $array['ip'] = $_SERVER['REMOTE_ADDR'];
        $array['navegador'] = "browser: " . $browser['name'] . "-|  Versão:" . $browser['version'] . "-|  Plataforma: " . $browser['platform'];

        $createLog = (new Create('logs'))->Create($array);
        return $createLog->getResult();
    }

}
