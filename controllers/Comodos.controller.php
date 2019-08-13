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
require_once ABSPATH . "/models/class/Comodos.model.php";
require_once ABSPATH . "/models/class/Usuario.model.php";
class ComodosController extends MainController {

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct(){
        $this->checkLogado();
        if($_SESSION['usuario']['idPerfil']!=1){

            $View = new View('PermissaoNegada.view.php');
            $View->showContents();
        }
    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction() {
        $this->listarComodosAction();
    }

    public function listarComodosAction() {
        $boxMsg=[];

        $listaComodos = (new ComodosModel())->listarComodos();
        if(empty($listaComodos) && is_string($listaComodos))  $boxMsg=['msg' => "Erro ao buscar comodos", 'tipo' => 'danger'];

        if(empty($listaComodos) && is_string($listaComodos))  $boxMsg=['msg' => "Erro comodos não encontrados", 'tipo' => 'danger'];

        $View = new View('comodos/listarComodos.view.php');
        $View->addParams('boxMsg', $boxMsg);
        $View->addParams('lista', $listaComodos);
        $View->showContents();
    }

    public function verComodoAction(){
        $boxMsg=[];
        $dadosComodo = [];
        $listaLocatarios=[];

        if (!empty($this->parametros)) {
            $dadosComodo = (new ComodosModel())->dadosEditComodo($this->parametros[0]);
            $listaLocatarios = (new UsuarioModel())->getListaDeLocatarios();
            if(empty($dadosComodo) && is_string($dadosComodo))  $boxMsg=['msg' => "Erro ao buscar comodos", 'tipo' => 'danger'];

            if(empty($dadosComodo) && is_string($dadosComodo))  $boxMsg=['msg' => "Erro comodos não encontrados", 'tipo' => 'danger'];
        }else{
            $boxMsg=['msg' => "Erro comodo não encontrados", 'tipo' => 'danger'];
        }

        pre($listaLocatarios);

        $View = new View('comodos/editarComodo.view.php');
        $View->addParams('boxMsg', $boxMsg);
        $View->addParams('dadosComodo', $dadosComodo);
        $View->addParams('locatarios', $listaLocatarios);
        $View->showContents();
    }

}
