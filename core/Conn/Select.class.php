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

    /** @var PDO */
    private $Conn;
    /** @var PDOStatement */
    private $ReadPDO;

    private $SelectSql;
    private $Colunms;
    private $Tabela;
    private $Where;
    private $Join;
    private $Group;
    private $Having;

    /* PAGINACAO */
    private $Limit;
    private $offset;
    private $paginaAtual;
    private $totalPaginas;
    private $rowCount;
    private $limitBtnPaginacao = 11;

    public function __construct()
    {
    }


    /**
     * Este metodo dá o start na paginação. Só chamar caso queira paginar o resultado
     * Chamar este metodo depois de instanciar a classe, e antes de efetuar o select
     * @param Number $limit - Limite por Página
     * @param Number $paginaAtual - Página Atual
     */
    public function ExePaginar($paginaAtual, $limit = 50) {
        $paginaAtual = (int) $paginaAtual;
        $limit = (int) $limit;
        $this->paginaAtual = ($paginaAtual ? $paginaAtual : 1);
        $this->Limit = ($limit ? $limit : 50);
    }

    /**
     * Monta a estrutura da paginação em html
     * @param String $linkBase - Ex: http://localhost/?page=
     * @return Array - Estrutura da Paginacao em HTML
     */
    public function getPaginacao($linkBase = "") {
        //valida se existe paginacao
        if (!$this->totalPaginas || $this->totalPaginas == 0)
            return false;

        if ($this->paginaAtual < ceil($this->limitBtnPaginacao / 2))
            $inicial = 1;
        else
            $inicial = $this->paginaAtual - floor($this->limitBtnPaginacao / 2);

        //monta array das paginas e urls
        $links = "";
        $c = 0;
        for ($i = $inicial; $i <= $this->totalPaginas; $i++) {
            $links .= '<li ' . ($this->paginaAtual == $i ? 'class="active"' : "") . '><a href="' . $linkBase . $i . '" data-btn-paginacao="' . $i . '">' . $i . '</a></li>';
            if (++$c >= $this->limitBtnPaginacao)
                break;
        }
        $classLinkAnterior = ($this->paginaAtual == 1 ? "disabled" : NULL);
        $linkPaginaAnterior = (!$classLinkAnterior ? ($this->paginaAtual - 1) : "#");
        $classProximaPagina = ($this->paginaAtual == $this->totalPaginas ? "disabled" : NULL);
        $linkProximaPagina = (!$classProximaPagina ? ($this->paginaAtual + 1) : "#");
        $linkPrimeiraPagina = 1;
        $linkUltimaPagina = $this->totalPaginas;

        $pag = '<div class="text-center" id="paginacao">
                    <nav>
                        <ul class="pagination">
                            <li class="' . $classLinkAnterior . '">
                                <a href="' . $linkBase . $linkPrimeiraPagina . '" aria-label="Previous" data-btn-paginacao="' . $linkPrimeiraPagina . '">
                                    <span aria-hidden="true"><i class="fa fa-fast-backward"></i></span>
                                </a>
                            </li>
                            <li class="' . $classLinkAnterior . '">
                                <a href="' . $linkBase . $linkPaginaAnterior . '" aria-label="Previous" data-btn-paginacao="' . $linkPaginaAnterior . '">
                                    <span aria-hidden="true"><i class="fa fa-backward"></i></span>
                                </a>
                            </li>
                            ' . $links . '
                            <li class="' . $classProximaPagina . '">
                                <a href="' . $linkBase . $linkProximaPagina . '" aria-label="Next" data-btn-paginacao="' . $linkProximaPagina . '">
                                    <span aria-hidden="true"><i class="fa fa-forward"></i></span>
                                </a>
                            </li>
                            <li class="' . $classProximaPagina . '">
                                <a href="' . $linkBase . $linkUltimaPagina . '" aria-label="Next" data-btn-paginacao="' . $linkUltimaPagina . '">
                                    <span aria-hidden="true"><i class="fa fa-fast-forward"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>';

        return $pag;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        if (!empty($this->rowCount))
            return $this->rowCount;
        else
            return $this->ReadPDO->rowCount();
    }

    /**
     * Paginacao
     * @param String $Query SQL
     * @param String $ParseString
     */
    private function pagination($Query, $ParseString = null) {
        try {
            $this->Select = (string) $Query;
            if (!empty($ParseString)):
                parse_str($ParseString, $this->Places);
            endif;

            $this->Connect();

            $this->getSyntax();
            $this->ReadPDO->execute();
            $this->rowCount = $this->ReadPDO->rowCount();

            //Seta a quantidade de itens encontrado na tabela
            $this->rowCount = $this->getRowCount();

            //faz calculo da quantidade de pagina e offset
            $this->totalPaginas = ceil($this->rowCount / $this->limit);
            $this->offset = ($this->paginaAtual * $this->limit) - $this->limit;

        } catch (PDOException $e) {
            return $e;
        }

    }


    /**
     * <b>SELECT:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (ParseString) para executar.
     * @param array $Colunms = colunas pesonalizadas
     * @param STRING $Tabela = Nome da tabela
     * @param array $Where = WHERE [$key => value] bind para
     * @param array $Join
     * @param array $Group
     * @param array $Having
     * @param null $Limit
     */
    public function Select($Colunms = [], $Tabela = null, $Where = [], $Join = [], $Group = [], $Having = [], $Limit = null) {
        try{
            if (empty($Tabela) && !is_string($Tabela)) throw new Exception('Necessário envio de parametros tabela');
            if (empty($Where) && !is_array($Where)) throw new Exception('Necessário envio de parametros para filtro');

            if(!empty($Colunms))  $this->Colunms = $Colunms;
            if(!empty($Tabela))  $this->Tabela = $Tabela;
            if(!empty($Where))  $this->Where = $Where;
            if(!empty($Join))  $this->Join = $Join;
            if(!empty($Group))  $this->Group = $Group;
            if(!empty($Having))  $this->Having = $Having;
            if(!empty($Limit))  $this->Limit = $Limit;

            $this->getSyntax(
                $this->buildColunas($this->Colunms),
                $this->Tabela,
                $this->buildWhere($this->Where),
                $this->buildJoin($this->Join),
                $this->buildHaving($this->Having),
                $this->buildLimit($this->Limit)
            );

            $select = $this->Execute();
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
            if($fullSelect instanceof Exception) throw $fullSelect;

            return $fullSelect;
        }catch (Exception $e){
            return $e;
        }


    }


    /**
     * ********************************************************************************************************************************
     * ***************************************************** PRIVATE METHODS **********************************************************
     * ********************************************************************************************************************************
     */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->ReadPDO = $this->Conn->prepare($this->Select);
        $this->ReadPDO->setFetchMode(PDO::FETCH_ASSOC);
    }

    private function Execute() {
        try {
            $this->Connect();
            $this->setBindValues();
            $this->ReadPDO->execute();

            return $this->ReadPDO->fetchAll( PDO::FETCH_OBJ); //return array objects
        } catch (PDOException $e) {
            return $e;
        }
    }

    private function getSyntax($colunas, $tabela, $where, $join, $having, $limit) {
        $reste = '';
        $this->SelectSql = "SELECT SQL_CALC_FOUND_ROWS 
                            {$colunas}    
                       FROM {$tabela}     
                       WHERE {$where}    
                       {$join} 
                     
                       {$having}   
                       {$limit}";
    }

    private function setBindValues() {
        if ($this->Where):
            foreach ($this->Where as $Vinculo => $Valor):
                $Valor = str_replace("^", "%", $Valor);
                $this->ReadPDO->bindValue(":{$Vinculo}", $Valor, ( is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    private function buildColunas($columns)
    {
        try {
            $colunas =  '*';
            if (!empty($colunas)) :
                $colunas = implode(', ', $columns);
            endif;
            return $colunas;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildWhere($where)
    {
        try {
            if(!empty($where) && !is_array($where)) throw new Exception('Erro em dado enviado WHERE ');
            if(empty($where)) throw new Exception('Sem parametros de busca');

            $partQuery = '';
            $operator = '=';

            foreach ($where as $key => $value):
                $value['type'] = (!empty(@$value['type']) ? $value['type']  : " AND ");
                $value['comparator'] = (!empty(@$value['comparator']) ? $value['comparator']  : $operator);

                $partQuery .= ($key == 0 ? ' ' : $value['type'] ) . $value['field'] . $value['comparator'] .': '. $value['field'];
            endforeach;

            return $partQuery;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildJoin($join)
    {
        try {
            if(!empty($join) && !is_array($join)) throw new Exception('Erro em dado enviado JOIN ');

            if(empty($join)) return null;

            $partQuery = '';
            $operator = '=';

            foreach ($join as $key => $item):

                if(empty(@$item['relacao'])) throw new Exception('Necessário envio do tipo de relação');
                if(empty(@$item['tabela'])) throw new Exception('Necessário envio da tabela do tipo de relação');

                $partQuery .= $item['relacao'] .' '. $item['tabela'] . ' ON ';

                if (isset($item['data'])) :
                    foreach ($item['data'] as $_key => $_dataItem) :
                        if (isset($_dataItem['comparator']) && !empty($_dataItem['comparator'])) $operator = $_dataItem['comparator'];


                        if ($operator == 'OR') :
                            $partQuery .= ($_key > 0 ? ' AND ' : ' ') . $_dataItem['value'];

                        elseif ($operator == 'IS' || $operator == 'IS NOT') :
                            $partQuery .= ($key > 0 ? ' AND ' : ' ') . $_dataItem['field'] . ' ' . $operator . ' ' . $_dataItem['value'];

                        elseif ( $operator == 'LIKE') :
                            $partQuery .= ($key > 0 ? ' AND ' : ' ') . $_dataItem['field'] . ' LIKE '. addslashes($_dataItem['value']) ;

                        endif;

                        if ($operator == 'IN' || $operator == 'NOT IN') :
                            $partQuery .= ($key > 0 ? ' AND ' : ' ') . $_dataItem['field'] . ' '. $operator .'(' . $_dataItem['value'] . ')';

                        else:
                            $partQuery .= ($key > 1 ? ' AND ' : ' ') . $_dataItem['field'] . ' ' . $operator . ' ' . $_dataItem['value'] . ' ';

                        endif;

                    endforeach;
                endif;
            endforeach;

            return $partQuery;
        } catch (Exception $exception) {
            return $exception;
        }
    }

    private function buildGroup($group)
    {
        try {
            return [];
        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function buildHaving($having)
    {
        try {

        } catch (Exception $exception) {
            return $exception;
        }

    }

    private function buildLimit($limit)
    {
        try {
            if(!empty($limit)) return " LIMIT ". $limit;
            else return '';
        } catch (Exception $exception) {
            return $exception;
        }

    }

}



