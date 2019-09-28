<?php

/**
 * Controller Usuarios Ajax - Responsável pelas requisicoes ajax das paginas de usuarios
 *
 * Camada - Controladores ou Controllers
 *
 * @package AVF-Framework
 * @author AVF
 * @version 1.0.0
 */
require_once ABSPATH . "/models/class/usuario/UsuarioModel.php";

class RecuperarSenhaController extends MainController {

    public $retorno =[];

    public function __construct() {
        $this->isLogin= false;
    }

    public function indexAction(){
        $View = new View('cadastro/novasenha.view.php');
        $View->showContents();
    }

    public function criarNovaSenhaAction(){

        $post = (!empty($this->parametrosPost) ? $this->parametrosPost : false);

        $user = (new UsuarioModel)->recuperarSenhaDoUsuario($post['email']);

        if(empty($user)){
            $this->retorno['msg'] = 'Erro ao enviar email';
            $this->retorno['tipo'] = 'danger';
        }else if(!empty($user) && $user !=1 ){
            $this->retorno['msg'] = $user;
            $this->retorno['tipo'] = 'danger';
        }else{
            $this->retorno['msg'] = 'Foi enviado para seu email os passos para recuperar sua senha';
            $this->retorno['tipo'] = 'success';
        }

        $View = new View('cadastro/novasenha.view.php');
        $View->addParams('boxMsg', $this->retorno);
        $View->showContents();

    }

}