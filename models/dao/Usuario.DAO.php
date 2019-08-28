<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class UsuarioDAO extends Conn {

    /**
     * Verifica se o usuário existe no banco
     * @author vinicius fernandes
     * @return array Usuario
     * @throws string
     */
    public function getUsuarioFromEmailSenha($email, $senha) {
        try{
            $sql = "SELECT
                        usuario.idUsuario,
                        usuario.nome,
                        usuario.sobreNome,
                        usuario.email,
                        usuario.idPerfil,
                        usuario.superAdmin,
                        usuario.status,
                        perfil.idPerfil,
                        perfil.nomePerfil
                    FROM usuario
                    INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil
                    WHERE  usuario.status = 1
                    AND usuario.email = :email
                    AND senha = BINARY :senha
                    LIMIT 1 ";

            $select = new Select();
            $dadosUsuario = $select->FullSelect($sql, "email={$email}&senha={$senha}");

            if(!is_array($dadosUsuario) && !empty($dadosUsuario)) throw new Exception($dadosUsuario);

            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario[0];
        }catch(Exeption $e){
            return $e->getMessage;
        }
    }

    /**
     * inserir novos usuarios
     * @param $post
     * @return bool|INT
     * @throws Exception
     */
    public function insertNewUser($post){
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $userC = new Create;
            $userCreate = $userC->ExeCreate('usuario', $post);

            if(!is_int($userCreate) && !empty($userCreate)) throw new Exception($userCreate);

            return $userCreate;
        }catch(Exeption $e){
            return $e->getMessage;
        }

    }

    public function editarUsuario($Data){
        if(!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

        $user['idUsuario'] = $Data['idUsuario'];
        unset($Data['idUsuario']);

        $update = new Update();
        $updateUsuario = $update->ExeUpdate('usuario', $Data, 'WHERE idUsuario=:idUsuario', "idUsuario={$user['idUsuario']}");
        if(is_string($updateUsuario) && !empty($updateUsuario)) throw new Exception($updateUsuario);
        if(empty($updateUsuario)) throw new Exception('Ops, erro ao atualizar usuario');

        return true;
    }

    public function checarEmailJaEstaCadastrado($post){
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Tem um trem errado aqui!');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('usuario', "WHERE email=:email AND status=:status", "email={$post['email']}&status=1");
            if(!is_array($dadosUsuario) && !empty($dadosUsuario)) throw new Exception($dadosUsuario);
            if(!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;

        }catch(Exeption $e){
            return $e->getMessage;
        }

    }

    public function checarCPFJaEstaCadastrado($post){
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('usuario', "WHERE CPF=:CPF AND status=:status", "CPF={$post['CPF']}&status=1");
            if(!is_array($dadosUsuario) && !empty($dadosUsuario)) throw new Exception($dadosUsuario);
            if(!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;
        }catch(Exeption $e){
            return $e->getMessage;
        }

    }

    public function buscarUsuarioPorEmail($email) {
        try{
            $sql = "SELECT
                        usuario.idUsuario,
                        usuario.nome,
                        usuario.sobreNome,
                        usuario.email,
                        usuario.idPerfil,
                        usuario.superAdmin,
                        usuario.status,
                        perfil.idPerfil,
                        perfil.nomePerfil
                    FROM usuario
                    INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil
                    WHERE  usuario.status = 1
                    AND usuario.email = :email
                    LIMIT 1 ";

            $select = new Select();
            $dadosUsuario = $select->FullSelect($sql, "email={$email}");

            if(!is_array($dadosUsuario) && !empty($dadosUsuario)) throw new Exception($dadosUsuario);

            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario[0];
        }catch(Exeption $e){
            return $e->getMessage;
        }
    }

    public function getListaDeUsuarios() {
        try{
            $sql = "SELECT
                        usuario.idUsuario,
                        usuario.nome,
                        usuario.sobreNome,
                        usuario.email,
                        usuario.telefone,
                        usuario.idPerfil,
                        usuario.superAdmin,
                        usuario.status,
                        perfil.idPerfil,
                        perfil.nomePerfil
                    FROM usuario
                    INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil ";

            $select = new Select();
            $listaUsuario = $select->FullSelect($sql);

            if(!is_array($listaUsuario) && !empty($listaUsuario)) throw new Exception($listaUsuario);

            if(empty($listaUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $listaUsuario;
        }catch(Exeption $e){
            return $e->getMessage;
        }
    }

    public function getUsuarioPorId($id) {
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('usuario', "WHERE id=:id", "id={$id}");
            if(!is_array($dadosUsuario) && !empty($dadosUsuario)) throw new Exception($dadosUsuario);
            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario;
        }catch(Exeption $e){
            return $e->getMessage;
        }
    }

}
