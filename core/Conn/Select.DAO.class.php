<?php

/**
 *
 */
class Select extends Conn
{
    //$where[]['data'] = ['comparison' => '=', 'field' => 'cpp.id_comissao_data_corte', 'value' => $dsParam['idComissaoDataCorte']];

    //$join[] = [
    //'tipoRelacao' => 'JOIN',
    //'tabela' => 'pedidos_compra_beneficios',
    //'data' => [
    //['comparison' => '=', 'field' => 'pedido_compra_pendencia_2_via.id_pedido_compra_beneficio', 'value' => 'pedidos_compra_beneficios.id']
    //]
    //];


    private $Select = 'SELECT ';
    private $SqlFoundRows = 'SQL_CALC_FOUND_ROWS';

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
            if(!empty($join) && !is_array($join)) throw new Exception('Erro em dado enviado ');

            $partQuery = '';

            foreach ($join as $key => $item)
                {
                    $partQuery .= ' ' . $item['relacao'];
                    $partQuery .= ' ' . $item['tabela'];

                    if (isset($item['data']))
                    {
                        $countFiltrosAux = 0;
                        foreach ($item['data'] as $_key => $_dataItem)
                        {
                            if ( isset($_array['in'])  || isset($_array['notin']) || isset($_array['like'])) throw new Exception('Sem valores para realizar a pesquisa do JOIN.');

                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' ON' : '');

                            $operator = '=';

                            if (isset($_array['comparison']))
                            {
                                $operator = $_array['comparison'];
                            }

                            if (isset($_array['in']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' IN (' . $_array['value'] . ')';
                            }
                            else if (isset($_array['notin']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' NOT IN (' . $_array['value'] . ')';
                            }
                            else if (isset($_array['like']))
                            {
                                if (isset($_array['like']['order']))
                                {
                                    $porcentagemComeco = ($_array['like']['order'] == 'front' ? '%' : '');
                                    $porcentagemFim = ($_array['like']['order'] == 'back' ? '%' : '');
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' LIKE \'' . $porcentagemComeco . addslashes($_array['value']) . $porcentagemFim . '\'';
                                }
                                else
                                {
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' LIKE \'%' . addslashes($_array['value']) . '%\'';
                                }
                            }
                            else if ($operator == 'IS' || $operator == 'IS NOT')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' ' . $operator . ' ' . $_array['value'];
                            }
                            else if ($operator == 'OR')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['value'];
                            }
                            else
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $_array['field'] . ' ' . $operator . ' ' . $_array['value'] . ' ';
                            }
                        }
                    }
                }



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



