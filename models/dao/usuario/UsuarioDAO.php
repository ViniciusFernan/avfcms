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

        try{
            $select = new Select();
            $listaUsuarios = $select->FullSelect($sql, "email={$email}&senha={$senha}");
            if($listaUsuarios instanceof Exception) throw  $listaUsuarios;
                if(empty($listaUsuarios)) throw new Exception('Nenhum Usuario encontrado nesse trem!');
            return $listaUsuarios;
        }catch (Exception $e){
            return $e;
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

            $userCreate = (new Create)->ExeCreate('usuario', $post);
            if($userCreate instanceof Exception) throw  $userCreate;

            return $userCreate;
        }catch(Exeption $e){
            return $e;
        }

    }

    public function editarUsuario($Data, $idUsuario){
        try{
            if(!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

            unset($Data['idUsuario']);

            $updateUsuario = (new Update)->ExeUpdate('usuario', $Data, 'WHERE idUsuario=:idUsuario', "idUsuario={$idUsuario}");
            if($updateUsuario instanceof Exception) throw $updateUsuario;
            return true;
        }catch (Exception $e){
            return $e;
        }

    }

    public function checarEmailJaEstaCadastrado($post){
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Tem um trem errado aqui!');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('*', 'usuario', "WHERE email=:email AND status=:status", "email={$post['email']}&status=1");
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;

        }catch(Exeption $e){
            return $e;
        }

    }

    public function checarCPFJaEstaCadastrado($post){
        try{
            if(!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('*', 'usuario', "WHERE CPF=:CPF AND status=:status", "CPF={$post['CPF']}&status=1");
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;
        }catch(Exeption $e){
            return $e;
        }

    }

    public function checarUsuarioCadastrado($key, $valor){
        try{
            if(empty($key) || empty($valor) )
                throw new Exception('Error grave nesse trem');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('*', 'usuario', "WHERE {$key}=:{$key} AND status=:status", "{$key}={$valor}&status=1");
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;
        }catch(Exeption $e){
            return $e;
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
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;

            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario[0];
        }catch(Exeption $e){
            return $e;
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
            if($listaUsuario instanceof Exception) throw $listaUsuario;

            if(empty($listaUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $listaUsuario;
        }catch(Exeption $e){
            return $e;
        }
    }

    public function getUsuarioPorId($id) {
        try{
            if(empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $select = new Select();
            $dadosUsuario = $select->ExeRead('*', 'usuario', "WHERE idUsuario=:id", "id={$id}");
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario;
        }catch(Exeption $e){
            return $e;
        }
    }



}
