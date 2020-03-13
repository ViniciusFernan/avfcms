<?php
/**
 * <b>Read.class:</b>
 * Classe responsável por leituras genéticas no banco de dados!
 *
 * <b>Para Executar select sem Paginação:</b>
 * 1 - Instanciar a classe Select
 * 2 - Executar a Seleção com ExeRead ou FullSelect
 * 4 - Executar getResult() para receber os valores
 *
 * <b>Para Executar select com paginacao:</b>
 * 1 - Instanciar a classe Select
 * 2 - Executar o "ExePaginar"
 * 3 - Executar a Seleção com ExeRead ou FullSelect
 * 4 - Executar getResult() para receber os valores
 * 5 - Executar a "getPaginacao" para receber a paginação em html
 * e transferir para a View
 *
 * Observações:
 * 1 - getResult() = false - quando não haver itens.
 * 2 - Execute setPlaces($ParseString) e logo apos getResult para fazer
 * nova consulta com valores diferentes
 *
 */
class Select extends Conn {

    /** @var PDOStatement */
    private $Read;
    private $Table;

    /** @var PDO */
    private $Conn;

    private $Select;
    private $Columns;
    private $Where;
    private $Parse;
    private $Join;
    private $Group;
    private $Having;

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
     * <b>Exe Read:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (ParseString) para executar.
     * @param array $Colunas
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $ParseString = link={$link}&link2={$link2}
     * @param array $Join
     * @return array|string
     */
    public function Select($Colunas=null, $where = null,  $Join = null, $limit = '0,50',  $having=null) {
        try{

            $respColumns = $this->buildColumns($Colunas);
            if($respColumns instanceof Exception) throw $respColumns;

            $respJoin = $this->buildJoin($Join);
            if($respJoin instanceof Exception) throw $respJoin;

            $respWhere = $this->buildWhere($where);
            if($respWhere instanceof Exception) throw $respWhere;

            $this->Select = "SELECT SQL_CALC_FOUND_ROWS 
                    {$this->Columns} 
                    FROM {$this->Table}  
                    {$this->Join}
                    WHERE {$this->Where} 
                    LIMIT {$limit}";

            $select = $this->Execute();
            if($select instanceof Exception) throw $select;
            if(is_string($select) && !empty($select)) throw new Exception($select);

            return $select;
        }catch (Exception $e){
            return $e;
        }

    }

    /**
     * <b>Full Select: Executa leitura com a sql completa montada da forma que for necessária</b>
     * @param String $Query - A string Select com Prepared Statments
     * @param String $ParseString - Passa os parametro em forma de url
     */
    public function FullSelect($Query, $ParseString = null) {

        try{
            if ($ParseString)
                $ParseString = str_replace("%", "^", $ParseString);

            $limit='';
            $this->Select = (string) $Query . $limit;
            if (!empty($ParseString)):
                parse_str($ParseString, $this->Places);
            endif;
            $fullSelect = $this->Execute();
            if(is_string($fullSelect) && !empty($fullSelect)) throw new Exception($fullSelect);

            return $fullSelect;
        }catch (Exception $e){
            return $e->getMessage();
        }


    }


    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }


    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        try {
            $this->Connect();
            $this->bindParams();
            $this->Read->execute();
            return $this->Read->fetchAll( PDO::FETCH_OBJ); //return array objects
        } catch (PDOException $e) {
           return $e;
        }
    }

    private function bindParams(){
        try{
            if(empty($this->Parse) || !is_array($this->Parse)) throw new Exception('Erro em processar parametros');

            foreach ($this->Parse as $key => $value):
                $this->Read->bindValue(":{$key}", $value, ( is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        }catch (Exception $exception){
            return $exception;
        }
    }

    private function buildColumns($columns)
    {
        try {
            if(!empty($columns) && !is_array($columns)) throw new Exception('Erro au processar COLUMNS ');

            $this->Columns = '*';
            if(!empty($columns) && is_array($columns)) $this->Columns = implode(', ', $columns);

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildJoin($joins)
    {
        try {
            if(!empty($joins) && !is_array($joins)) throw new Exception('Erro em processar JOINS ');

            if(empty($joins)) return '';

            $this->Join = '';

            foreach ($joins as $key => $item):
                $this->Join  .= $item ."\n";
            endforeach;

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildWhere($where)
    {
        try {
            if(!empty($where) && !is_array($where)) throw new Exception('Erro em processar WHERE ');

            if(empty($where))  throw new Exception('Termo de pesquisa inesistente WHERE ');

            $value = ['type'=>'', 'alias'=>'', 'field'=>'', 'value'=>'', 'comparation'=>''];

            foreach ($where as $key => $item):
                if(empty(@$item['field']) || empty(@$item['value'])) throw new exception('Erro em field e value WHERE');

                if($key>0) $value['type'] = (!empty(@$item['type']) ? strtoupper($item['type'])  : "AND");

                $value['alias'] = (!empty(@$item['alias']) ? $item['alias']."."  : '');
                $value['field'] = $item['field'];
                $value['value'] = $item['value'];
                $value['comparation'] = (!empty(@$item['comparation']) ? $item['comparation']  : '=');

                $this->Where[] = $value['type']." ".$value['alias'].$value['field'] . $value['comparation'] .':'. $value['field'];
                $this->Parse[$value['field']] = $value['value'] ;
            endforeach;

            $this->Where = implode(' ', $this->Where);

            return true;
        } catch (Exception $exception) {
            return $exception;
        }
    }

}
