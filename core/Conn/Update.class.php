<?php
/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genéticas no banco de dados!
 */
class Update extends Conn {

    private $Table;
    private $Dados;
    private $Termos;
    private $Places;

    /** @var PDOStatement */
    private $Update;

    /** @var PDO */
    private $Conn;

    public function __construct($table)
    {
        try {
            if (empty($table)) throw new Exception('É necessário informar o nome da tabela.');
            $this->Table = $table;
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * <b>Exe Update:</b> Executa uma atualização simplificada com Prepared Statments. Basta informar o
     * nome da tabela, os dados a serem atualizados em um Attay Atribuitivo, as condições e uma
     * analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param ARRAY $Dados = [ NomeDaColuna ] => Valor ( Atribuição )
     * @param STRING $Termos = WHERE coluna = :link AND.. OR..
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function Update($dados = null, $where = null) {
        $this->Dados = $dados;
        $this->Termos = (string) $where;

        $this->getSyntax();
        return $this->Execute();
    }



    /**
     * <b>Contar Registros: </b> Retorna o número de linhas alteradas no banco!
     * @return INT $Var = Quantidade de linhas alteradas
     */
    public function getRowCount() {
        return $this->Update->rowCount();
    }

    /**
     * <b>Modificar Links:</b> Método pode ser usado para atualizar com Stored Procedures. Modificando apenas os valores
     * da condição. Use este método para editar múltiplas linhas!
     * @param STRING $ParseString = id={$id}&..
     */
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
        $this->Update = $this->Conn->prepare($this->Update);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        foreach ($this->Dados as $Key => $Value):
            $Places[] = $Key . ' = :' . $Key;
        endforeach;

        $null = array_search('NULL', $this->Dados, true);
        if ($null)
            $this->Dados[$null] = NULL;

        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        try {
            $this->Connect();
            $this->Update->execute(array_merge($this->Dados, $this->Places));
           return $this->getRowCount();
        } catch (PDOException $e) {
           return $e;
        }
    }

}
