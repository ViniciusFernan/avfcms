<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once APP . "/models/menu/dao/MenuDAO.php";
class ChecaMenuCadastradoStrategy
{

    /**
     * checar se existe usuario com esse email
     * @author Antonio Vinicius Fernandes
     */
    public function checaMenuCadastrado($key, $valor, $idExclude = null) {
        try{
            if(empty($key)|| empty($valor)) throw new Exception('Error em processar dados');

            $returnMenu = (new MenuDAO)->checarMenuCadastrado($key, $valor, $idExclude);
            if(!empty($returnMenu) && is_string($returnMenu)) throw new Exception($returnMenu);
            return $returnMenu;
        }catch (Exception $e){
            return $e;
        }
    }
}
