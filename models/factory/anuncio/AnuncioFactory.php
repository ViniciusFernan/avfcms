<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

Abstract class AnuncioFactory{
    Private $idAnuncio;
    Private $slugAnuncio;
    Private $tituloAnuncio;
    Private $nomeRepresentante;
    Private $telefone;
    Private $telWhatsApp;
    Private $telefoneAlt;
    Private $telAltWhatsApp;
    Private $email;
    Private $naoReceberEmail;
    Private $rua;
    Private $bairro;
    Private $cidade;
    Private $cep;
    Private $horarioDeFuncionamento;
    Private $maps;
    Private $siteProprio;
    Private $imgCapa;
    Private $imgsGaleria;
    Private $miniDescricao;
    Private $sobre;
    Private $servicosOferecidos;
    Private $principaisProdutos;
    Private $midiasSociais;
    Private $tags;
    Private $tituloSEO;
    Private $descicaoSEO;
    Private $keyWordsSEO;
    Private $qtView;
    Private $status;

    /**
     * @return mixed
     */
    public function getIdAnuncio()
    {
        return $this->idAnuncio;
    }

    /**
     * @param mixed $idAnuncio
     */
    public function setIdAnuncio($idAnuncio)
    {
        $this->idAnuncio = $idAnuncio;
    }

    /**
     * @return mixed
     */
    public function getSlugAnuncio()
    {
        return $this->slugAnuncio;
    }

    /**
     * @param mixed $slugAnuncio
     */
    public function setSlugAnuncio($slugAnuncio)
    {
        $this->slugAnuncio = $slugAnuncio;
    }

    /**
     * @return mixed
     */
    public function getTituloAnuncio()
    {
        return $this->tituloAnuncio;
    }

    /**
     * @param mixed $tituloAnuncio
     */
    public function setTituloAnuncio($tituloAnuncio)
    {
        $this->tituloAnuncio = $tituloAnuncio;
    }

    /**
     * @return mixed
     */
    public function getNomeRepresentante()
    {
        return $this->nomeRepresentante;
    }

    /**
     * @param mixed $nomeRepresentante
     */
    public function setNomeRepresentante($nomeRepresentante)
    {
        $this->nomeRepresentante = $nomeRepresentante;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getTelWhatsApp()
    {
        return $this->telWhatsApp;
    }

    /**
     * @param mixed $telWhatsApp
     */
    public function setTelWhatsApp($telWhatsApp)
    {
        $this->telWhatsApp = $telWhatsApp;
    }

    /**
     * @return mixed
     */
    public function getTelefoneAlt()
    {
        return $this->telefoneAlt;
    }

    /**
     * @param mixed $telefoneAlt
     */
    public function setTelefoneAlt($telefoneAlt)
    {
        $this->telefoneAlt = $telefoneAlt;
    }

    /**
     * @return mixed
     */
    public function getTelAltWhatsApp()
    {
        return $this->telAltWhatsApp;
    }

    /**
     * @param mixed $telAltWhatsApp
     */
    public function setTelAltWhatsApp($telAltWhatsApp)
    {
        $this->telAltWhatsApp = $telAltWhatsApp;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNaoReceberEmail()
    {
        return $this->naoReceberEmail;
    }

    /**
     * @param mixed $naoReceberEmail
     */
    public function setNaoReceberEmail($naoReceberEmail)
    {
        $this->naoReceberEmail = $naoReceberEmail;
    }

    /**
     * @return mixed
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * @param mixed $rua
     */
    public function setRua($rua)
    {
        $this->rua = $rua;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getHorarioDeFuncionamento()
    {
        return $this->horarioDeFuncionamento;
    }

    /**
     * @param mixed $horarioDeFuncionamento
     */
    public function setHorarioDeFuncionamento($horarioDeFuncionamento)
    {
        $this->horarioDeFuncionamento = $horarioDeFuncionamento;
    }

    /**
     * @return mixed
     */
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * @param mixed $maps
     */
    public function setMaps($maps)
    {
        $this->maps = $maps;
    }

    /**
     * @return mixed
     */
    public function getSiteProprio()
    {
        return $this->siteProprio;
    }

    /**
     * @param mixed $siteProprio
     */
    public function setSiteProprio($siteProprio)
    {
        $this->siteProprio = $siteProprio;
    }

    /**
     * @return mixed
     */
    public function getImgCapa()
    {
        return $this->imgCapa;
    }

    /**
     * @param mixed $imgCapa
     */
    public function setImgCapa($imgCapa)
    {
        $this->imgCapa = $imgCapa;
    }

    /**
     * @return mixed
     */
    public function getImgsGaleria()
    {
        return $this->imgsGaleria;
    }

    /**
     * @param mixed $imgsGaleria
     */
    public function setImgsGaleria($imgsGaleria)
    {
        $this->imgsGaleria = $imgsGaleria;
    }

    /**
     * @return mixed
     */
    public function getMiniDescricao()
    {
        return $this->miniDescricao;
    }

    /**
     * @param mixed $miniDescricao
     */
    public function setMiniDescricao($miniDescricao)
    {
        $this->miniDescricao = $miniDescricao;
    }

    /**
     * @return mixed
     */
    public function getSobre()
    {
        return $this->sobre;
    }

    /**
     * @param mixed $sobre
     */
    public function setSobre($sobre)
    {
        $this->sobre = $sobre;
    }

    /**
     * @return mixed
     */
    public function getServicosOferecidos()
    {
        return $this->servicosOferecidos;
    }

    /**
     * @param mixed $servicosOferecidos
     */
    public function setServicosOferecidos($servicosOferecidos)
    {
        $this->servicosOferecidos = $servicosOferecidos;
    }

    /**
     * @return mixed
     */
    public function getPrincipaisProdutos()
    {
        return $this->principaisProdutos;
    }

    /**
     * @param mixed $principaisProdutos
     */
    public function setPrincipaisProdutos($principaisProdutos)
    {
        $this->principaisProdutos = $principaisProdutos;
    }

    /**
     * @return mixed
     */
    public function getMidiasSociais()
    {
        return $this->midiasSociais;
    }

    /**
     * @param mixed $midiasSociais
     */
    public function setMidiasSociais($midiasSociais)
    {
        $this->midiasSociais = $midiasSociais;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getTituloSEO()
    {
        return $this->tituloSEO;
    }

    /**
     * @param mixed $tituloSEO
     */
    public function setTituloSEO($tituloSEO)
    {
        $this->tituloSEO = $tituloSEO;
    }

    /**
     * @return mixed
     */
    public function getDescicaoSEO()
    {
        return $this->descicaoSEO;
    }

    /**
     * @param mixed $descicaoSEO
     */
    public function setDescicaoSEO($descicaoSEO)
    {
        $this->descicaoSEO = $descicaoSEO;
    }

    /**
     * @return mixed
     */
    public function getKeyWordsSEO()
    {
        return $this->keyWordsSEO;
    }

    /**
     * @param mixed $keyWordsSEO
     */
    public function setKeyWordsSEO($keyWordsSEO)
    {
        $this->keyWordsSEO = $keyWordsSEO;
    }

    /**
     * @return mixed
     */
    public function getQtView()
    {
        return $this->qtView;
    }

    /**
     * @param mixed $qtView
     */
    public function setQtView($qtView)
    {
        $this->qtView = $qtView;
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