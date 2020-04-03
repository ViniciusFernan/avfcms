<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/anuncio/factory/AnuncioFactory.php";
require_once ABSPATH . "/models/anuncio/dao/AnuncioDAO.php";
require_once ABSPATH . "/models/anuncio/strategy/NovoAnuncioStrategy.php";
require_once ABSPATH . "/models/anuncio/strategy/ListaAnuncioPorUsuarioStrategy.php";
require_once ABSPATH . "/models/anuncio/strategy/ChecaCadastroAnuncioStrategy.php";
require_once ABSPATH . "/models/anuncio/strategy/RetornaAnuncioPorIdStrategy.php";
require_once ABSPATH . "/models/anuncio/strategy/EditarAnuncioStrategy.php";


class AnuncioModel extends AnuncioFactory {
    
    /**
     * cadastro de novo anuncio
     */
    public function newAnuncio($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            $insertResp = (new NovoAnuncioStrategy)->novoAnuncio($post);
            if($insertResp instanceof Exception) throw  $insertResp;
            return $insertResp;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Retorna lista de anuncios do usuario logado
     */
    public function getListaAnunciosUsuario($idUsuario) {
        try{
            $listaUsuarios = (new ListaAnuncioPorUsuarioStrategy)->listarAnuncioPorUsuario($idUsuario);
            if($listaUsuarios instanceof  Exception) throw $listaUsuarios;
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Retorna anuncio
     */
    public function getAnuncioPorId($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new RetornaAnuncioPorIdStrategy)->getAnuncio($id);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            return $dadosUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Editar anuncio
     * @param $post
     * @return bool|string
     */
    public function editAnuncio($post){
        try{
            $updateAnuncio = (new  EditarAnuncioStrategy)->editarAnuncio($post);
            if($updateAnuncio instanceof Exception) throw $updateAnuncio;

            return $updateAnuncio;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * @param $slug
     * @param null $idAnuncio
     * @return Exception|string
     * @since 19/12/2019
     * @author Antonio Vinicius Fernandes
     */
    public function checarCriarSlugValido($slug, $idAnuncio=null){
        try{
            if(empty($slug)) throw new Exception('Erro ao gerar slug valido, tentar novamente.');
            $idAnuncio = (!empty($idAnuncio) ? $idAnuncio : null);
            $i = '';

            $checaCadastroAnuncioStrategy = new ChecaCadastroAnuncioStrategy();

            $slugRetorno='';
            for( $i=1; $i<=10 ; $i++){
                $slugRetorno = $checaCadastroAnuncioStrategy->checaCadastradoUsuario($slug, $idAnuncio);
                if($slugRetorno instanceof Exception ) throw $slugRetorno;

                if($slugRetorno == false) { break; }

                $slug = (empty($i) ? $slug : $slug . '-' . $i);
            }
            return $slug;
        }catch (Exception $e){
            return $e;
        }

    }

}
