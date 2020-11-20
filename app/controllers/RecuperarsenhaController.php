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
require_once APP . "/models/usuario/model/UsuarioModel.php";

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
        try{
            $post = (!empty($this->parametrosPost) ? $this->parametrosPost : false);
            $user = (new AnuncioModel)->recuperarSenhaDoUsuario($post['email']);
            if($user instanceof Exception) throw $user;
            if(empty($user)) throw new Exception('Erro ao enviar email');

            $this->retorno['boxMsg'] = ['msg'=>'Foi enviado para seu email os passos para recuperar sua senha', 'tipo'=>'success'];
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('cadastro/novasenha.view.php');
        $View->setParams($this->retorno);
        $View->showContents();

    }

}