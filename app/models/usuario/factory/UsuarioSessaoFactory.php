<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class UsuarioSessaoFactory extends UsuarioFactory
{
    private $nomePerfil;

    /**
     * @return mixed
     */
    public function getNomePerfil()
    {
        return $this->nomePerfil;
    }

    /**
     * @param mixed $nomePerfil
     * @return UsuarioSessaoFactory
     */
    public function setNomePerfil($nomePerfil)
    {
        $this->nomePerfil = $nomePerfil;
        return $this;
    }


}