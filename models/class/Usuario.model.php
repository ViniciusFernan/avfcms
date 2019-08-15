<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/dao/Usuario.DAO.php";
class UsuarioModel{

    /**
     * cadastro de novo usuario
     */
    public function novoUsuario($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Preencha o formulário!');

            if(empty($post['nome']) || empty($post['email']) || empty($post['CPF']) || empty($post['senha']) || empty($post['dataNascimento']))
                throw new Exception('Dados obrigatórios não informados');


            if(!empty($post['CPF']) && Util::CPF($post['CPF'])==FALSE )
                throw new Exception('CPF informado é invalido');


            $checkEmail = $this->checarEmailJaEstaCadastrado(['email' => $post['email']] );
            if(!empty($checkEmail))
                throw new Exception('Email já cadastrado!');

            $checkCPF = $this->checarCPFJaEstaCadastrado(['CPF' => $post['CPF']] );
            if(!empty($checkCPF))
                throw new Exception('CPF já cadastrado!');

            $insertResp = (new UsuarioDAO)->insertNewUser($post);

            if(!empty($insertResp) && !is_int($insertResp))  throw new Exception($insertResp);

            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * checar se existe usuario com esse email
     */
    public function checarEmailJaEstaCadastrado($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Error em processar dados');

            $insertResp = (new UsuarioDAO)->checarEmailJaEstaCadastrado($post);
            if(!empty($insertResp) && is_string($insertResp)) throw new Exception($insertResp);
            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * checar se existe usuario com esse email
     */
    public function checarCPFJaEstaCadastrado($post) {
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Error em processar dados');

            $insertResp = (new UsuarioDAO)->checarCPFJaEstaCadastrado($post);
            if(!empty($insertResp) && is_string($insertResp)) throw new Exception($insertResp);
            return $insertResp;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


    /**
     *Recuperar senha
     * criar senha criptografada e envia link por email
     */
    public function recuperarSenhaDoUsuario($email){
        try{
            if(!Util::Email($email) || empty($email)) throw new Exception('Error em processar dados');

            $resp = $user = [];

            $usuarioDAO = new UsuarioDAO;
            $user = $usuarioDAO->buscarUsuarioPorEmail($email);
            if(is_array($user) && empty($user)) throw new Exception('Usuários não encontrado!');
            if(!is_array($user) && !empty($user)) throw new Exception($user);

            $hash['chaveDeRecuperacao'] = Util::encriptaSenha(rand(1, 1000));

            $t = $email . "__" . $hash['chaveDeRecuperacao'];
            $dataEncriptada = Util::encriptaData($t);

            $userUpdate['idUsuario'] = $user['idUsuario'];
            $userUpdate['chaveDeRecuperacao'] = $hash['chaveDeRecuperacao'];

            $updateusuario = $usuarioDAO->editarUsuario($userUpdate);
            if(is_string($updateusuario) && !empty($updateusuario)) throw new Exception($updateusuario);

            $template['action'] = 'Recuperação de senha';
            $template['user'] = $user["nome"].' '.$user["sobreNome"];
            $template['url'] = HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada;
            $template['texto'] = 'Olá, ' . $user["nome"].' '.$user["sobreNome"] . ', <br />
                                Alguém solicitou recentemente uma alteração na senha da sua conta do Marombeiros. Se foi você, então defina sua nova senha aqui: <br />
                                <a href="' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada . '" target="_blank">Redefinir senha</a> <br />
                                Se não quiser alterar a senha ou não tiver feito essa solicitação, basta ignorar e excluir esta mensagem. <br />
                                Para manter sua conta segura, não encaminhe este e-mail para ninguém. <br />
                                Caso prefira esse é seu link de recuperação de senha <br />
                                <b>' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada . ' </b><br /> ele funcionará apenas 1 unica vez.';


            $mensagem = Util::templateEmail($template);

            $title = "[NOTIFICACAO] Recuperação de senha";
            $emailSend = Util::enviarEmail($title, $user['email'],  $user["nome"].' '.$user["sobreNome"], $mensagem);

            return true;

        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}
