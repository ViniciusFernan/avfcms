<?php

/**
 *
 */
class Select extends Conn
{

    private $Select;
    /** @var PDO */
    private $Conn;
    /** @var PDOStatement */
    private $Read;
    private $Places;

    //CONFIG SELECTS
    private $Colunms = [];
    private $Where = [];
    private $join = [];
    private $Group = [];
    private $Having = [];
    private $Order = null;
    private $Limite = '0, 30';

    /* PAGINACAO */
    private $limit;
    private $offset;
    private $paginaAtual;
    private $totalPaginas;
    private $rowCount;
    private $limitBtnPaginacao = 11;

    private function setColunas($colunas)
    {
        try {
            if (!empty($colunas)) :
                $this->Colunms = implode(',', $colunas);
            else :
                $this->Colunms = '*';
            endif;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function setWhere($where)
    {
        try {


        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function setJoin($join)
    {
        try {

        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function setGroup($group)
    {
        try {

        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function getHaving($having)
    {
        try {

        } catch (Exception $exception) {
            return $exception;
        }

    }

}



