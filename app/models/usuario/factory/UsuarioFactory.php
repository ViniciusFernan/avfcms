<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class UsuarioFactory
{
    private $idUsuario;
    private $nome;
    private $sobreNome;
    private $email;
    private $senha;
    private $telefone;
    private $CPF;
    private $idPerfil;
    private $dataNascimento;
    private $sexo;
    private $status;
    private $detalhes;
    private $superAdmin;
    private $imgPerfil;
    private $chaveDeRecuperacao;

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
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
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSobreNome()
    {
        return $this->sobreNome;
    }

    /**
     * @param mixed $sobreNome
     */
    public function setSobreNome($sobreNome)
    {
        $this->sobreNome = $sobreNome;
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
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
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
    public function getCPF()
    {
        return $this->CPF;
    }

    /**
     * @param mixed $CPF
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
    }


    /**
     * @return mixed
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * @param mixed $idPerfil
     * @return UsuarioFactory
     */
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
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

    /**
     * @return mixed
     */
    public function getDetalhes()
    {
        return $this->detalhes;
    }

    /**
     * @param mixed $detalhes
     */
    public function setDetalhes($detalhes)
    {
        $this->detalhes = $detalhes;
    }

    /**
     * @return mixed
     */
    public function getSuperAdmin()
    {
        return $this->superAdmin;
    }

    /**
     * @param mixed $superAdmin
     */
    public function setSuperAdmin($superAdmin)
    {
        $this->superAdmin = $superAdmin;
    }

    /**
     * @return mixed
     */
    public function getImgPerfil()
    {
        return $this->imgPerfil;
    }

    /**
     * @param mixed $imgPerfil
     */
    public function setImgPerfil($imgPerfil)
    {
        $this->imgPerfil = $imgPerfil;
    }

    /**
     * @return mixed
     */
    public function getChaveDeRecuperacao()
    {
        return $this->chaveDeRecuperacao;
    }

    /**
     * @param mixed $chaveDeRecuperacao
     */
    public function setChaveDeRecuperacao($chaveDeRecuperacao)
    {
        $this->chaveDeRecuperacao = $chaveDeRecuperacao;
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