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
require_once ABSPATH . "/models/class/AnuncioModel.php";

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

    public function meusAnuncios(){
        $this->checkLogado();

        if(empty($_SESSION['usuario']->idUsuario))  $this->page404();

        $id =  $_SESSION['usuario']->idUsuario;

        $dadosAnuncios = (new AnuncioModel())->meusAnunciosLista($id);
        if(is_string($dadosAnuncios) && !empty($dadosAnuncios)) $this->retorno['boxMsg'] = ['msg'=>$dadosAnuncios, 'tipo'=>'danger'];
        if(empty($dadosAnuncios))  $this->retorno['boxMsg'] = ['msg'=>'Nenhum Anuncio Encontrado', 'tipo'=>'danger'];
        else $this->retorno['anuncio'] = $dadosAnuncios;

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function criarAnuncios(){
        $this->checkLogado();

        if(empty($_SESSION['usuario']->idUsuario))  $this->page404();

        $id =  $_SESSION['usuario']->idUsuario;

        $dadosAnuncios = (new AnuncioModel())->criarAnuncios($id);
        if(is_string($dadosAnuncios) && !empty($dadosAnuncios)) $this->retorno['boxMsg'] = ['msg'=>$dadosAnuncios, 'tipo'=>'danger'];
        if(empty($dadosAnuncios))  $this->retorno['boxMsg'] = ['msg'=>'Erro ao criar anuncio', 'tipo'=>'danger'];
        else $this->retorno['boxMsg'] = ['msg'=>'Anuncio criado com sucesso', 'tipo'=>'success'];

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }



}
