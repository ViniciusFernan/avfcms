<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

class LoginDAO extends Conn {

    private $email;
    private $senha;

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
            if (!empty($listaUsuarios) && !is_array($listaUsuarios)) throw new Exception($listaUsuarios);
			return $listaUsuarios;  
        }catch (Exception $e){
            return $e->getMessage();
        }


    }

}
