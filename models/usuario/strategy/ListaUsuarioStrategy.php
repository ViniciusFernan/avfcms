<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/usuario/factory/UsuarioFactory.php";
require_once ABSPATH . "/models/usuario/dao/UsuarioDAO.php";

class ListaUsuarioStrategy extends UsuarioFactory {
    
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
