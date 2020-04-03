<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

Abstract class NoticiaFactory
{
    Private $idNoticia;
    Private $titulo;
    Private $subTitulo;
    Private $texto;
    Private $img;
    Private $dataCadastro;
    Private $status;

    /**
     * @return mixed
     */
    public function getIdNoticia()
    {
        return $this->idNoticia;
    }

    /**
     * @param mixed $idNoticia
     */
    public function setIdNoticia($idNoticia)
    {
        $this->idNoticia = $idNoticia;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getSubTitulo()
    {
        return $this->subTitulo;
    }

    /**
     * @param mixed $subTitulo
     */
    public function setSubTitulo($subTitulo)
    {
        $this->subTitulo = $subTitulo;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
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
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }




}