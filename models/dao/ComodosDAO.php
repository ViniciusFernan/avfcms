<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class ComodosDAO extends Conn {

    /**
     * lista comodo
     */
    public function listarComodos(){
        $sql="SELECT c.*, cs.nomeStatus FROM comodos c JOIN comodo_status cs ON cs.idStatus = c.status";

        try{
            $select = new Select();
            $listaComodos = $select->FullSelect($sql);
            if (!empty($listaComodos) && is_string($listaComodos)) throw new Exception($listaComodos);
            return $listaComodos;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    /**
     * Dados comodo
     */
    public function dadosEditComodo($idComodo){
        $sql="  SELECT c.*, cs.nomeStatus, cl.idUsuario, u.nome
                FROM comodos c 
                JOIN comodo_status cs ON cs.idStatus = c.STATUS 
                LEFT JOIN comodo_locatario cl ON cl.idComodo = c.idComodo
                LEFT JOIN usuario u ON u.idUsuario = cl.idUsuario
                WHERE c.idComodo=:comodo ";

        try{
            $select = new Select();
            $dadosComodo = $select->FullSelect($sql, "comodo={$idComodo}");
            if (!empty($dadosComodo) && is_string($dadosComodo)) throw new Exception($dadosComodo);
            return $dadosComodo;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
