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
 */

require_once ABSPATH . "/models/class/usuario/UsuarioModel.php";

class UsuarioController extends MainController {
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
    public function indexAction(){
        try{
            $listaUsuarios = (new UsuarioModel())->getListaDeUsuarios();
            if($listaUsuarios instanceof  Exception) throw $listaUsuarios;
            if(empty($listaUsuarios)) throw new Exception('Nenhum Usuário Encontrado');

            $this->retorno['usuarios'] = $listaUsuarios;
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
        }


        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }


    public function viewUsuarioEditAction(){
        try{
            if(!empty($this->parametrosPost) && !empty($_SESSION['usuario']) ) $this->editarUsuarioAction();

            $id = ($_SESSION['usuario']->idPerfil==1) ? $this->parametros[0] : $_SESSION['usuario']->idUsuario;
            $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($id);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(empty($dadosUsuario)) throw new Exception('Nenhum Usuário Encontrado');

            $this->retorno['usuario'] = $dadosUsuario[0];
        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function editarUsuarioAction(){
        try{
            if(empty($this->parametrosPost)) throw new Exception('Nenhum Dado Encontrado');

            $dadosUsuario = (new UsuarioModel())->editarUsuario($this->parametrosPost);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(empty($dadosUsuario)) throw new Exception('Nenhum Usuário Encontrado');
            $this->retorno['boxMsg'] = ['msg'=>'Usuário Editado com sucesso', 'tipo'=>'success'];

            //listar usuario
            $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($this->parametrosPost['idUsuario']);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(empty($dadosUsuario)) throw new Exception('Nenhum Usuário Listado');
            $this->retorno['usuario'] = $dadosUsuario[0];

        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
            $this->retorno['usuario'] = (object)$this->parametrosPost;
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function deletarUsuarioAction(){
        try{
            if(empty($this->parametrosPost)) throw new Exception('Nenhum Dado Encontrado');

            $dataSet['idUsuario'] = $this->parametros[0];
            $dataSet['status'] = '0';

            $dadosUsuario = (new UsuarioModel())->editarUsuario($dataSet);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            $this->retorno['boxMsg'] = ['msg'=>'Usuário deletado com sucesso', 'tipo'=>'success'];

        }catch (Exception $e){
            $this->retorno['boxMsg'] = ['msg'=>$e->getMessage(), 'tipo'=>'danger'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function UploadImagemPerfilAction(){
        try{
            $this->checkLogado();
            if (empty($_FILES)) throw new Exception('Arquivo Defeituoso!');

            $optionsImagens['dir'] = UP_ABSPATH."/usuario/{$_SESSION['usuario']->idUsuario}/perfil/";
            $optionsImagens['newName'] = 'img_prefil';
            $optionsImagens['tipoImage'] = 'jpg';

            $optionsImagens['size_x']=300;
            $optionsImagens['size_y']=300;

            $uploadprocessed = Util::cropImagem($optionsImagens, $_FILES['file']);

            if ($uploadprocessed['success']==true){

                $data['idUsuario'] = $_SESSION['usuario']->idUsuario;
                $data['imgPerfil'] = $uploadprocessed['imgName'];

                $userEdit = (new UsuarioModel)->editarUsuario($data);
                if($userEdit instanceof Exception) throw $userEdit;

                $this->retorno = array(
                    "status" => 'success',
                    "url" => UP_URI."/usuario/{$_SESSION['usuario']->idUsuario}/perfil/".$uploadprocessed['imgName']
                );

            }else{
                throw new Exception('Erro ao processar a imagem');
            }

        }catch (Exception $e){
            $this->retorno['error'] = array( "status" => 'error', "msg" => $e->getMessage(), "url" =>'');
        }




        echo json_encode($this->retorno);
    }

}
