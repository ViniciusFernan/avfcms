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

require_once ABSPATH . "/models/class/Usuario.model.php";
class UsuarioController extends MainController {

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct() {
        $this->checkLogado();
    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction(){

        $resp = [];
        $listaUsuarios = (new UsuarioModel())->getListaDeUsuarios();
        if(!is_array($listaUsuarios) && !empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>$listaUsuarios, 'tipo'=>'danger'];;
        if(empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuarios'] = $listaUsuarios;

        $View = new View('usuario/default.view.php');
        $View->setParams($resp);
        $View->showContents();
    }


    public function editarUsuarioAction(){

        $resp = [];
        $id = $this->parametros[0];
        $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($id);
        if(!is_array($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
        if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuario'] = $dadosUsuario;

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

}
