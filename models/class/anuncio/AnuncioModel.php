<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/anuncio/AnuncioFactory.php";
require_once ABSPATH . "/models/dao/anuncio/AnuncioDAO.php";
require_once ABSPATH . "/models/strategy/anuncio/NovoAnuncioStrategy.php";
require_once ABSPATH . "/models/strategy/anuncio/listaAnuncioPorUsuarioStrategy.php";
require_once ABSPATH . "/models/strategy/anuncio/ChecaCadastroAnuncioStrategy.php";


class AnuncioModel extends AnuncioFactory {
    
    /** cadastro de novo anuncio */
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
            $listaUsuarios = (new listaAnuncioPorUsuarioStrategy)->listarAnuncioPorUsuario($idUsuario);
            if($listaUsuarios instanceof  Exception) throw $listaUsuarios;
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

    /** Retorna anuncio  */
    public function getAnuncioPorId($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new getAnuncioStrategy)->getAnuncio($id);
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
            $updateUsuario = (new  editarAnuncioStrategy)->editarUsuario($post);
            if($updateUsuario instanceof Exception) throw $updateUsuario;

            return $updateUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

    public function checarCriarSlugValido($slug, $idAnuncio=null){
        try{
            if(empty($slug)) throw new Exception('Erro ao gerar slug valido, tentar novamente.');
            $idAnuncio = (!empty($idAnuncio) ? $idAnuncio : null);
            $i = '';

            $checaCadastroAnuncioStrategy = new ChecaCadastroAnuncioStrategy();

            $slugRetorno = false;
            while($slugRetorno == false){
                $slugRetorno = $checaCadastroAnuncioStrategy->checaCadastradoUsuario($slug, $idAnuncio);
                if($slugRetorno instanceof Exception ) throw $slugRetorno;

                if($slugRetorno == true){
                    $slug = (empty($i)? $slug : $slug.'-'.$i);
                    $i++;
                }

                if($i==10){ break;}
            }
            return $slug;
        }catch (Exception $e){
            return $e;
        }

    }

}
