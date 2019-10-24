<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/anuncio/AnuncioFactory.php";
require_once ABSPATH . "/models/dao/anuncio/AnuncioDAO.php";

class listaAnuncioPorUsuarioStrategy extends AnuncioFactory {
    
    /**
     * lista de usuario
     * @author Antonio Vinicius Fernandes
     */
    public function listaAnuncio() {
        try{
            $listaAnuncioUsuarios = (new AnuncioDAO)->listarAnuncioPorUsuario();
            if($listaAnuncioUsuarios instanceof Exception) throw $listaAnuncioUsuarios;
            return $listaAnuncioUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

}
