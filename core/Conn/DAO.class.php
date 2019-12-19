<?php

class DAO
{
    private $table = null;
    private $dataBase = null;

    public function __construct($table, $dataBase)
    {
        $this->table = $table;
        $this->dataBase = $dataBase;

        try
        {
            if (Validacoes::isNullOrEmpty($this->table))
            {
                throw new Exception('É necessário informar o nome da tabela.');
            }
            else if (Validacoes::isNullOrEmpty($this->dataBase))
            {
                throw new Exception('É necessário fornecer a conexão com o banco de dados.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }

    public function select($filtros, $colunas = null, $group = null, $having = null, $order = null, $limite = null, $join = null)
    {
        try
        {
            $data = null;

            if (is_array($filtros))
            {
                $countFiltros = Utilidade::contarArray($filtros);

                if ($countFiltros > 0)
                {
                    $query = 'SELECT ';

                    if (!Validacoes::isNullOrEmpty($colunas))
                    {
                        $colunasArray = implode(',', $colunas);

                        $query .= $colunasArray;
                    }
                    else
                    {
                        $query .= '*';
                    }

                    $query .= ' FROM ' . $this->table;

                    if (isset($join))
                    {
                        foreach ($join as $key => $array)
                        {
                            $query .= ' ' . $array['tipoRelacao'];
                            $query .= ' ' . $array['tabela'];

                            if (isset($array['data']))
                            {
                                $countFiltrosAux = 0;
                                foreach ($array['data'] as $_key => $_array)
                                {
                                    if (Validacoes::isNullOrEmpty($_array['value'], 'zero') && (isset($_array['in']) || isset($_array['notin']) || isset($_array['like']))) throw new Exception('Sem valores para realizar a pesquisa do JOIN.');

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
                    }

                    if (isset($filtros[0]['data']))
                    {
                        $countFiltrosAux = 0;
                        foreach ($filtros as $key => $array)
                        {
                            if (Validacoes::isNullOrEmpty($array['data']['value'], 'zero') && (isset($array['data']['in']) || isset($array['data']['notin']) || isset($array['data']['like']))) throw new Exception('Sem valores para realizar a pesquisa do WHERE.');

                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' WHERE' : '');

                            $operator = '=';

                            if (isset($array['data']['comparison']))
                            {
                                if ($array['data']['comparison'] == 'lt')
                                {
                                    $operator = '>=';
                                }
                                else if ($array['data']['comparison'] == 'gt')
                                {
                                    $operator = '<=';
                                }
                                else if ($array['data']['comparison'] == 'eq')
                                {
                                    $operator = '=';
                                }
                                else
                                {
                                    $operator = $array['data']['comparison'];
                                }
                            }

                            if (isset($array['data']['in']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['notin']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' NOT IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['like']))
                            {
                                if (isset($array['data']['like']['order']))
                                {
                                    $porcentagemComeco = ($array['data']['like']['order'] == 'front' ? '%' : '');
                                    $porcentagemFim = ($array['data']['like']['order'] == 'back' ? '%' : '');
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'' . $porcentagemComeco . addslashes($array['data']['value']) . $porcentagemFim . '\'';
                                }
                                else
                                {
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'%' . addslashes($array['data']['value']) . '%\'';
                                }
                            }
                            else if ($operator == 'IS' || $operator == 'IS NOT')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' ' . $operator . ' ' . $array['data']['value'];
                            }
                            else if ($operator == 'OR')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['value'];
                            }
                            else
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . $operator . '\'' . $array['data']['value'] . '\'';
                            }
                        }
                    }
                    else
                    {
                        $countFiltrosAux = 0;
                        foreach ($filtros as $key => $value)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' WHERE' : '');
                            $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $key . ' = \'' . $value . '\'';
                        }
                    }

                    if (!Validacoes::isNullOrEmpty($group))
                    {
                        $countFiltrosAux = 0;
                        foreach ($group as $key)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' GROUP BY' : '');
                            $query .= ($countFiltrosAux > 1 ? ', ' : ' ') . $key;
                        }
                    }

                    if (isset($having[0]['data']))
                    {
                        $countFiltrosAux = 0;
                        foreach ($having as $key => $array)
                        {
                            if (Validacoes::isNullOrEmpty($array['data']['value'], 'zero') && (isset($array['data']['in']) || isset($array['data']['notin']) || isset($array['data']['like']))) throw new Exception('Sem valores para realizar a pesquisa do HAVING.');

                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' HAVING' : '');

                            $operator = '=';

                            if (isset($array['data']['comparison']))
                            {
                                if ($array['data']['comparison'] == 'lt')
                                {
                                    $operator = '>=';
                                }
                                else if ($array['data']['comparison'] == 'gt')
                                {
                                    $operator = '<=';
                                }
                                else if ($array['data']['comparison'] == 'eq')
                                {
                                    $operator = '=';
                                }
                                else
                                {
                                    $operator = $array['data']['comparison'];
                                }
                            }

                            if (isset($array['data']['in']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['notin']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' NOT IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['like']))
                            {
                                if (isset($array['data']['like']['order']))
                                {
                                    $porcentagemComeco = ($array['data']['like']['order'] == 'front' ? '%' : '');
                                    $porcentagemFim = ($array['data']['like']['order'] == 'back' ? '%' : '');
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'' . $porcentagemComeco . addslashes($array['data']['value']) . $porcentagemFim . '\'';
                                }
                                else
                                {
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'%' . addslashes($array['data']['value']) . '%\'';
                                }
                            }
                            else if ($operator == 'IS' || $operator == 'IS NOT')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' ' . $operator . ' ' . $array['data']['value'];
                            }
                            else if ($operator == 'OR')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['value'];
                            }
                            else
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . $operator . '\'' . $array['data']['value'] . '\'';
                            }
                        }
                    }
                    else
                    {
                        if (!Validacoes::isNullOrEmpty($having))
                        {
                            $countFiltrosAux = 0;
                            foreach ($having as $key => $value)
                            {
                                $countFiltrosAux++;
                                $query .= ($countFiltrosAux == 1 ? ' HAVING' : '');
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $key . ' = \'' . $value . '\'';
                            }
                        }
                    }

                    if (!Validacoes::isNullOrEmpty($order))
                    {
                        $countFiltrosAux = 0;
                        foreach ($order as $key => $value)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' ORDER BY' : '');
                            $query .= ($countFiltrosAux > 1 ? ', ' : ' ') . $key . ' ' . $value;
                        }
                    }

                    if (!Validacoes::isNullOrEmpty($limite))
                    {
                        $limiteArray = explode(',', $limite);

                        $query .= ' LIMIT ' . $limiteArray[0] . ',' . $limiteArray[1];
                    }

                    $sql = $this->dataBase->prepare($query);
                    $sql->execute();

                    $arrayErrorSQL = $sql->errorInfo();

                    if (Utilidade::contarArray($arrayErrorSQL) > 0 && $arrayErrorSQL[0] != '00000')
                    {
                        $sql = null;

                        throw new Exception($arrayErrorSQL[2]);
                    }
                    else
                    {
                        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
                        if ($rows !== null)
                        {
                            foreach ($rows as $key => $value)
                            {
                                $auxiliar = null;
                                foreach ($value as $chave => $valor)
                                {
                                    $auxiliar[$chave] = Utilidade::utf8DecodeToUpperToPHP($valor);
                                }

                                $data[$key] = $auxiliar;
                            }
                        }

                        $sql = null;

                        return $data;
                    }
                }
                else
                {
                    throw new Exception('Sem parâmetros para realizar a pesquisa.');
                }
            }
            else
            {
                throw new Exception('Parâmetro inválido para realizar a consulta.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }

    public function selectExtJS($filtros, $filter = null, $columns = null, $start = 0, $limit = 120, $sort = 'id', $dir = 'ASC', $having = null, $group = null, $join = null)
    {
        try
        {
            $data = null;

            if (is_array($filtros))
            {
                $countFiltros = Utilidade::contarArray($filtros);

                if ($countFiltros > 0)
                {
                    $query = 'SELECT SQL_CALC_FOUND_ROWS ';

                    if (!Validacoes::isNullOrEmpty($columns))
                    {
                        $colunasArray = implode(',', $columns);

                        $query .= $colunasArray;
                    }
                    else
                    {
                        $query .= '*';
                    }

                    $query .= ' FROM ' . $this->table;

                    if (isset($join))
                    {
                        foreach ($join as $key => $array)
                        {
                            $query .= ' ' . $array['tipoRelacao'];
                            $query .= ' ' . $array['tabela'];

                            if (isset($array['data']))
                            {
                                $countFiltrosAux = 0;
                                foreach ($array['data'] as $_key => $_array)
                                {
                                    if (Validacoes::isNullOrEmpty($_array['value'], 'zero') && (isset($_array['in']) || isset($_array['notin']) || isset($_array['like']))) throw new Exception('Sem valores para realizar a pesquisa do JOIN.');

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
                    }

                    if (isset($filtros[0]['data']))
                    {
                        $countFiltrosAux = 0;
                        foreach ($filtros as $key => $array)
                        {
                            if (Validacoes::isNullOrEmpty($array['data']['value'], 'zero') && (isset($array['data']['in']) || isset($array['data']['notin']) || isset($array['data']['like']))) throw new Exception('Sem valores para realizar a pesquisa do WHERE.');

                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' WHERE' : '');

                            $operator = '=';

                            if (isset($array['data']['comparison']))
                            {
                                $operator = $array['data']['comparison'];
                            }

                            if (isset($array['data']['in']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['notin']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' NOT IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['like']))
                            {
                                if (isset($array['data']['like']['order']))
                                {
                                    $porcentagemComeco = ($array['data']['like']['order'] == 'front' ? '%' : '');
                                    $porcentagemFim = ($array['data']['like']['order'] == 'back' ? '%' : '');
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'' . $porcentagemComeco . addslashes($array['data']['value']) . $porcentagemFim . '\'';
                                }
                                else
                                {
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'%' . addslashes($array['data']['value']) . '%\'';
                                }
                            }
                            else if ($operator == 'IS' || $operator == 'IS NOT')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' ' . $operator . ' ' . $array['data']['value'];
                            }
                            else if ($operator == 'OR')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['value'];
                            }
                            else
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . $operator . '\'' . $array['data']['value'] . '\'';
                            }
                        }
                    }
                    else
                    {
                        $countFiltrosAux = 0;
                        foreach ($filtros as $key => $value)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' WHERE' : '');
                            $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $key . ' = \'' . $value . '\'';
                        }
                    }

                    if (!Validacoes::isNullOrEmpty($filter))
                    {
                        foreach ($filter as $key => $array)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' WHERE' : '');

                            if ($array['data']['type'] == 'string' && !Validacoes::isNullOrEmpty($array['data']['value'], 'zero'))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['field'] . ' LIKE \'%' . addslashes($array['data']['value']) . '%\'';
                            }
                            else if ($array['data']['type'] == 'int' || $array['data']['type'] == 'numeric')
                            {
                                if ($array['data']['comparison'] == 'lt')
                                {
                                    $operator = '<=';
                                }
                                else if ($array['data']['comparison'] == 'gt')
                                {
                                    $operator = '>=';
                                }
                                else if ($array['data']['comparison'] == 'eq')
                                {
                                    $operator = '=';
                                }

                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['field'] . ' ' . $operator . '\'' . $array['data']['value'] . '\'';
                            }
                            else if ($array['data']['type'] == 'date')
                            {
                                $likeAux = '';

                                if ($array['data']['comparison'] == 'lt')
                                {
                                    $operator = '<';
                                }
                                else if ($array['data']['comparison'] == 'gt')
                                {
                                    $operator = '>';
                                }
                                else if ($array['data']['comparison'] == 'eq')
                                {
                                    $operator = 'like';
                                    $likeAux = '%';
                                }
                                else if ($array['data']['comparison'] == '<=')
                                {
                                    $operator = $array['data']['comparison'];
                                }
                                else if ($array['data']['comparison'] == '>=')
                                {
                                    $operator = $array['data']['comparison'];
                                }


                                $value = '\'' . $likeAux . Utilidade::dateFormat('Y-m-d', $array['data']['value']) . $likeAux . '\'';

                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['field'] . ' ' . $operator . ' ' . $value;
                            }
                        }
                    }

                    if (!Validacoes::isNullOrEmpty($group))
                    {
                        $countFiltrosAux = 0;
                        foreach ($group as $key)
                        {
                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' GROUP BY' : '');
                            $query .= ($countFiltrosAux > 1 ? ', ' : ' ') . $key;
                        }
                    }


                    if (isset($having[0]['data']))
                    {
                        $countFiltrosAux = 0;
                        foreach ($having as $key => $array)
                        {
                            if (Validacoes::isNullOrEmpty($array['data']['value'], 'zero') && (isset($array['data']['in']) || isset($array['data']['notin']) || isset($array['data']['like']))) throw new Exception('Sem valores para realizar a pesquisa do HAVING.');

                            $countFiltrosAux++;
                            $query .= ($countFiltrosAux == 1 ? ' HAVING' : '');

                            $operator = '=';

                            if (isset($array['data']['comparison']))
                            {
                                $operator = $array['data']['comparison'];
                            }

                            if (isset($array['data']['in']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['notin']))
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' NOT IN (' . $array['data']['value'] . ')';
                            }
                            else if (isset($array['data']['like']))
                            {
                                if (isset($array['data']['like']['order']))
                                {
                                    $porcentagemComeco = ($array['data']['like']['order'] == 'front' ? '%' : '');
                                    $porcentagemFim = ($array['data']['like']['order'] == 'back' ? '%' : '');
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'' . $porcentagemComeco . addslashes($array['data']['value']) . $porcentagemFim . '\'';
                                }
                                else
                                {
                                    $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' LIKE \'%' . addslashes($array['data']['value']) . '%\'';
                                }
                            }
                            else if ($operator == 'IS' || $operator == 'IS NOT')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . ' ' . $operator . ' ' . $array['data']['value'];
                            }
                            else if ($operator == 'OR')
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['value'];
                            }
                            else
                            {
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $array['data']['field'] . $operator . '\'' . $array['data']['value'] . '\'';
                            }
                        }
                    }
                    else
                    {
                        if (!Validacoes::isNullOrEmpty($having))
                        {
                            $countFiltrosAux = 0;
                            foreach ($having as $key => $value)
                            {
                                $countFiltrosAux++;
                                $query .= ($countFiltrosAux == 1 ? ' HAVING' : '');
                                $query .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $key . ' = \'' . $value . '\'';
                            }
                        }
                    }

                    $query .= ' ORDER BY ' . $sort . ' ' . $dir;

                    if (!Validacoes::isNullOrEmpty($start, 'zero') && !Validacoes::isNullOrEmpty($limit, 'zero')) $query .= ' LIMIT ' . $start . ',' . $limit;

                    $sql = $this->dataBase->prepare($query);
                    $sql->execute();

                    $arrayErrorSQL = $sql->errorInfo();

                    if (Utilidade::contarArray($arrayErrorSQL) > 0 && $arrayErrorSQL[0] != '00000')
                    {
                        $sql = null;

                        throw new Exception($arrayErrorSQL[2]);
                    }
                    else
                    {
                        $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
                        if ($rows !== null)
                        {
                            foreach ($rows as $key => $value)
                            {
                                $auxiliar = null;
                                foreach ($value as $chave => $valor)
                                {
                                    $auxiliar[$chave] = Utilidade::utf8DecodeToUpperToPHP($valor);
                                }

                                $data[$key] = $auxiliar;
                            }
                        }

                        $sql = $this->dataBase->prepare('SELECT FOUND_ROWS()');
                        $sql->execute();
                        $rowCountMySql = $sql->fetch(PDO::FETCH_ASSOC);
                        $count = $rowCountMySql['FOUND_ROWS()'];

                        $sql = null;

                        return array('data' => $data, 'totalCount' => $count);
                    }
                }
                else
                {
                    throw new Exception('Sem parâmetros para realizar a pesquisa.');
                }
            }
            else
            {
                throw new Exception('Parâmetro inválido para realizar a consulta.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }

    public function insert($data)
    {
        try
        {
            if (is_array($data))
            {
                $countFiltros = Utilidade::contarArray($data);

                if ($countFiltros > 0)
                {
                    $id = null;

                    $fields = '';
                    $values = '';
                    $countFiltrosAux = 0;
                    foreach ($data as $key => $value)
                    {
                        $countFiltrosAux++;
                        $fields .= ($countFiltrosAux > 1 ? ', ' : '') . $key;
                        if ($value == 'NULL')
                            $values .= ($countFiltrosAux > 1 ? ', ' : '') . 'NULL';
                        else
                            $values .= ($countFiltrosAux > 1 ? ', \'' : '\'') . $value . '\'';
                    }

                    $query = 'INSERT INTO ' . $this->table . '(' . $fields . ') VALUES (' . $values . ')';

                    $sql = $this->dataBase->prepare($query);
                    $sql->execute();

                    $arrayErrorSQL = $sql->errorInfo();

                    $sql = null;

                    if (Utilidade::contarArray($arrayErrorSQL) > 0 && $arrayErrorSQL[0] != '00000')
                    {
                        throw new Exception($arrayErrorSQL[2]);
                    }
                    else
                    {
                        $id = $this->dataBase->lastInsertId();

                        return (int) $id;
                    }
                }
                else
                {
                    throw new Exception('Sem parâmetros de inserção.');
                }
            }
            else
            {
                throw new Exception('Parâmetro inválido para inserção de dados.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }

    public function update($fields, $filtros)
    {
        try
        {
            if (is_array($filtros))
            {
                $countFiltros = Utilidade::contarArray($filtros);

                if ($countFiltros > 0)
                {
                    $_fields = '';
                    $countFiltrosAux = 0;
                    foreach ($fields as $key => $value)
                    {
                        if ($key != 'id')
                        {
                            $countFiltrosAux++;
                            $_fields .= ($countFiltrosAux == 1 ? ' SET' : '');
                            $_fields .= ($countFiltrosAux > 1 ? ', ' : ' ') . $key . ' = ' . (strcasecmp($value, 'NULL') == 0 ? "NULL" : "'$value'");
                        }
                    }

                    $_filtros = '';
                    $countFiltrosAux = 0;
                    foreach ($filtros as $key => $value)
                    {
                        $countFiltrosAux++;
                        $_filtros .= ($countFiltrosAux == 1 ? ' WHERE' : '');
                        $_filtros .= ($countFiltrosAux > 1 ? ' AND ' : ' ') . $key . ' = \'' . $value . '\'';
                    }

                    $query = 'UPDATE ' . $this->table . $_fields . $_filtros;

                    $sql = $this->dataBase->prepare($query);
                    $sql->execute();

                    $arrayErrorSQL = $sql->errorInfo();

                    if (Utilidade::contarArray($arrayErrorSQL) > 0 && $arrayErrorSQL[0] != '00000')
                    {
                        $sql = null;

                        throw new Exception($arrayErrorSQL[2]);
                    }
                    else if ($sql->rowCount() > 0)
                    {
                        $sql = null;

                        return 1;
                    }
                    else if ($sql->rowCount() <= 0)
                    {
                        $sql = null;

                        return 0;
                    }
                }
                else
                {
                    throw new Exception('Sem parâmetros para realizar a alteração.');
                }
            }
            else
            {
                throw new Exception('Parâmetro inválido para realizar a alteração.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }

    public function delete($id)
    {
        try
        {
            if (isset($id) && !Validacoes::isNullOrEmpty($id))
            {
                $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

                $sql = $this->dataBase->prepare($query);
                $sql->bindParam(':id', $id, PDO::PARAM_INT);
                $sql->execute();

                $arrayErrorSQL = $this->dataBase->errorInfo();
                if (Utilidade::contarArray($arrayErrorSQL) > 0 && $arrayErrorSQL[0] != '00000')
                {
                    $sql = null;

                    throw new Exception($arrayErrorSQL[2]);
                }
                else if ($sql->rowCount() > 0)
                {
                    $sql = null;

                    return 1;
                }
                else if ($sql->rowCount() <= 0)
                {
                    $sql = null;

                    return 0;
                }
            }
            else
            {
                throw new Exception('Sem parâmetros para deletar registro.');
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ' - ' . $e->getLine();
        }
    }
}