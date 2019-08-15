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
class RecuperarSenhaController extends MainController {
    public function indexAction(){
        $View = new View('cadastro/novasenha.view.php');
        $View->showContents();
    }

    public function criarNovaSenhaAction(){

        $resp=[];
        $post = (!empty($this->parametrosPost) ? $this->parametrosPost : false);

        if(empty($post['email'])){
            $resp['tipo'] = 'danger';
            $resp['msg'] = 'Favor preencer email';
            echo json_encode($resp);
            exit;
        }

        require ABSPATH.'/models/usuarios/Usuarios.model.php';
        $update = new UsuariosModel();
        $user = $update->buscarUsuarioPorEmail($this->parametrosPost['email']);




        echo json_encode($resp);
        exit;
    }

}