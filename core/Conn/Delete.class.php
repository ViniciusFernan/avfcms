<?php

/**
 * <b>Delete.class:</b>
 * Classe responsável por deletar genéricamente no banco de dados!
 */
class Delete extends Conn
{


    /** @var PDO */
    private $Conn;
    private $Table;
    private $Where;
    private $Parse;
    private $Delete;

    public function __construct($table)
    {
        try {
            if (empty($table)) throw new Exception('É necessário informar o nome da tabela.');
            $this->Table = $table;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function Delete($where)
    {
        try {

            $respWhere = $this->buildWhere($where);
            if ($respWhere instanceof Exception) throw $respWhere;

            $this->Delete = "DELETE FROM {$this->Table} WHERE {$this->Termos}";
            $this->Execute();
        } catch (Exception $e) {
            return $e;
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
            $this->Conn = parent::getConn();
            $this->Delete = $this->Conn->prepare($this->Delete);
        } catch (PDOException $e) {
            return $e;
        }
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        try {
            $this->Connect();
            $this->bindParams();
            $this->Delete->execute();
            return true;
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function bindParams()
    {
        try {
            if (empty($this->Parse) || !is_array($this->Parse)) throw new Exception('Erro em processar parametros');

            foreach ($this->Parse as $key => $value):
                $this->Delete->bindValue(":{$key}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        } catch (Exception $exception) {
            return $exception;
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
                $this->Parse[$value['field']] = $value['value'];
            endforeach;

            $this->Where = implode(' ', $this->Where);

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }

}
