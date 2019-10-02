<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/anuncio/AnuncioFactory.php";
require_once ABSPATH . "/models/dao/anuncio/AnuncioDAO.php";
require_once ABSPATH . "/models/strategy/anuncio/ChecaCadastroAnuncioStrategy.php";

class NovoAnuncioStrategy extends AnuncioFactory {
    
    /**
     * cadastro de novo usuario
     * @author Antonio Vinicius Fernandes
     */
    public function novoAnuncio($post) {
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Preencha o formulário!');


            $checkSlug = (new ChecaCadastroAnuncioStrategy)->checaCadastradoUsuario( $post['slugAnuncio']);
            if(!empty($checkSlug))
                throw new Exception("Já existe um cadastro com o Slug {$post['slugAnuncio']} no sistema");

            $post["dataCadastro"] = date('Y-m-d H:i:s');
            $post["status"] = 1 ;

            $insertResp = (new AnuncioDAO)->inserirNovoAnuncio($post);

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
