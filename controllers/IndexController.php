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
class IndexController extends MainController {

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct() {
        if(LOGIN_MODULE===true){
            $this->checkLogado();
        }

    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction(){

        $View = new View('default/default.view.php');
        $View->showContents();
    }

}
