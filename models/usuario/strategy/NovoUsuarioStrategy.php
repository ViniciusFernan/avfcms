<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/usuario/factory/UsuarioFactory.php";
require_once ABSPATH . "/models/usuario/dao/UsuarioDAO.php";
require_once ABSPATH . "/models/usuario/strategy/ChecaCadastroUsuarioStrategy.php";

class NovoUsuarioStrategy extends UsuarioFactory {
    
    /**
     * cadastro de novo usuario
     * @author Antonio Vinicius Fernandes
     */
    public function novoUsuario($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            if( empty($post['nome']) ) throw new Exception('Dado obrigatório não informado [Nome]');
            if( empty($post['email']) ) throw new Exception('Dado obrigatório não informado [Email]');
            if( empty($post['senha']) ) throw new Exception('Dado obrigatório não informado [Senha]');
            if( empty($post['dataNascimento']) ) throw new Exception('Dado obrigatório não informado [Data de Nascimento]');
            if( empty($post['sexo']) ) throw new Exception('Dado obrigatório não informado [Sexo]');
            if( empty($post['CPF']) ) throw new Exception('Dado obrigatório não informado [CPF]');

            if(!empty($post['CPF']) && Util::CPF($post['CPF'])==FALSE ) throw new Exception('CPF informado é invalido');

            $checkEmail = (new ChecaCadastroUsuarioStrategy)->checaCadastradoUsuario('email', $post['email']);
            if(!empty($checkEmail)) throw new Exception('Email já cadastrado!');

            $checkCPF = (new ChecaCadastroUsuarioStrategy)->checaCadastradoUsuario('CPF', $post['CPF']);
            if(!empty($checkCPF)) throw new Exception('CPF já cadastrado!');

            $post["idPerfil"] = (!empty($post["idPerfil"])? $post["idPerfil"] : 6);
            $post["senha"] = Util::encriptaSenha($post['senha']);
            $post["dataNascimento"] = Util::DataToDate($post['dataNascimento']);
            $post["dataCadastro"] = date('Y-m-d H:i:s');
            $post["sexo"] = $post['sexo'];
            $post["idPerfil"] = 6;
            $post["status"] = 1 ;

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $post;
        }catch (Exception $e){
            return $e;
        }
    }

}
