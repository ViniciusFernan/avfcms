<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";

class getUsuarioStrategy extends UsuarioFactory {

    /**
     * Retorna lista de usuarios
     * @author Antonio Vinicius Fernandes
     */
    public function getUsuario($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new UsuarioDAO)->getUsuarioPorId($id);
            if(!empty($dadosUsuario) && is_string($dadosUsuario)) throw new Exception($dadosUsuario);
            return $dadosUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

}
