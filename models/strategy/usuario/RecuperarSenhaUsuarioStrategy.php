<?php
/**
* @package Sistema distribuido em modulos
* @author AVF-WEB
* @version 1.0
* */

require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
require_once ABSPATH . "/models/dao/usuario/UsuarioDAO.php";
class RecuperarSenhaUsuarioStrategy extends UsuarioFactory {

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
            if(empty($user)) throw new Exception('Usuários não encontrado!');
            if(is_string($user) && !empty($user)) throw new Exception($user);

            $hash['chaveDeRecuperacao'] = Util::encriptaSenha(rand(1, 1000));

            $t = $email . "__" . $hash['chaveDeRecuperacao'];
            $dataEncriptada = Util::encriptaData($t);

            $userUpdate['chaveDeRecuperacao'] = $hash['chaveDeRecuperacao'];

            $updateusuario = $usuarioDAO->editarUsuario($userUpdate, $user->idUsuario);
            if(is_string($updateusuario) && !empty($updateusuario)) throw new Exception($updateusuario);

            $template['action'] = 'Recuperação de senha';
            $template['user'] = $user->nome .' '.$user->sobreNome ;
            $template['url'] = HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada;
            $template['texto'] = 'Olá, ' . $user->nome .' '.$user->sobreNome  . ', <br />
                                Alguém solicitou recentemente uma alteração da senha em sua conta do '.PROJECT_NAME.'. Se foi você, então defina sua nova senha aqui: <br />
                                <a href="' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada . '" target="_blank">Redefinir senha</a> <br />
                                Se não quiser alterar a senha ou não tiver feito essa solicitação, basta ignorar e excluir esta mensagem. <br />
                                Para manter sua conta segura, não encaminhe este e-mail para ninguém. <br />
                                Caso prefira esse é seu link de recuperação de senha <br />
                                <b>' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $dataEncriptada . ' </b><br /> ele funcionará apenas 1 unica vez.';


            $mensagem = Util::templateEmail($template);

            $title = "[NOTIFICACAO] Recuperação de senha";
            $emailSend = Util::enviarEmail($title, $user->email ,  $user->nome .' '.$user->sobreNome , $mensagem);
            if(!is_int($emailSend) && !empty($emailSend)) throw new  Exception($emailSend);

            return (int) 1;
        }catch (Exception $e){
            return $e;
        }
    }

}
