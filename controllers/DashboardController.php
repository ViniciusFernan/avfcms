<?php

/**
 * Controlador que deverá ser chamado quando não for
 * especificado nenhum outro
 *
 * Camada - Controladores ou Controllers
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0Locacao
 * */
require_once ABSPATH . "/models/class/DashboardModel.php";

class DashboardController extends MainController {

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct(){ }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        echo 'Dashboard';
    }


}
