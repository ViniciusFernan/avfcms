<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */

require_once APP . "/models/usuario/factory/UsuarioFactory.php";
require_once APP . "/models/usuario/dao/UsuarioDAO.php";
class RecuperarSenhaUsuarioStrategy extends UsuarioFactory {

    /**
     * @Package: AVF_CMS
     * @Created by: AVFWEB.com.br
     * @Author: Vinicius Fernandes
     * @User: AVFWEB
     * @Date: 28/04/2020
     * @Time: 20:24
     * @param $email
     * @param $hash
     * @return Exception|int
     * @version 1.0
     */
    public function recuperarSenhaDoUsuario($user){
        try{
            if(!Util::Email(@$user->email) || empty(@$user->email)) throw new Exception('Error em processar dados');
            if(empty(@$user->chaveDeRecuperacao)) throw new Exception('Error em processar chave de recuperação ');

            $template['action'] = 'Recuperação de senha';
            $template['user'] = $user->nome .' '.$user->sobreNome ;
            $template['url'] = HOME_URI . '/cadastro/viewPageNovaSenha/' . $user->chaveDeRecuperacao;
            $template['texto'] = 'Olá, ' . $user->nome .' '.$user->sobreNome  . ', <br />
                                Alguém solicitou recentemente uma alteração da senha em sua conta do '.PROJECT_NAME.'. Se foi você, então defina sua nova senha aqui: <br />
                                <a href="' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $user->chaveDeRecuperacao . '" target="_blank">Redefinir senha</a> <br />
                                Se não quiser alterar a senha ou não tiver feito essa solicitação, basta ignorar e excluir esta mensagem. <br />
                                Para manter sua conta segura, não encaminhe este e-mail para ninguém. <br />
                                Caso prefira esse é seu link de recuperação de senha <br />
                                <b>' . HOME_URI . '/cadastro/viewPageNovaSenha/' . $user->chaveDeRecuperacao . ' </b><br /> ele funcionará apenas 1 unica vez.';

            $mensagem = Util::templateEmail($template);

            $emailSend = Util::enviarEmail(
                "[NOTIFICACAO] Recuperação de senha",
                $user->email ,
                $user->nome .' '.$user->sobreNome ,
                $mensagem
            );
            if(!is_int($emailSend) && !empty($emailSend)) throw new  Exception($emailSend);

            return (int) 1;
        }catch (Exception $e){
            return $e;
        }
    }

}
