<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";
require_once ABSPATH . "/models/strategy/usuario/ChecaCadastroUsuarioStrategy.php";

class NovoUsuarioStrategy extends UsuarioFactory {
    
    /**
     * cadastro de novo usuario
     */
    public function novoUsuario($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            if(empty($post['nome']) || empty($post['email']) || empty($post['CPF']) || empty($post['senha']) || empty($post['dataNascimento']))
                throw new Exception('Dados obrigatórios não informados');

            if(!empty($post['CPF']) && Util::CPF($post['CPF'])==FALSE )
                throw new Exception('CPF informado é invalido');

            $checkEmail = (new ChecaCadastroUsuarioStrategy)->checaCadastradoUsuario('email', $post['email']);
            if(!empty($checkEmail))
                throw new Exception('Email já cadastrado!');

            $checkCPF = (new ChecaCadastroUsuarioStrategy)->checaCadastradoUsuario('CPF', $post['CPF']);
            if(!empty($checkCPF))
                throw new Exception('CPF já cadastrado!');

            $post["idPerfil"] = (!empty($post["idPerfil"])? $post["idPerfil"] : 6);
            $post["senha"] = Util::encriptaSenha($post['senha']);
            $post["dataNascimento"] = Util::DataToDate($post['dataNascimento']);
            $post["dataCadastro"] = date('Y-m-d H:i:s');
            $post["status"] = 1 ;

            $insertResp = (new UsuarioDAO)->insertNewUser($post);

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
