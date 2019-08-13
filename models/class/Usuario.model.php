<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/dao/Usuario.DAO.php";
class UsuarioModel{

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


            $checkEmail = $this->checarEmailJaEstaCadastrado(['email' => $post['email']] );
            if(!empty($checkEmail))
                throw new Exception('Email já cadastrado!');

            $checkCPF = $this->checarCPFJaEstaCadastrado(['CPF' => $post['CPF']] );
            if(!empty($checkCPF))
                throw new Exception('CPF já cadastrado!');

            $insertResp = (new UsuarioDAO)->insertNewUser($post);

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * checar se existe usuario com esse email
     */
    public function checarEmailJaEstaCadastrado($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Error em processar dados');

            $insertResp = (new UsuarioDAO)->checarEmailJaEstaCadastrado($post);
            if(!empty($insertResp) && is_string($insertResp)) throw new Exception($insertResp);
            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * checar se existe usuario com esse email
     */
    public function checarCPFJaEstaCadastrado($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Error em processar dados');

            $insertResp = (new UsuarioDAO)->checarCPFJaEstaCadastrado($post);
            if(!empty($insertResp) && is_string($insertResp)) throw new Exception($insertResp);
            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * retorna lista de locatarios ativos
     */
    public function getListaDeLocatarios() {
        try{

            $listaDeLocatarios = (new UsuarioDAO)->getListaDeLocatarios();
            if(!empty($listaDeLocatarios) && is_string($listaDeLocatarios)) throw new Exception($listaDeLocatarios);
            return $listaDeLocatarios;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
