<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */


class NoticiaModel extends NoticiaFactory {

    /**
     * @param $post
     * Function newNoticia
     * @return bool|Exception|INT
     * @since  03/04/2020
     * @version 1.0
     * @author  Vinicius Fernandes (AVFWEB.COM.BR)
     */
    public function newNoticia($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            $insertResp = (new NovoNoticiaStrategy)->newNoticia($post);
            if($insertResp instanceof Exception) throw  $insertResp;
            return $insertResp;
        }catch (Exception $e){
            return $e;
        }
    }

    public function getListaNoticiasUsuario($idUsuario) {
        try{
            $listaUsuarios = (new ListaNoticiaPorUsuarioStrategy)->listarNoticiaPorUsuario($idUsuario);
            if($listaUsuarios instanceof  Exception) throw $listaUsuarios;
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }


    public function getNoticiasPorId($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new RetornaNoticiaPorIdStrategy)->getNoticia($id);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            return $dadosUsuario;
        }catch (Exception $e){
            return $e;
        }
    }


    public function editNoticias($post){
        try{
            $updateAnuncio = (new  EditarNoticiaStrategy)->editarNoticia($post);
            if($updateAnuncio instanceof Exception) throw $updateAnuncio;

            return $updateAnuncio;
        }catch (Exception $e){
            return $e;
        }
    }

}
