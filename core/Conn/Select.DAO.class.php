<?php
/**
 *
 */
class Select extends Conn {

    private $Select;
    /** @var PDO */
    private $Conn;
    /** @var PDOStatement */
    private $Read;
    private $Places;

    //CONFIG SELECTS
    private $Colunms=[];
    private $Where=[];
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
        $this->limit = ($limit ? $limit : 50);
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
     * <b>Exe Read:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function ExeRead($Tabela, $Termos = null, $ParseString = null) {
        try{
            if ($ParseString)
                $ParseString = str_replace("%", "^", $ParseString);

            $limit = "";
            if (!empty($ParseString)):
                parse_str($ParseString, $this->Places);
            endif;

            $sql = "SELECT * FROM {$Tabela} {$Termos} {$limit}";
            $this->Select = $sql;
            $select = $this->Execute();
            if(is_string($select) && !empty($select)) throw new Exception($select);

            return $select;
        }catch (Exception $e){
            return $e;
        }

    }


    /**
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        if (!empty($this->rowCount))
            return $this->rowCount;
        else
            return $this->Read->rowCount();
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
     * <b>Full Read:</b> Executa leitura de dados via query que deve ser montada manualmente para possibilitar
     * seleção de multiplas tabelas em uma única query!
     * @param STRING $Query = Query Select Syntax
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function setPlaces($ParseString) {
        try{
            parse_str($ParseString, $this->Places);
            $setPlaces = $this->Execute();
            if($setPlaces instanceof Exception) throw $setPlaces;
            return $setPlaces;
        }catch (Exception $e){
            return $e;
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

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $Valor = str_replace("^", "%", $Valor);
                $this->Read->bindValue(":{$Vinculo}", $Valor, ( is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        try {
            $this->Connect();
            $this->getSyntax();
            $this->Read->execute();

            return $this->Read->fetchAll( PDO::FETCH_OBJ); //return array objects
        } catch (PDOException $e) {
           return $e;
        }
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
            $this->Read->execute();
            $this->rowCount = $this->Read->rowCount();

            //Seta a quantidade de itens encontrado na tabela
            $this->rowCount = $this->getRowCount();

            //faz calculo da quantidade de pagina e offset
            $this->totalPaginas = ceil($this->rowCount / $this->limit);
            $this->offset = ($this->paginaAtual * $this->limit) - $this->limit;

        } catch (PDOException $e) {
            return $e;
        }

    }

}



