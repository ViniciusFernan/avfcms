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
require_once ABSPATH . "/models/class/usuario/UsuarioModel.php";

class CadastroController extends MainController {
    public $retorno =[];
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
        $error = false;

        $usuario = new AnuncioModel;

        $insertResp = $usuario->novoUsuario($this->parametrosPost);
        if(empty($insertResp) && !is_int($insertResp) ) {
            unset($this->parametrosPost["senha"]);
            $this->retorno=['msg' => "Erro ao cadastrar usuário!", 'tipo' => 'danger'];
            $error = true;
        }else if(!empty($insertResp) && !is_int($insertResp) ){
            $this->retorno=['msg' => $insertResp, 'tipo' => 'danger'];
            $error = true;
        }else{
            $this->retorno['resp'] = $insertResp;
            $this->retorno=['msg'=>"Usuário cadastrado com sucesso!", 'tipo'=>'success'];
            $error = false;
        }


        $View = new View('cadastro/cadastro.view.php');
        $View->addParams('boxMsg', $this->retorno);
        $View->addParams('post', $this->parametrosPost);
        $View->showContents();
    }


    /***********************************   AJAX   ********************************************/
    public function checarSeUsuariosJaExisteAjaxAction(){
        $usuario = new AnuncioModel;

        if(!empty($this->parametrosPost['email'])) {
            $selectResp = $usuario->checarEmailJaEstaCadastrado(['email' => $this->parametrosPost['email']] );
            if(!empty($selectResp)){
                $this->retorno['resp'] = false;
                $this->retorno['boxMsg'] = ['msg' => "Este email já esta cadastrado!", 'tipo' => 'danger'];
            }
        }

        if(!empty($this->parametrosPost['CPF']) && $selectResp==false) {
            $selectResp = $usuario->checarCPFJaEstaCadastrado(['CPF' => $this->parametrosPost['CPF']] );
            if(!empty($selectResp)){
                $this->retorno['resp'] = false;
                $this->retorno['boxMsg'] = ['msg' => "Este CPF já esta cadastrado!", 'tipo' => 'danger'];
            }
        }

        $View = new View('cadastro/cadastro.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

}
