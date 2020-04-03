<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/anuncio/factory/AnuncioFactory.php";
require_once ABSPATH . "/models/anuncio/dao/AnuncioDAO.php";
require_once ABSPATH . "/models/anuncio/strategy/ChecaCadastroAnuncioStrategy.php";

class NovoAnuncioStrategy extends AnuncioFactory {
    
    /**
     * cadastro de novo usuario
     * @author Antonio Vinicius Fernandes
     */
    public function novoAnuncio($post) {
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Preencha o formulário!');

            if(@empty($post['slugAnuncio'])) throw new exception('Erro em processar dados ');

            $checkSlug = (new ChecaCadastroAnuncioStrategy)->checaCadastradoUsuario( $post['slugAnuncio']);
            if(!empty($checkSlug))
                throw new Exception("Já existe um cadastro com o Slug {$post['slugAnuncio']} no sistema");

            unset($post["idAnuncio"]);
            $post["status"] = 1 ;

            $insertResp = (new AnuncioDAO)->inserirNovoAnuncio($post);
            if($insertResp instanceof Exception) throw $insertResp;

            return $insertResp;
        }catch (Exception $e){
            return $e;
        }
    }

}
