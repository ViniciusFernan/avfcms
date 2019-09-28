<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/anuncio/AnuncioFactory.php";
require_once ABSPATH . "/models/dao/anuncio/AnuncioDAO.php";

class editarAnuncioStrategy extends AnuncioFactory {

    /**
     * Edite usuario
     * @author Antonio Vinicius Fernandes
     * @param $post
     * @return bool|string
     */
    public function editarAnuncio($post){
        try{
            if(empty($post['idAnuncio'])) throw new Exception('Erro identificador do usuario não enviado');

            $idAnuncio=$post['idAnuncio'];
            unset($post['idAnuncio']);

            $updateAnuncio = (new  AnuncioDAO)->editarAnuncio($post, $idAnuncio);
            if(is_string($updateAnuncio) && !empty($updateAnuncio)) throw new Exception($updateAnuncio);

            return $updateAnuncio;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
