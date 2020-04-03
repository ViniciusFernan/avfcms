<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/usuario/factory/UsuarioFactory.php";
require_once ABSPATH . "/models/usuario/dao/UsuarioDAO.php";

class EditarUsuarioStrategy extends UsuarioFactory {

    /**
     * Edite usuario
     * @author Antonio Vinicius Fernandes
     * @param $post
     * @return bool|string
     */
    public function editarUsuario($post){
        try{

            if(empty($post['idUsuario'])) throw new Exception('Erro identificador do usuario não enviado');

            $idUsuario=$post['idUsuario'];
            unset($post['idUsuario']);

            if(!empty($post['senha'])) $post['senha'] = Util::encriptaSenha($post['senha']);
            else unset($post['senha']);

            $updateUsuario = (new  UsuarioDAO)->editarUsuario($post, $idUsuario);
            if($updateUsuario instanceof Exception) throw $updateUsuario;

            return $updateUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

}
