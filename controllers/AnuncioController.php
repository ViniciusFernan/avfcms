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
        $this->meusAnunciosAction();
        //echo 'Anuncios';
    }

    public function meusAnunciosAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();
            $id =  $_SESSION['usuario']->idUsuario;

            $dadosAnuncios = (new AnuncioModel())->getListaAnunciosUsuario($id);
            if($dadosAnuncios instanceof Exception) throw $dadosAnuncios;
            if(empty($dadosAnuncios)) throw new Exception('Nenhum anuncio encontrado!');

            $this->retorno['anuncios'] = $dadosAnuncios;
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('anuncio/default.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function criarAnuncioAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();

            if(!empty($this->parametrosPost) && array_filter($this->parametrosPost)>0){
                if( empty(@$this->parametrosPost['tituloAnuncio']) ||
                    empty(@$this->parametrosPost['telefone']) ||
                    empty(@$this->parametrosPost['email']) ||
                    empty(@$this->parametrosPost['cep'])) throw new Exception('Dados Obrigatórios não enviado');

                if(empty($this->parametrosPost['slugAnuncio'])){
                    $this->parametrosPost['slugAnuncio'] = Util::removeAcentos(str_replace(' ', '-', $this->parametrosPost['tituloAnuncio']));
                }

                //validar Slug valido
                $this->parametrosPost['slugAnuncio'] = (new AnuncioModel())->checarCriarSlugValido($this->parametrosPost['slugAnuncio']);


                $dadosAnuncios = (new AnuncioModel())->newAnuncio($this->parametrosPost);
                if($dadosAnuncios instanceof Exception) throw $dadosAnuncios;
                if(empty($dadosAnuncios)) throw new Exception('Erro ao criar anuncio!');

                $this->retorno['boxMsg'] = ['msg'=>'Anuncio criado com sucesso', 'tipo'=>'success'];
                $this->retorno['anuncio'] = $this->parametrosPost;
            }

        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
            $this->retorno['anuncio'] = (object)$this->parametrosPost;
        }

        $View = new View('anuncio/edit.anuncio.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }


    /*******************************************************************************************************************
     *                                  Functions return AJAX
     *******************************************************************************************************************
     * @author  Vinicius Fernandes (AVFWEB.COM.BR)
     * @since  16/11/2019
     * @version 1.0
     ******************************************************************************************************************/


    /**
     * Function consultaCepAction
     * @author  Vinicius Fernandes (AVFWEB.COM.BR)
     * @since  16/11/2019
     * @version 1.0
     */
    public function consultaCepAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();

            if(empty($this->parametrosPost) || empty($_SESSION['usuario']) ) throw new Exception('Erro ao criar anuncio!');

            $dadosCep = Util::getEnderecoPorCep($this->parametrosPost['cep']);
            if($dadosCep instanceof Exception) throw $dadosCep;
            if(empty($dadosCep)) throw new Exception('Erro ao buscar Cep!');

            echo json_encode([ 'type' => 'success', 'cep' => $dadosCep ]);
        } catch (Exception $e){
            echo json_encode(['type' => 'error',  'cep' => '' ]);
        }
    }


}
