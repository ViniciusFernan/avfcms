<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

class LogarComoModel {

    private $result;

    function getResult() {
        return $this->result;
    }

    /**
     * Troca a SESSION de usuario para se passar por outro usuario do sistema
     * deixa a SESSION LOGARCOMO_TMP com os dados originais do SuperAdm
     * @param INTEGER $idUsuario - Id do usuario que quer se logar como
     */
    public function Logar($idUsuario) {

        $sel = new Select;
        $sql = "SELECT
                    usuario.idUsuario,
                    usuario.idCorretora,
                    usuario.idEquipe,
                    usuario.nome,
                    usuario.apelido,
                    usuario.email,
                    usuario.idPerfil,
                    usuario.superAdmin,
                    usuario.status,
                    corretora.nomeCorretora,
                    perfil.nomePerfil,
                    usuario.senha
                FROM
                    usuario
                INNER JOIN corretora ON usuario.idCorretora = corretora.idCorretora
                INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil
                WHERE idUsuario=:idUsuario";
        $sel->FullSelect($sql, "idUsuario=$idUsuario");
        if ($sel->getResult()):
            $_SESSION['LOGARCOMO_TMP'] = $_SESSION['usuario'];
            $_SESSION['usuario'] = $sel->getResult()[0];
            $this->result = ['resp' => 'success'];
            return;
        endif;
        $this->result = ['resp' => 'error'];
    }

    /**
     * Reseta para o usuario LOGARCOMO_TMP
     */
    public function ResetLogarComo() {
        if (!empty($_SESSION['LOGARCOMO_TMP'])):
            if (!empty($_SESSION['LOGARCOMO_TMP']['superAdmin']) && $_SESSION['LOGARCOMO_TMP']['superAdmin'] == 1):
                $_SESSION['usuario'] = $_SESSION['LOGARCOMO_TMP'];
                unset($_SESSION['LOGARCOMO_TMP']);
                $this->result = ['resp' => 'success'];
                return;
            endif;
        endif;
        $this->result = ['resp' => 'error', "msg" => "Nao ha logar como ativo"];
    }

}
