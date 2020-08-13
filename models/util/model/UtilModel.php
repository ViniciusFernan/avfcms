<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */
require_once ABSPATH . "/models/util/dao/UtilDAO.php";

class UtilModel
{
    public function getUtilMenu(){
        try{

            $dataSetMenu = (new UtilDAO)->getUtilMenu();
            if($dataSetMenu instanceof Exception) throw $dataSetMenu;
            if(!empty($dataSetMenu) && is_string($dataSetMenu)) throw new Exception($dataSetMenu);
            return $dataSetMenu;

        }catch (Exception $e){
            return $e;
        }
    }
}