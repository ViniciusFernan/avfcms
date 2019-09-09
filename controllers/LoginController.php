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

require_once ABSPATH . "/models/class/LoginModel.php";
class LoginController extends MainController {

    public function __construct() {
        $this->isLogin= false;
        //Classe de manipulação do login
        $this->Login = new LoginModel;

    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])):
            Util::redirect(HOME_URI);
            exit;
        endif;


        $logar = new LoginModel();
        $resp = [];
        if (!empty($this->parametrosPost['email']) && !empty($this->parametrosPost['senha']) ) {
            $logado = $logar->logar($this->parametrosPost['email'], $this->parametrosPost['senha']);

            if (is_string($logado) && !empty($logado)) {
                $resp['email'] = $this->parametrosPost['email'];
                $resp['senha'] = $this->parametrosPost['senha'];
                $resp['boxMsg'] = ['msg'=>$logado, 'tipo'=>'danger'];
            }else{
                Util::redirect(HOME_URI);
            }
        }else{
            $resp['email'] = !(empty($this->parametrosPost['email'])) ? $this->parametrosPost['email'] : '';
            $resp['senha'] = !(empty($this->parametrosPost['senha'])) ? $this->parametrosPost['senha'] : '';
        }

        //acesso a view;
        $View = new View('login/login.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    /**
     * Deslogar usuário.
     * Enviar para url /login/logout
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
