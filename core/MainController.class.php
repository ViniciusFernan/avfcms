<?php

/**
 * MainController - Todos os controllers deverão estender essa classe
 *
 * Camada - Controladores ou Controllers
 *
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */
require_once ABSPATH . "/models/class/LoginModel.php";
abstract class MainController {

    /**
     * Classe de Manipulação do login
     * @var LoginModel
     * */
    protected $Login;

    /**
     * Parametros passados por GET
     * @access protected
     */
    protected $parametros = array();

    /**
     * Parametros passados POST
     * @access protected
     */
    protected $parametrosPost = array();

    /**
     * Salva as Permissões do usuario logado
     *
     * <b>Para usar, tem que ser pagina restrita e o usuario deve estar logado</b>
     * @var Array
     */
    protected $permissoes = array();

    /**
     * Verifica permissao de acesso, caso acesso negado, carrega a pagina de acesso negado
     * @param type $checaPermissoes
     * @param BOOLEAN $ajax - True para barrar o acesso a pagina 404
     * @return boolean
     */
    public function checaPermissoes($checaPermissoes, $ajax = false) {
        if (!Util::Permissoes($checaPermissoes)) {
            if ($ajax)
                exit;
            $View = new View('PermissaoNegada.view.php');
            $View->showContents();
        }
    }

    public function checkLogado(){
        if(empty($_SESSION['usuario']) || !isset($_SESSION['usuario'])){

            $this->Login = new LoginModel;
            $this->Login->deslogar();
        }
    }

    public function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    public function setParametrosPost($parametrosPost) {
        $this->parametrosPost = $parametrosPost;
    }


}

// class MainController