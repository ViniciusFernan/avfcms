<?php

/**
 * Controlador que deverá ser chamado quando não for
 * especificado nenhum outro
 *
 * Camada - Controladores ou Controllers
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */

require_once APP . "/models/menu/model/MenuModel.php";

class MenuController extends MainController
{
    public $retorno = [];

    /**
     * IndexController constructor.
     * Define qual rota seguir
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ação que deverá ser executada quando
     * nenhuma outra for especificada, do mesmo jeito que o
     * arquivo index.html ou index.php é executado quando nenhum
     * é referenciado
     */
    public function indexAction()
    {
        try {
            $this->listaMenusAction();
        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function listaMenusAction()
    {
        try {
            $listaMenu = (new MenuModel())->getListaMenu();
            if ($listaMenu instanceof Exception) throw $listaMenu;
            if (empty($listaMenu)) throw new Exception('Nenhum Menu Encontrado');

            $this->retorno['listaMenu'] = $listaMenu;
        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
        }

        $View = new View('menu/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function visualizarMenuAction(){
        try {
            if (!empty($this->parametrosPost) && !empty($_SESSION['usuario'])) $this->editarMenuAction();
            if (empty($this->parametros[0])) throw new Exception('Necessário enviar o id do menu');
            if ($_SESSION['usuario']->idPerfil != 1) throw new Exception('Somente administrador pode alterar menu');

            $dadosMenu = (new menuModel())->getMenuPorId($this->parametros[0]);
            if ($dadosMenu instanceof Exception) throw $dadosMenu;
            if (empty($dadosMenu)) throw new Exception('Nenhum menu Encontrado');

            $this->retorno['menu'] = $dadosMenu[0];
        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
        }

        $View = new View('menu/edit.menu.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function editarMenuAction()
    {
        try {
            if (empty($this->parametrosPost)) throw new Exception('Nenhum Dado Encontrado');

            $dadosMenu = (new MenuModel())->editarMenu($this->parametrosPost);
            if ($dadosMenu instanceof Exception) throw $dadosMenu;
            if (empty($dadosMenu)) throw new Exception('Nenhum Menu Encontrado');
            $this->retorno['boxMsg'] = ['msg' => 'Menu Editado com sucesso', 'tipo' => 'success'];

            //listar usuario
            $dadosMenu = (new MenuModel())->getMenuPorId($this->parametrosPost['idMenu']);
            if ($dadosMenu instanceof Exception) throw $dadosMenu;
            if (empty($dadosMenu)) throw new Exception('Nenhum Usuário Listado');
            $this->retorno['menu'] = $dadosMenu[0];

        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
            $this->retorno['menu'] = (object)$this->parametrosPost;
        }

        $View = new View('menu/edit.menu.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function criarMenuAction()
    {
        try {
            if (!empty($this->parametrosPost)){
                $idMenu = (new MenuModel())->criarMenu($this->parametrosPost);
                if ($idMenu instanceof Exception) throw $idMenu;
                $this->retorno['boxMsg'] = ['msg' => 'Menu criado com sucesso', 'tipo' => 'success'];

                //listar usuario
                $dadosMenu = (new MenuModel())->getMenuPorId($idMenu);
                if ($dadosMenu instanceof Exception) throw $dadosMenu;
                if (empty($dadosMenu)) throw new Exception('Nenhum Usuário Listado');
                $this->retorno['menu'] = $dadosMenu[0];

            }
        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
            $this->retorno['menu'] = (object)$this->parametrosPost;
        }

        $View = new View('menu/edit.menu.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }

    public function deletarMenuAction()
    {
        try {
            if (empty($this->parametrosPost)) throw new Exception('Nenhum Dado Encontrado');

            $dataSet['idUsuario'] = $this->parametros[0];
            $dataSet['status'] = '0';

            $dadosUsuario = (new UsuarioModel())->editarUsuario($dataSet);
            if ($dadosUsuario instanceof Exception) throw $dadosUsuario;
            $this->retorno['boxMsg'] = ['msg' => 'Usuário deletado com sucesso', 'tipo' => 'success'];

        } catch (Exception $e) {
            $this->retorno['boxMsg'] = ['msg' => $e->getMessage(), 'tipo' => 'danger'];
        }

        $View = new View('usuario/default.view.php');
        $View->setParams($this->retorno);
        $View->showContents();
    }


}
