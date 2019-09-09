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

require_once ABSPATH . "/models/class/UsuarioModel.php";
class UsuarioController extends MainController {

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct() {}

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction(){
        $resp = [];
        $listaUsuarios = (new UsuarioModel())->getListaDeUsuarios();
        if(is_string($listaUsuarios) && !empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>$listaUsuarios, 'tipo'=>'danger'];;
        if(empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuarios'] = $listaUsuarios;

        $View = new View('usuario/default.view.php');
        $View->setParams($resp);
        $View->showContents();
    }


    public function viewUsuarioEditAction(){
        $resp = [];

        $id = ($_SESSION['usuario']->idPerfil==1) ? $this->parametros[0] : $_SESSION['usuario']->idUsuario;
        $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($id);
        if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];
        if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuario'] = $dadosUsuario[0];

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    public function editarUsuarioAction(){
        $resp = [];

        if(empty($this->parametrosPost)){
            $resp['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{

            $dadosUsuario = (new UsuarioModel())->editarUsuario($this->parametrosPost);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['boxMsg'] = ['msg'=>'Usuário Editado com sucesso', 'tipo'=>'success'];

            //listar usuario
            $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($this->parametrosPost['idUsuario']);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['usuario'] = $dadosUsuario[0];
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    public function deletarUsuarioAction(){
        $resp = [];

        if(empty($this->parametros)){
            $resp['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{
            $dataSet['idUsuario'] = $this->parametros[0];
            $dataSet['status'] = '0';

            $dadosUsuario = (new UsuarioModel())->editarUsuario($dataSet);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['boxMsg'] = ['msg'=>'Usuário deletado com sucesso', 'tipo'=>'success'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

}
