<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";
class ChecaCadastroUsuarioStrategy extends UsuarioFactory {

    /**
     * checar se existe usuario com esse email
     * @author Antonio Vinicius Fernandes
     */
    public function checaCadastradoUsuario($key, $valor) {
        try{
            if(empty($key)|| empty($valor)) throw new Exception('Error em processar dados');

            $returnUsuario = (new UsuarioDAO)->checarUsuarioCadastrado($key, $valor);
            if(!empty($returnUsuario) && is_string($returnUsuario)) throw new Exception($returnUsuario);
            return $returnUsuario;
        }catch (Exception $e){
            return $e;
        }
    }

}
