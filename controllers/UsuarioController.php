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
        $resp = [];
        $listaUsuarios = (new UsuarioModel())->getListaDeUsuarios();
        if(is_string($listaUsuarios) && !empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>$listaUsuarios, 'tipo'=>'danger'];;
        if(empty($listaUsuarios)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuarios'] = $listaUsuarios;

        $View = new View('usuario/default.view.php');
        $View->setParams($resp);
        $View->showContents();
    }


    public function viewUsuarioEditAction(){
        $resp = [];

        $id = ($_SESSION['usuario']->idPerfil==1) ? $this->parametros[0] : $_SESSION['usuario']->idUsuario;
        $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($id);
        if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];
        if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

        $resp['usuario'] = $dadosUsuario[0];

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    public function editarUsuarioAction(){
        $resp = [];

        if(empty($this->parametrosPost)){
            $resp['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{

            $dadosUsuario = (new UsuarioModel())->editarUsuario($this->parametrosPost);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['boxMsg'] = ['msg'=>'Usuário Editado com sucesso', 'tipo'=>'success'];

            //listar usuario
            $dadosUsuario = (new UsuarioModel())->getUsuarioPorId($this->parametrosPost['idUsuario']);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['usuario'] = $dadosUsuario[0];
        }

        $View = new View('usuario/edit.usuario.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    public function deletarUsuarioAction(){
        $resp = [];

        if(empty($this->parametros)){
            $resp['boxMsg'] = ['msg'=>'Nenhum Dado Encontrado', 'tipo'=>'danger'];
        }else{
            $dataSet['idUsuario'] = $this->parametros[0];
            $dataSet['status'] = '0';

            $dadosUsuario = (new UsuarioModel())->editarUsuario($dataSet);
            if(is_string($dadosUsuario) && !empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>$dadosUsuario, 'tipo'=>'danger'];;
            if(empty($dadosUsuario)) $resp['boxMsg'] = ['msg'=>'Nenhum Usuário Encontrado', 'tipo'=>'danger'];

            $resp['boxMsg'] = ['msg'=>'Usuário deletado com sucesso', 'tipo'=>'success'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($resp);
        $View->showContents();
    }

    public function UploadImagemPerfilAction(){

        $this->checkLogado();
        if (empty($_FILES)) exit;

        $optionsImagens['dir'] = UP_ABSPATH."/usuario/{$_SESSION['usuario']['idUsuario']}/perfil/";
        $optionsImagens['newName'] = 'img_prefil';
        $optionsImagens['tipoImage'] = 'jpg';

        $optionsImagens['size_x']=300;
        $optionsImagens['size_y']=300;

        $uploadprocessed = Util::cropImagem($optionsImagens, $_FILES['file']);

        if ($uploadprocessed['success']==true){

            $data['idUsuario'] = $_SESSION['usuario']['idUsuario'];
            $data['imgPerfil'] = $uploadprocessed['msg'];

            $user = new UsuarioModel;
            $user->editarUsuario($data);
            if(empty($user->getResult())){
                $resp = array( "status"=>
                    "error", "url"=>"");
            }

            $resp = array(
                "status" => 'success',
                "url" => UP_ABSPATH."/usuario/{$_SESSION['usuario']['idUsuario']}/perfil/".$uploadprocessed['msg']
            );

        } else {
            $resp['error'] = $uploadprocessed['msg'];
        }


        echo json_encode($resp);
    }

    public function ___Action(){

        $this->checkLogado();
        if (empty($_FILES)) exit;

        $dir = UP_ABSPATH."/usuario/{$_SESSION['usuario']['idUsuario']}/perfil/";
        $newName = 'img_prefil';
        $handle = new upload($_FILES['file']);

        $handle->file_new_name_body  = $newName;
        $handle->image_convert       = 'jpg';
        $handle->image_resize        = true;
        $handle->image_ratio_fill    = true;
        $handle->image_ratio_crop    = true;
        $handle->image_x             = 1030;
        $handle->image_y             = 306;
        $handle->file_overwrite      = true;
        $handle->file_auto_rename    = false;

        $handle->allowed             = array('image/jpeg','image/jpg','image/gif','image/png');
        $handle->process($dir);
        $newImage = $handle->file_dst_name;



        $handle->file_new_name_body  = "menu_".$newName;
        $handle->image_convert       = 'jpg';
        $handle->image_resize        = true;
        $handle->image_ratio_crop    = true;
        $handle->image_x             = 300;
        $handle->image_y             = 135;

        $handle->file_overwrite      = true;
        $handle->file_auto_rename    = false;

        $handle->allowed             = array('image/jpeg','image/jpg','image/gif','image/png');
        $handle->process($dir);

        if ($handle->processed) {

            $data['idUsuario'] = $_SESSION['usuario']['idUsuario'];
            $data['imgCapa'] = $newImage;

            $user = new UsuariosModel;
            $user->editarUsuario($data);
            if(empty($user->getResult())){
                $resp = array(
                    "status" => 'error',
                    "url" => '',
                );
            }

            $resp = array(
                "status" => 'success',
                "url" => UP_ABSPATH."/usuario/{$_SESSION['usuario']['idUsuario']}/perfil/".$newImage,
                "class"=> 'imgCapa',
            );
            $handle->clean();
        } else {
            $resp['error'] = $handle->error;
        }


        echo json_encode($resp);
    }


}
