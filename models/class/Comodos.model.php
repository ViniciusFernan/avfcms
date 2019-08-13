<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/dao/Comodos.DAO.php";
class ComodosModel{

    /**
     * Listar comodos
     */
    public function listarComodos() {
        try{

            $listResp = ( new ComodosDAO())->listarComodos();

            if(!empty($listResp) && is_string($listResp))  throw new Exception($listResp);

            return $listResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Ver comodo para edição
     */
    public function dadosEditComodo($idComodo) {
        try{

            $dadosComodo = (new ComodosDAO())->dadosEditComodo($idComodo);

            if(!empty($dadosComodo) && is_string($dadosComodo))  throw new Exception($dadosComodo);

            return $dadosComodo;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
