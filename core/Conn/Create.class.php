<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 */
class Create extends Conn
{

    /** @var PDO */
    private $Conn;
    private $DestructConn=0;

    private $Table;
    private $Dados;

    private $Fields;
    Private $FieldParamns;

    private $Create;

    public function __construct($table, $Conn = null)
    {
        try {
            if (empty($table)) throw new Exception('É necessário informar o nome da tabela.');
            $this->Table = $table;
            if($Conn instanceof PDO && is_object($Conn)){
                $this->Conn = $Conn;
            }else{
                $this->DestructConn=1;
            }
        } catch (Exception $e) {
            return $e;
        }
    }


    public function Create(array $object)
    {
        try {
            if(!is_object($object) || empty($object)) throw new Exception('Objeto não encontrado!');
            $buildData = $this->buildFileds($object);
            if ($buildData instanceof Exception) throw $buildData;

            $this->Create = "INSERT INTO {$this->Table} ({$this->Fields}) VALUES ({$this->FieldParamns})";

            return $this->Execute();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * *****************************************************************************************************************
     * ********************************************* PRIVATE METHODS ***************************************************
     * *****************************************************************************************************************
     */
    private function Connect()
    {
        try {
            if(!$this->Conn instanceof PDO)
                $this->Conn = parent::getConn();

            $this->Create = $this->Conn->prepare($this->Create);
        }catch (Exception $e){
            if($this->DestructConn==1) $this->Conn->rollBack();

            return $e;
        }
    }


    private function buildFileds($object)
    {
        try {
            if (!empty($object) && !is_object($object)) throw new Exception('Erro em processar dados ');
            if (empty($object)) throw new Exception('Termo de inserção inesistente ');

            foreach ($object as $key => $item):
                $this->Fields[] = $key;
                $this->FieldParamns[] = ":" . $key;
                $this->Dados[$key] = $item;
            endforeach;

            $this->Fields = implode(', ', $this->Fields);
            $this->FieldParamns = implode(', ', $this->FieldParamns);

            return true;
        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function bindParams()
    {
        try {
            if (!empty($this->Dados) || !is_array($this->Dados)) throw new Exception('Erro em processar parametros');
            if (empty($this->Dados)) throw new Exception('Erro em processar parametros');

            foreach ($this->Dados as $key => $value):
                $this->Create->bindValue(":{$key}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        try {
            $retorno = null;
            $this->Connect();

            $this->bindParams();
            $this->Create->execute($this->Dados);

            $retorno = (int)$this->Conn->lastInsertId();
            if($retorno instanceof Exception) throw $retorno;

            return $retorno;
        } catch (PDOException $e) {
            return $e;
        }
    }

}
