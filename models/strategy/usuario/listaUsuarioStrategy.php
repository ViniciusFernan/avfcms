<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";

class listaUsuarioStrategy extends UsuarioFactory {
    
    /**
     * lista de usuario
     * @author Antonio Vinicius Fernandes
     */
    public function listaUsuario() {
        try{
            $listaUsuarios = (new UsuarioDAO)->getListaDeUsuarios();
            if(!empty($listaUsuarios) && is_string($listaUsuarios)) throw new Exception($listaUsuarios);
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

}
