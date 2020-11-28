<?php

/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genéticas no banco de dados!
 */
class Update extends Conn
{
    /** @var PDO */
    private $Conn;
    private $DestructConn=0;

    private $Table;

    private $DataSet;
    private $Dados;

    private $Where;
    private $Set;

    /** @var PDOStatement */
    private $Update;

    public function __construct($table, $Conn = null)
    {
        try {
            if (empty($table)) throw new Exception('É necessário informar o nome da tabela.');
            $this->Table = $table;

            if($Conn instanceof PDO && is_object($Conn)){
                $this->Conn = $Conn;
            }else{
                $this->DestructConn = 1;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function Update($object = null, $where = null)
    {
        try {

            $respWhere = $this->buildWhere(array_filter($where));
            if ($respWhere instanceof Exception) throw $respWhere;

            //remove todos os atributos vazios
            $respSet = $this->buildSet((object) array_filter((array) $object));
            if ($respSet instanceof Exception) throw $respSet;

            $this->Update = "UPDATE {$this->Table} SET {$this->Set} WHERE {$this->Where}";

            $update = $this->Execute();
            if ($update instanceof Exception) throw $update;
            if (is_string($update) && !empty($update)) throw new Exception($update);

            return $update;

        } catch (Exception $exception) {
            return $exception;
        }
    }


    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect()
    {
        try {
            if(!$this->Conn instanceof PDO)
                $this->Conn = parent::getConn();

            $this->Update = $this->Conn->prepare($this->Update);
        } catch (PDOException $e) {
            if($this->DestructConn==1) $this->Conn->rollBack();

            return $e;
        }
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        try {
            $return = null;
            $this->Connect();
            $this->bindParams();
            $return = $this->Update->execute();
            if($return instanceof Exception) throw $return;

            return $return;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function buildWhere($where)
    {
        try {
            if (!empty($where) && !is_array($where)) throw new Exception('Erro em processar WHERE ');

            if (empty($where)) throw new Exception('Termo de pesquisa inesistente WHERE ');

            $value = ['type' => '', 'alias' => '', 'field' => '', 'value' => '', 'comparation' => ''];

            foreach ($where as $key => $item):
                if (empty(@$item['field']) || empty(@$item['value'])) throw new exception('Erro em field e value WHERE');

                if ($key > 0) $value['type'] = (!empty(@$item['type']) ? strtoupper($item['type']) : "AND");

                $value['alias'] = (!empty(@$item['alias']) ? $item['alias'] . "." : '');
                $value['field'] = $item['field'];
                $value['value'] = $item['value'];
                $value['comparation'] = (!empty(@$item['comparation']) ? $item['comparation'] : '=');

                $this->Where[] = $value['type'] . " " . $value['alias'] . $value['field'] . $value['comparation'] . ':' . $value['field'];
            endforeach;

            $this->Where = implode(' ', $this->Where);
            $this->Dados[$value['field']] = $value['value'];
            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildSet($object)
    {
        try {
            if (empty($object)) throw new Exception('Termo de pesquisa inesistente SET error ');
            if (!is_object($object)) throw new Exception('Tipo de dado inconsistente.');

            foreach ($object as $key => $value):
                $this->Set[] = $key . " =:" . $key;
                $this->DataSet[$key] = $value;
            endforeach;

            $this->Set = implode(', ', $this->Set);
            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }


    private function bindParams()
    {
        try {
            if (empty($this->DataSet) || !is_array($this->DataSet)) throw new Exception('Erro em processar set parametros');
            if (empty($this->Dados) || !is_array($this->Dados)) throw new Exception('Erro em processar parametros');

            $this->Dados = array_merge($this->Dados, $this->DataSet);
            foreach ($this->Dados as $key => $value):
                $this->Update->bindValue(":{$key}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        } catch (Exception $exception) {
            return $exception;
        }
    }

}