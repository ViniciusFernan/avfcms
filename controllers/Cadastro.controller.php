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

        $post["idPerfil"] = 6 ;
        $post["nome"] = (!empty($this->parametrosPost['nome']) ? $this->parametrosPost['nome'] : NULL );
        $post["sobreNome"] = (!empty($this->parametrosPost['sobreNome']) ? $this->parametrosPost['sobreNome'] : NULL );
        $post["email"] = (!empty($this->parametrosPost['email']) ? $this->parametrosPost['email'] : NULL );
        $post["telefone"] = (!empty($this->parametrosPost['telefone']) ? $this->parametrosPost['telefone'] : NULL );
        $post["CPF"] = (!empty($this->parametrosPost['CPF']) ? $this->parametrosPost['CPF'] : NULL );
        $post["senha"] = (!empty($this->parametrosPost['senha']) ? Util::encriptaSenha($this->parametrosPost['senha']) : NULL );
        $post["dataNascimento"] = (!empty($this->parametrosPost['dataNascimento']) ? Util::DataToDate($this->parametrosPost['dataNascimento']) : NULL );
        $post["sexo"] = (!empty($this->parametrosPost['sexo']) ? $this->parametrosPost['sexo'] : NULL );
        $post["dataCadastro"] = date('Y-m-d H:i:s');
        $post["detalhes"] = (!empty($this->parametrosPost['detalhes']) ? $this->parametrosPost['detalhes'] : NULL );
        $post["status"] = 1 ;

        $usuario = new UsuarioModel;


        $insertResp = $usuario->novoUsuario($post);
        if(empty($insertResp) && !is_int($insertResp) ) {
            unset($post["idPerfil"], $post["senha"]);
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


    public function novasenhaAction() {
        $View = new View('cadastro/novasenha.view.php');
        $View->showContents();
    }

}
