<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";
require_once ABSPATH . "/models/strategy/usuario/NovoUsuarioStrategy.php";
require_once ABSPATH . "/models/strategy/usuario/RecuperarSenhaUsuarioStrategy.php";
require_once ABSPATH . "/models/strategy/usuario/listaUsuarioStrategy.php";
require_once ABSPATH . "/models/strategy/usuario/editarUsuarioStrategy.php";
require_once ABSPATH . "/models/strategy/usuario/getUsuarioStrategy.php";


class UsuarioModel extends UsuarioFactory {
    
    /**
     * cadastro de novo usuario
     */
    public function novoUsuario($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            $post["idPerfil"] = 6;

            $insertResp = (new NovoUsuarioStrategy)->novoUsuario($post);
            if($insertResp instanceof Exception) throw  $insertResp;
            return $insertResp;
        }catch (Exception $e){
            return $e;
        }
    }


    /**
     *Recuperar senha
     * criar senha criptografada e envia link por email
     */
    public function recuperarSenhaDoUsuario($email){
        try{
            if(!Util::Email($email) || empty($email)) throw new Exception('Error em processar dados');

            $returnUsuario = (new RecuperarSenhaUsuarioStrategy)->recuperarSenhaDoUsuario($email);
            if($returnUsuario instanceof Exception)  throw $returnUsuario;
            if(empty($returnUsuario)) throw new Exception('Erro grave nesse trem!');
            return (int) $returnUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Retorna lista de usuarios
     */
    public function getListaDeUsuarios() {
        try{
            $listaUsuarios = (new listaUsuarioStrategy)->listaUsuario();
            if($listaUsuarios instanceof Exception) throw $listaUsuarios;
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Retorna lista de usuarios
     */
    public function getUsuarioPorId($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new getUsuarioStrategy)->getUsuario($id);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            return $dadosUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

    public function editarUsuario($post){
        try{
            $updateUsuario = (new  editarUsuarioStrategy)->editarUsuario($post);
            if($updateUsuario instanceof Exception) throw $updateUsuario;

            return $updateUsuario;
        }catch (Exception $e){
            return $e;
        }
    }


}
