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
require_once ABSPATH . "/models/class/anuncio/AnuncioModel.php";

class AnuncioController extends MainController {
    public $retorno =[];

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        echo 'Anuncios';
    }

    public function meusAnunciosAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();
            $id =  $_SESSION['usuario']->idUsuario;

            $dadosAnuncios = (new AnuncioModel())->getListaAnunciosUsuario($id);
            if($dadosAnuncios instanceof Exception) throw $dadosAnuncios;
            if(empty($dadosAnuncios)) throw new Exception('Nenhum anuncio encontrado!');

            $this->retorno['anuncio'] = $dadosAnuncios;
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('anuncio/default.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function criarAnunciosAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();
            $id =  $_SESSION['usuario']->idUsuario;

            $dadosAnuncios = (new AnuncioModel())->criarAnuncios($id);
            if($dadosAnuncios instanceof Exception) throw $dadosAnuncios;
            if(empty($dadosAnuncios)) throw new Exception('Erro ao criar anuncio!');

            $this->retorno['boxMsg'] = ['msg'=>'Anuncio criado com sucesso', 'tipo'=>'success'];
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

}
