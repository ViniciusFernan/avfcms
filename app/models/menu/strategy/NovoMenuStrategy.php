<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */
require_once APP . "/models/menu/dao/MenuDAO.php";
require_once APP . "/models/menu/strategy/ChecaMenuCadastradoStrategy.php";

class NovoMenuStrategy
{
    
    /**
     * @author Antonio Vinicius Fernandes
     */
    public function novoMenu($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            if( empty($post['nome']) ) throw new Exception('Dado obrigatório não informado [Nome]');
            if( empty($post['controller']) ) throw new Exception('Dado obrigatório não informado [controller]');

            $idMenu = (!empty($post['idMenu'])? $post['idMenu']: null);
            $checkEmail = (new ChecaMenuCadastradoStrategy)->checaMenuCadastrado('nome', $post['nome'], $idMenu);
            if(!empty($checkEmail)) throw new Exception('Já existe um menu cadastrado com esse nome');

            $checkEmail = (new ChecaMenuCadastradoStrategy)->checaMenuCadastrado('controller', $post['controller'], $idMenu);
            if(!empty($checkEmail)) throw new Exception('Já existe um menu cadastrado com esse controller');

            $post["dataCadastro"] = date('Y-m-d H:i:s');
            $post["status"] = 1 ;

            unset($post['idMenu']);

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $post;
        }catch (Exception $e){
            return $e;
        }
    }

}
