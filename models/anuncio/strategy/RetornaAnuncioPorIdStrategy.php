<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/anuncio/factory/AnuncioFactory.php";
require_once ABSPATH . "/models/anuncio/dao/AnuncioDAO.php";

class RetornaAnuncioPorIdStrategy extends AnuncioFactory {

    /**
     * Retorna lista de usuarios
     * @author Antonio Vinicius Fernandes
     */
    public function getAnuncio($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosAnuncio = (new AnuncioDAO)->getAnuncioPorId($id);
            if($dadosAnuncio instanceof Exception) throw $dadosAnuncio;
            return $dadosAnuncio;
        }catch (Exception $e){
            return $e;
        }
    }

}
