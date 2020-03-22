<?php
/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 */
class Create extends Conn {

    /** @var PDO */
    private $Conn;

    private $Table;
    private $Dados;

    private $Fields;
    Private $FieldParamns;

    private $Create;

    public function __construct($table)
    {
        try {
            if (empty($table)) throw new Exception('É necessário informar o nome da tabela.');
            $this->Table = $table;
        } catch (Exception $e) {
            return $e;
        }
    }


    public function Create(array $Dados) {
        try{
            $this->Dados = $Dados;
            $buildData = $this->buildFileds();
            if($buildData instanceof Exception) throw $buildData;

            $this->Create = "INSERT INTO {$this->Table} ({$this->Fields}) VALUES ({$this->FieldParamns})";

            return $this->Execute();
        }catch (Exception $exception){
            return $exception;
        }
    }

    /**
     * *****************************************************************************************************************
     * ********************************************* PRIVATE METHODS ***************************************************
     * *****************************************************************************************************************
     */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }

    private function buildFileds(){
        try{
            if(!empty($this->Dados) && !is_array($this->Dados)) throw new Exception('Erro em processar dados ');
            if(empty($this->Dados))  throw new Exception('Termo de inserção inesistente ');

            foreach ($this->Dados as $key => $item):
                $this->Fields[] = $key;
                $this->FieldParamns[] = ":".$key;
            endforeach;

            $this->Fields = implode(', ', $this->Fields);
            $this->FieldParamns = implode(', ', $this->FieldParamns);

            return true;
        }catch (Exception $exception){
            return $exception;
        }

    }

    private function bindParams(){
        try{
            if(!empty($this->Dados) || !is_array($this->Dados)) throw new Exception('Erro em processar parametros');
            if(empty($this->Dados)) throw new Exception('Erro em processar parametros');

            foreach ($this->Dados as $key => $value):
                $this->Create->bindValue(":{$key}", $value, ( is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        }catch (Exception $exception){
            return $exception;
        }
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        try {
            $this->Connect();
            $this->bindParams();
            $this->Create->execute($this->Dados);
            return (int)$this->Conn->lastInsertId();
        } catch (PDOException $e) {
            return $e;
        }
    }

}
