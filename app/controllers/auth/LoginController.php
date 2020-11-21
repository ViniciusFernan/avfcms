<?php

/**
 * Controlador que deverá ser chamado quando não for
 * especificado nenhum outro
 *
 * Camada - Controladores ou Controllers
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

require_once APP . "/models/auth/model/LoginModel.php";
class LoginController extends MainController {
    public $retorno =[];

    public function __construct() {
        $this->isLogin= false;
        //Classe de manipulação do auth
        $this->Login = new LoginModel;
    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        try{
            if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])):
                Util::redirect(HOME_URI);
                exit;
            endif;

            $logar = new LoginModel();
            if (!empty($this->parametrosPost['email']) && !empty($this->parametrosPost['senha']) ) {
                $logado = $logar->logar($this->parametrosPost['email'], $this->parametrosPost['senha']);
                if($logado instanceof Exception) throw $logado;

                Util::redirect(HOME_URI);
            }else{
                $this->retorno['email'] = !(empty($this->parametrosPost['email'])) ? $this->parametrosPost['email'] : '';
                $this->retorno['senha'] = !(empty($this->parametrosPost['senha'])) ? $this->parametrosPost['senha'] : '';
            }
        }catch (Exception $e){
            $this->retorno['email'] = $this->parametrosPost['email'];
            $this->retorno['senha'] = $this->parametrosPost['senha'];
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
        }

        //acesso a view;
        $View = new View('auth/login.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    /**
     * Deslogar usuário.
     * Enviar para url /auth/logout
     */
    public function logoutAction() {
        $Login = $this->Login;
        $Login->deslogar();
    }

    public function setAdminMasterAction(){
        if(!empty($_SESSION['usuario']['usuarioMaster'])) unset($_SESSION['usuario']['usuarioMaster']);

        if (empty($_SESSION['usuario']['usuarioMaster']) && !empty($_SESSION['usuario'])):
            $_SESSION['usuario']['usuarioMaster'] = $_SESSION['usuario'];
            Util::redirect(HOME_URI);
            exit;
        endif;
    }

}
