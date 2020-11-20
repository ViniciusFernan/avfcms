<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */
require_once APP . "/models/usuario/factory/UsuarioFactory.php";
require_once APP . "/models/usuario/dao/UsuarioDAO.php";
require_once APP . "/models/usuario/strategy/NovoUsuarioStrategy.php";
require_once APP . "/models/usuario/strategy/RecuperarSenhaUsuarioStrategy.php";

class UsuarioModel extends Conn {
    private $Conn;
    /**
* cadastro de novo usuario
*/
    public function novoUsuario($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');
            $this->Conn = parent::getConn();
            $this->Conn->beginTransaction();

            $post = (new NovoUsuarioStrategy)->novoUsuario(array_filter($post));
            if($post instanceof Exception) throw  $post;

            $insertResp = (new UsuarioDAO($this->Conn))->insertNewUser($post);
            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            $this->Conn->commit();
            return $insertResp;
        }catch (Exception $e){
            $this->Conn->rollBack();
            return $e;
        }
    }


    /**
     *Recuperar senha
     * criar senha criptografada e envia link por email
     */
    public function recuperarSenhaDoUsuario($email){
        try{
            if(!Util::Email($email) || empty($email)) throw new Exception('Error em processar dados');

            $usuarioDAO = new UsuarioDAO;
            $user = $usuarioDAO->buscarUsuarioPorEmail($email);
            if(empty($user)) throw new Exception('Usuários não encontrado!');
            if(is_string($user) && !empty($user)) throw new Exception($user);

            $hash['chaveDeRecuperacao'] = Util::encriptaSenha(rand(1, 1000));
            $user->chaveDeRecuperacao = Util::encriptaData($email . "__" . $hash['chaveDeRecuperacao']);

            $returnUsuario = (new RecuperarSenhaUsuarioStrategy)->recuperarSenhaDoUsuario($user);
            if($returnUsuario instanceof Exception)  throw $returnUsuario;
            if(empty($returnUsuario)) throw new Exception('Erro grave nesse trem!');

            $userUpdate['chaveDeRecuperacao'] = $user->chaveDeRecuperacao;

            $updateusuario = $usuarioDAO->editarUsuario($userUpdate, $user->idUsuario);
            if(is_string($updateusuario) && !empty($updateusuario)) throw new Exception($updateusuario);

            return 1;
        }catch (Exception $e){
            return $e;
        }
    }


    /**
     * Retorna lista de usuarios
     */
    public function getListaDeUsuarios() {
        try{
            $listaUsuarios = (new UsuarioDAO)->getListaDeUsuarios();
            if(!empty($listaUsuarios) && is_string($listaUsuarios)) throw new Exception($listaUsuarios);
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
        }
    }

    /**
     * Retorna lista de usuarios
     */
    public function getUsuarioPorId($id){
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $dadosUsuario = (new UsuarioDAO)->getUsuarioPorId($id);
            if(!empty($dadosUsuario) && is_string($dadosUsuario)) throw new Exception($dadosUsuario);
            return $dadosUsuario;

        }catch (Exception $e){
            return $e;
        }
    }

    public function editarUsuario($post){
        try{
            if(empty($post['idUsuario'])) throw new Exception('Erro identificador do usuario não enviado');

            $idUsuario=$post['idUsuario'];
            unset($post['idUsuario']);

            if(!empty($post['senha'])) $post['senha'] = Util::encriptaSenha($post['senha']);
            else unset($post['senha']);

            $updateUsuario = (new  UsuarioDAO)->editarUsuario($post, $idUsuario);
            if($updateUsuario instanceof Exception) throw $updateUsuario;

            return $updateUsuario;
        }catch (Exception $e){
            return $e;
        }
    }


}
