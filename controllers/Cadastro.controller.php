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

class CadastroController extends MainController {

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        $View = new View('cadastro/cadastro.view.php');
        $View->showContents();
    }

    public function cadastrarNovoUsuarioAction(){
        $resp = [];
		$error = false;

        $usuario = new UsuarioModel;

        $insertResp = $usuario->novoUsuario($this->parametrosPost);
        if(empty($insertResp) && !is_int($insertResp) ) {
            unset($this->parametrosPost["senha"]);
            $resp=['msg' => "Erro ao cadastrar usuário!", 'tipo' => 'danger'];
            $error = true;
        }else if(!empty($insertResp) && !is_int($insertResp) ){
            $resp=['msg' => $insertResp, 'tipo' => 'danger'];
            $error = true;
        }else{
            $resp['resp'] = $insertResp;
            $resp=['msg'=>"Usuário cadastrado com sucesso!", 'tipo'=>'success'];
            $error = false;
        }


        $View = new View('cadastro/cadastro.view.php');
        $View->addParams('boxMsg', $resp);
        $View->addParams('post', $this->parametrosPost);
        $View->showContents();
    }


    /***********************************   AJAX   ********************************************/
    public function checarSeUsuariosJaExisteAjaxAction(){
        $usuario = new UsuarioModel;
        $resp=[];
        if(!empty($this->parametrosPost['email'])) {
            $selectResp = $usuario->checarEmailJaEstaCadastrado(['email' => $this->parametrosPost['email']] );
            if(!empty($selectResp)){
                $resp['resp'] = false;
                $resp['boxMsg'] = ['msg' => "Este email já esta cadastrado!", 'tipo' => 'danger'];
            }
        }

        if(!empty($this->parametrosPost['CPF']) && $selectResp==false) {
            $selectResp = $usuario->checarCPFJaEstaCadastrado(['CPF' => $this->parametrosPost['CPF']] );
            if(!empty($selectResp)){
                $resp['resp'] = false;
                $resp['boxMsg'] = ['msg' => "Este CPF já esta cadastrado!", 'tipo' => 'danger'];
            }
        }

        $View = new View('cadastro/cadastro.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

}
