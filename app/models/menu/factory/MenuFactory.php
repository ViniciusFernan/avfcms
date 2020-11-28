<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class MenuFactory
{
    private $idMenu;
    private $icon;
    private $nome;
    private $controller;
    private $ordem;
    private $dataCadastro;
    private $private;
    private $status;

    /**
     * @return mixed
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * @param mixed $idMenu
     * @return MenuFactory
     */
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     * @return MenuFactory
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return MenuFactory
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     * @return MenuFactory
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * @param mixed $ordem
     * @return MenuFactory
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * @param mixed $dataCadastro
     * @return MenuFactory
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * @param mixed $private
     * @return MenuFactory
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return MenuFactory
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function objectInteractionDB($post)
    {
        if(empty($post)) throw new Exception('Não há dados para criar objeto de iteração com banco de dados');

        foreach ($post as $key => $valor) {
            $atributeSet = 'set'.ucfirst($key);
            if((!method_exists($this,$atributeSet))) continue;
            $this->$atributeSet($valor);
        }
        return $this;
    }


}