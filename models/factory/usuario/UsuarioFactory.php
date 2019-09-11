<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

Abstract class UsuarioFactory{

    private $nome;
    private $sobreNome;
    private $email;
    private $telefone;
    private $CPF;
    private $dataNascimento;
    private $sexo;
    private $status;
    private $detalhes;
    private $superAdmin;
    private $imgPerfil;
    private $chaveDeRecuperacao;

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getNome($nome){
        return $nome;
    }

    public function setSobreNome($sobreNome){
        $this->sobreNome = $sobreNome;
    }

    public function getSobreNome($sobreNome){
        return $sobreNome;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail($email){
        return $email;
    }

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function getTelefone($telefone){
        return $telefone;
    }


    public function setCpf($CPF){
        $this->CPF = $CPF;
    }

    public function getCpf($CPF){
        return $CPF;
    }

    public function setDataNascimento($dataNascimento){
        $this->dataNascimento = $dataNascimento;
    }

    public function getDataNascimento($dataNascimento){
        return $dataNascimento;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function getSexo($sexo){
        return $sexo;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus($status){
        return $status;
    }

    public function setDetalhes($detalhes){
        $this->detalhes = $detalhes;
    }
    public function getDetalhes($detalhes){
        return $detalhes;
    }

    public function getSuperAdmin($superAdmin){
        return $superAdmin;
    }

    public function setImgPerfil($imgPerfil){
        $this->imgPerfil = $imgPerfil;
    }

    public function getImgPerfil($imgPerfil){
        return $imgPerfil;
    }

    public function getChaveDeRecuperacao($chaveDeRecuperacao){
        return $chaveDeRecuperacao;
    }


}