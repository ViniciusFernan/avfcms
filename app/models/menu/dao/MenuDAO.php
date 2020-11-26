<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

require_once APP . "/models/menu/factory/MenuFactory.php";

class MenuDAO
{

    private $Conn = null;
    private $tabela = 'menu_backend';

    public function __construct($Conn = null)
    {
    }

    public function criarMenu($post)
    {
        try {
            if (!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $menuCreate = (new Create($this->tabela, $this->Conn))->Create($post);
            if ($menuCreate instanceof Exception) throw  $menuCreate;

            return $menuCreate;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function getListaMenu()
    {
        try {
            $where[] = ['type' => 'and', 'field' => 'status', 'value' => '1', 'comparation' => '='];

            $ordem = ['ordem' => 'ASC'];

            $dataSetMenu = (new Select($this->tabela))->Select(['*'], $where, '', '', '', $ordem);
            if ($dataSetMenu instanceof Exception) throw $dataSetMenu;
            if (empty($dataSetMenu)) throw new Exception('Usuario não encontrado!');

            $listaMenuRetorno = [];
            foreach ($dataSetMenu as $menuDb) {
                $menu = (new MenuFactory);
                foreach ($menuDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($menu,$atributeSet))) continue;
                    $menu->$atributeSet($valor);
                }
                $listaMenuRetorno[] = $menu;
            }
            return $listaMenuRetorno;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function getMenuPorId($id)
    {
        try {
            if (empty($id)) throw new Exception('Erro identificador do menu não enviado');

            $where[] = ['type' => 'and', 'field' => 'idMenu', 'value' => $id, 'comparation' => '='];

            $dadosMenu = (new Select($this->tabela))->Select(null, $where);
            if ($dadosMenu instanceof Exception) throw $dadosMenu;
            if (empty($dadosMenu)) throw new Exception('Usuario não encontrado!');

            $menu = (new MenuFactory);
            foreach ($dadosMenu as $menuDb) {
                foreach ($menuDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($menu,$atributeSet))) continue;
                    $menu->$atributeSet($valor);
                }
            }

            return $menu;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function checarMenuCadastrado($key, $valor, $idExclude = null)
    {
        try {
            if (empty($key) || empty($valor))
                throw new Exception('Error grave nesse trem');

            $where[] = ['type' => 'and', 'field' => 'status', 'value' => '1', 'comparation' => '='];
            $where[] = ['type' => 'and', 'field' => $key, 'value' => $valor, 'comparation' => '='];

            if (!empty($idExclude))
                $where[] = ['type' => 'and', 'field' => 'idMenu', 'value' => $idExclude, 'comparation' => '!='];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
            if ($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if (!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function editarMenu($Data, $idMenu)
    {
        try {
            if (!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

            unset($Data['idMenu']);

            $where[] = ['type' => 'and', 'field' => 'idMenu', 'value' => $idMenu, 'comparation' => '='];
            $updateUsuario = (new Update($this->tabela, $this->Conn))->Update($Data, $where);
            if ($updateUsuario instanceof Exception) throw $updateUsuario;
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
}
