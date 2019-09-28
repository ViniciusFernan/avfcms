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
        $listaUsuarios = (new AnuncioModel())->getListaDeUsuarios();
        if(is_string($listaUsuarios) && !empty($listaUsuarios)) $this->retorno['boxMsg'] = ['msg'=>$listaUsuarios, 'tipo'=>'danger'];
        else if(empty($listaUsuarios)) $this->retorno['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];
        else $this->retorno['usuarios'] = $listaUsuarios;

        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }


    public function viewUsuarioEditAction(){

        $id = ($_SESSION['usuario']->idPerfil==1) ? $this->parametros[0] : $_SESSION['usuario']->idUsuario;
        $dadosUsuario = (new AnuncioModel())->getUsuarioPorId($id);
        if(is_string($dadosUsuario) && !empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];
        else if(empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];
        else $this->retorno['usuario'] = $dadosUsuario[0];

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function editarUsuarioAction(){

        if(empty($this->parametrosPost)){
            $this->retorno['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{

            $dadosUsuario = (new AnuncioModel())->editarUsuario($this->parametrosPost);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];
            else $this->retorno['boxMsg'] = ['msg'=>'Usuário Editado com sucesso', 'tipo'=>'success'];

            //listar usuario
            $dadosUsuario = (new AnuncioModel())->getUsuarioPorId($this->parametrosPost['idUsuario']);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];
            else $this->retorno['usuario'] = $dadosUsuario[0];
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function deletarUsuarioAction(){

        if(empty($this->parametros)){
            $this->retorno['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{
            $dataSet['idUsuario'] = $this->parametros[0];
            $dataSet['status'] = '0';

            $dadosUsuario = (new AnuncioModel())->editarUsuario($dataSet);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $this->retorno['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];
            else $this->retorno['boxMsg'] = ['msg'=>'Usuário deletado com sucesso', 'tipo'=>'success'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function UploadImagemPerfilAction(){

        $this->checkLogado();
        if (empty($_FILES)) exit;

        $optionsImagens['dir'] = UP_ABSPATH."/usuario/{$_SESSION['usuario']->idUsuario}/perfil/";
        $optionsImagens['newName'] = 'img_prefil';
        $optionsImagens['tipoImage'] = 'jpg';

        $optionsImagens['size_x']=300;
        $optionsImagens['size_y']=300;

        $uploadprocessed = Util::cropImagem($optionsImagens, $_FILES['file']);

        if ($uploadprocessed['success']==true){

            $data['idUsuario'] = $_SESSION['usuario']->idUsuario;
            $data['imgPerfil'] = $uploadprocessed['msg'];

            $userEdit = (new AnuncioModel)->editarUsuario($data);

            if(empty($userEdit)) $this->retorno = array( "status"=> "error", "url"=>"");
            if(!empty($userEdit) && !is_int($userEdit)) $this->retorno = array( "status"=> "error", "url"=>"");
            else $this->retorno = array(
                "status" => 'success',
                "url" => UP_URI."/usuario/{$_SESSION['usuario']->idUsuario}/perfil/".$uploadprocessed['msg']
            );

        } else {
            $this->retorno['error'] = $uploadprocessed['msg'];
        }

        echo json_encode($this->retorno);
    }

}
