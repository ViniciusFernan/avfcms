<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */
require_once APP . "/models/menu/dao/MenuDAO.php";
require_once APP . "/models/menu/strategy/NovoMenuStrategy.php";

class MenuModel
{
    public function getListaMenu()
    {
        try {

            $dataSetMenu = (new MenuDAO)->getListaMenu();
            if ($dataSetMenu instanceof Exception) throw $dataSetMenu;
            if (!empty($dataSetMenu) && is_string($dataSetMenu)) throw new Exception($dataSetMenu);
            return $dataSetMenu;

        } catch (Exception $e) {
            return $e;
        }
    }

    public function getMenuPorId($id)
    {
        try {
            if (empty($id)) throw new Exception('Erro, identificador do menu não enviado');

            $dadosMenu = (new MenuDAO)->getMenuPorId($id);
            if (!empty($dadosMenu) && is_string($dadosMenu)) throw new Exception($dadosMenu);
            return $dadosMenu;

        } catch (Exception $e) {
            return $e;
        }
    }

    public function editarMenu($post)
    {
        try {
            if (empty($post['idMenu'])) throw new Exception('Erro identificador do menu não enviado');

            $post = (new NovoMenuStrategy())->novoMenu(array_filter($post));
            if ($post instanceof Exception) throw $post;

            $objetoMenu = (new MenuFactory())->objectInteractionDB($post);
            $updateMenu = (new  MenuDAO)->editarMenu($objetoMenu);
            if ($updateMenu instanceof Exception) throw $updateMenu;

            return $updateMenu;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function criarMenu($post)
    {
        try {

            $post = (new NovoMenuStrategy())->novoMenu(array_filter($post));
            if ($post instanceof Exception) throw $post;

            $menuCreate = (new MenuFactory())->objectInteractionDB($post);

            $novoMenu = (new MenuDAO)->criarMenu($menuCreate);
            if ($novoMenu instanceof Exception) throw $novoMenu;

            return $novoMenu;
        } catch (Exception $e) {
            return $e;
        }
    }

}
