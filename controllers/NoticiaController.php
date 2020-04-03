<?php


require_once ABSPATH . "/models/noticia/model/NoticiaModel.php";

/**
 * Class AnuncioController
 * @author  Vinicius Fernandes (AVFWEB.COM.BR)
 * @since  03/04/2020
 * @version 1.0
 */
class NoticiaController extends MainController {
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
        $this->minhasNoticiasAction();
    }

    public function minhasNoticiasAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();
            $id =  $_SESSION['usuario']->idUsuario;

            $dadosNoticia = (new NoticiaModel())->getListaAnunciosUsuario($id);
            if($dadosNoticia instanceof Exception) throw $dadosNoticia;
            if(empty($dadosNoticia)) throw new Exception('Nenhuma noticia encontrado!');

            $this->retorno['noticia'] = $dadosNoticia;
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('noticia/default.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function viewNoticiaAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();
            if(!empty($this->parametrosPost) && empty(@$this->parametrosPost['idNoticia'] )&& !empty($_SESSION['usuario']) ){
                $this->criarNoticiaAction();
            }
            if(!empty($this->parametrosPost) && !empty(@$this->parametrosPost['idNoticia'] )&& !empty($_SESSION['usuario']) ){
                $this->editarNoticiaAction();
            }

            if(!empty($this->parametros[0])){
                $dadosNoticia = (new AnuncioModel())->getNoticiaPorId($this->parametros[0]);
                if($dadosNoticia instanceof Exception ) throw $dadosNoticia;
                if(empty($dadosNoticia)) throw new Exception('Nenhuma noticia Encontrada');
                $this->retorno['noticia'] = $dadosNoticia[0];
            }else{
                $this->page404();
            }
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
            $this->retorno['noticia'] = '';
        }

        $View = new View('noticia/edit.noticia.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function criarNoticiaAction(){
        try{
            $this->checkLogado();
            if(empty($_SESSION['usuario']->idUsuario))  $this->page404();

            if(!empty($this->parametrosPost) && array_filter($this->parametrosPost)>0){
                if( empty(@$this->parametrosPost['titulo']) || empty(@$this->parametrosPost['texto'])){
                    throw new Exception('Dados Obrigatórios não enviado');
                }

                $this->parametrosPost['idUsuario']=$_SESSION['usuario']->idUsuario;

                $dadosNoticia = (new NoticiaModel())->newAnuncio($this->parametrosPost);
                if($dadosNoticia instanceof Exception) throw $dadosNoticia;
                if(empty($dadosNoticia)) throw new Exception('Erro ao criar noticia!');

                $this->retorno['boxMsg'] = ['msg'=>'Noticia criado com sucesso', 'tipo'=>'success'];
                $this->retorno['anuncio'] = (object)$this->parametrosPost;
            }

        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=> $e->getMessage(), 'tipo'=>'danger'];
            $this->retorno['noticia'] = (object)$this->parametrosPost;
        }

        $View = new View('noticia/edit.noticia.view.php');
        $View->setParams( $this->retorno);
        $View->showContents();
    }

    public function editarNoticiaAction(){
        try{
            if(empty($this->parametrosPost)) throw new Exception('Nenhum Dado Encontrado');

            $dadosNoticia = (new NoticiaModel())->editNoticia($this->parametrosPost);
            if($dadosNoticia instanceof Exception) throw $dadosNoticia;
            if(empty($dadosNoticia)) throw new Exception('Nenhuma noticia Encontrada');
            $this->retorno['boxMsg'] = ['msg'=>'Noticia Editada com sucesso', 'tipo'=>'success'];

            //get anuncio
            $dadosNoticia=null;
            $dadosNoticia = (new NoticiaModel())->getnoticiaPorId($this->parametrosPost['idNoticia']);
            if($dadosNoticia instanceof Exception) throw $dadosNoticia;
            if(empty($dadosNoticia)) throw new Exception('Nenhum dado encontrado');
            $this->retorno['noticia'] = $dadosNoticia[0];

        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
            $this->retorno['noticia'] = (object)$this->parametrosPost;
        }

        $View = new View('noticia/edit.noticia.view.php');
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
    public function salvarThumbNoticiaAction(){
        try{
            $this->checkLogado();
            if (empty($_FILES)) throw new Exception('Arquivo Defeituoso!');

            $optionsImagens['dir'] = UP_ABSPATH."/noticias/{$this->parametrosPost['idNoticia']}";
            $optionsImagens['newName'] = 'img_capa';
            $optionsImagens['tipoImage'] = 'jpg';

            $optionsImagens['size_x']=300;
            $optionsImagens['size_y']=300;

            $uploadprocessed = Util::cropImagem($optionsImagens, $_FILES['file']);

            if ($uploadprocessed['success']==false)
                throw new Exception('Erro ao processar a imagem');

            $data['idNoticia'] = $this->parametrosPost['idNoticia'];
            $data['imgCapa'] = $uploadprocessed['imgName'];

            $dataEdit = (new NoticiaModel())->editNoticia($data);
            if($dataEdit instanceof Exception) throw $dataEdit;

            echo json_encode([
                "status" => 'success',
                "url" => UP_URI."/noticia/{$this->parametrosPost['idNoticia']}/".$uploadprocessed['imgName']
            ]);

        }catch (Exception $e){
            echo json_encode( [ "status" => 'error', "msg" => $e->getMessage(), "url" =>''] );
        }
    }


}
