<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";

class editarUsuarioStrategy extends UsuarioFactory {

    public function editarUsuario($post){
        try{

            if(empty($post['idUsuario'])) throw new Exception('Erro identificador do usuario não enviado');

            $idUsuario=$post['idUsuario'];
            unset($post['idUsuario']);

            if(!empty($post['senha'])) $post['senha'] = Util::encriptaSenha($post['senha']);
            else unset($post['senha']);

            $updateUsuario = (new  UsuarioDAO)->editarUsuario($post, $idUsuario);
            if(is_string($updateUsuario) && !empty($updateUsuario)) throw new Exception($updateUsuario);

            return $updateUsuario;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
