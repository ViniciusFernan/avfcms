<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class AnuncioDAO extends Conn {


    /**
     * inserir novos anuncios
     * @param $post
     * @return bool|INT
     * @throws Exception
     */
    public function inserirNovoAnuncio($post){
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $anuncioCreate = (new Create)->ExeCreate('anuncio', $post);
            if($anuncioCreate instanceof Exception) throw $anuncioCreate;

            return $anuncioCreate;
        }catch(Exeption $e){
            return $e;
        }

    }

    public function editarAnuncio($Data, $idAnuncio){
        try{
            if(!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

            unset($Data['idAnuncio']);

            $updateAnuncio = (new Update)->ExeUpdate('anuncio', $Data, 'WHERE idAnuncio=:idAnuncio', "idAnuncio={$idAnuncio}");
            if($updateAnuncio instanceof Exception) throw $updateAnuncio;
            if(empty($updateAnuncio)) throw new Exception('Ops, erro ao atualizar usuario');

            return true;
        }catch (Exception $e){
            return $e;
        }

    }

    public function getAnuncioPorId($id) {
        try{
            if(empty($id)) throw new Exception('Erro identificador do anuncio não enviado');

            $select = new Select();
            $dadosAnuncio = $select->ExeRead('anuncio', "WHERE idAnuncio=:id", "id={$id}");
            if($dadosAnuncio instanceof Exception) throw $dadosAnuncio;
            if(empty($dadosAnuncio)) throw new Exception('Não achou nada nesse trem!');

            return $dadosAnuncio;
        }catch(Exeption $e){
            return $e;
        }
    }

    public function checarAnuncioSlugCadastrado($slugAnuncio){
        try{
            if(empty($slugAnuncio) )
                throw new Exception('Error grave nesse trem');

            $select = new Select();
            $dadosAnuncio = $select->ExeRead('anuncio', "WHERE slugAnuncio=:slugAnuncio", "slugAnuncio={$slugAnuncio}");
            if($dadosAnuncio instanceof Exception) throw $dadosAnuncio;
            if(!empty($dadosAnuncio)):
                return true;
            else:
                return false;
            endif;
        }catch(Exeption $e){
            return $e;
        }

    }

    public function listarAnuncioPorUsuario($idUsuario){
        try{
            if(empty($idUsuario) )
                throw new Exception('Error grave nesse trem');

            $select = new Select();
            $dadosAnuncio = $select->ExeRead('anuncio', "WHERE idUsuario=:idUsuario", "idUsuario={$idUsuario}");
            if($dadosAnuncio instanceof Exception) throw $dadosAnuncio;
            if(!empty($dadosAnuncio)):
                return true;
            else:
                return false;
            endif;
        }catch(Exeption $e){
            return $e;
        }
    }



}
