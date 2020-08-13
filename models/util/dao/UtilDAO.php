<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class UtilDAO
{

    private $Conn = null;

    public function __construct($Conn = null)
    {
    }

    public function getUtilMenu()
    {
        try {
            $where[] = ['type' => 'and', 'field' => 'status', 'value' => '1', 'comparation' => '='];

            $dataSetMenu = (new Select('menu_backend'))->Select(['*'], $where, '', '', '');
            if ($dataSetMenu instanceof Exception) throw $dataSetMenu;
            if (empty($dataSetMenu)) throw new Exception('Usuario não encontrado!');

            return $dataSetMenu;
        } catch (Exeption $e) {
            return $e;
        }
    }
}
