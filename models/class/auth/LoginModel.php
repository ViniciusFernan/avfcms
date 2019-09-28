<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/dao/auth/LoginDAO.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";
class LoginModel{

    public function logar($email, $senha) {
        try{
            //Valida se o email foi preenchido e se é um email valido
            if (empty($email) || !Util::Email($email))
                throw new Exception("Email Inválido");

            //Valida se a senha foi preenchida e se tem pelomenos 5 caracteres
            if (empty($senha) || strlen($senha) < 5)
                throw new Exception("Preencha a senha corretamente");

            //Seta os falores dos atributos
            $this->email = strtolower($email);
            $this->senha = Util::encriptaSenha($senha);

            // Apaga a sessao de usuario caso exista
            $_SESSION['usuario'] = [];
            unset($_SESSION['usuario']);

            $loginResult = (new AnuncioDAO())->getUsuarioFromEmailSenha(strtolower($email), Util::encriptaSenha($senha));
			
			if(!empty($loginResult) && is_string($loginResult)) 
				throw new Exception($loginResult);
            if (empty($loginResult) ) 
				throw new Exception("Usuario não encontrado");

            $_SESSION['usuario'] = $loginResult[0];
            return true;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Mata a sessão de Usuário e Redireciona para a página de login
     * @param Boolean $redirectLogin - true para redirecionar para login
     */
    public function deslogar() {
        //apaga a sessao de usuario
        $_SESSION['usuario'] = [];
        unset($_SESSION['usuario']);
        Util::redirect(HOME_URI . "/login");
    }

}
