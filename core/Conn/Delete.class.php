<?php
/**
 * <b>Delete.class:</b>
 * Classe responsável por deletar genéricamente no banco de dados!
 */
class Delete extends Conn {

    private $Tabela;
    private $Termos;
    private $Places;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;

    public function ExeDelete($Tabela, $Termos, $ParseString) {
        try {
            $this->Tabela = (string)$Tabela;
            $this->Termos = (string)$Termos;
            parse_str($ParseString, $this->Places);
            $this->getSyntax();
            $this->Execute();
        }catch (Exception $e){
            return $e;
        }
    }

    public function getRowCount() {
        return $this->Delete->rowCount();
    }

    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        try {
            $this->Connect();
            $this->Delete->execute($this->Places);
           return true;
        } catch (PDOException $e) {
            return  $e;
        }
    }

}
