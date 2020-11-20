<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once APP . "/models/anuncio/factory/AnuncioFactory.php";
require_once APP . "/models/anuncio/dao/AnuncioDAO.php";

class ChecaCadastroAnuncioStrategy extends AnuncioFactory {

    /**
     * checar se existe usuario com esse email
     * @author Antonio Vinicius Fernandes
     */
    public function checaCadastradoUsuario($slugAnuncio, $idAnuncio=null) {
        try{
            if(empty($slugAnuncio)) throw new Exception('Error em processar dados');

            $returnAnuncio = (new AnuncioDAO)->checarAnuncioSlugCadastrado($slugAnuncio, $idAnuncio);
            if($returnAnuncio instanceof Exception) throw $returnAnuncio;

            return $returnAnuncio;
        }catch (Exception $e){
            return $e;
        }
    }

}