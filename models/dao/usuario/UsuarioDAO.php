<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */
require_once ABSPATH . "/models/factory/usuario/UsuarioFactory.php";
class UsuarioDAO extends UsuarioFactory{

    protected $tabela = 'usuario';
    protected $alias = 'u';

    public function __construct($dataBase = null)
    {
//        if (empty($dataBase))
//        {
//            $this->dataBase = new AcessarDB();
//            $this->dataBase = $this->dataBase->acessarDB();
//            $this->destruirDB = 1;
//        }
//        else
//        {
//            $this->dataBase = $dataBase;
//        }
//
//        parent::__construct($this->_table, $this->dataBase);
    }

    /**
     * Verifica se o usuário existe no banco
     * @author vinicius fernandes
     * @return array Usuario
     * @throws string
     */
    public function getUsuarioFromEmailSenha($email, $senha) {
        try{

            $colunas = [
                'usuario.idUsuario',
                'usuario.nome',
                'usuario.sobreNome',
                'usuario.email',
                'usuario.idPerfil',
                'usuario.superAdmin',
                'usuario.status',
                'usuario.imgPerfil',
                'perfil.idPerfil',
                'perfil.nomePerfil'
            ];

            $joins[] = 'INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil';

            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'status', 'value' => '1', 'comparation' => '=' ];
            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'email', 'value' => $email, 'comparation' => '=' ];
            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'senha', 'value' => $senha, 'comparation' => '= BINARY ' ];

            $listaUsuarios = (new Select($this->tabela))->Select($colunas, $where, $joins, '1' );
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

            $userCreate = (new Create('usuario'))->Create($post);
            if($userCreate instanceof Exception) throw  $userCreate;

            return $userCreate;
        }catch(Exeption $e){
            return $e;
        }

    }

    public function   editarUsuario($Data, $idUsuario){
        try{
            if(!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

            unset($Data['idUsuario']);

            $where[] = ['type' => 'and', 'field' => 'idUsuario', 'value' => $idUsuario, 'comparation' => '='];
            $updateUsuario = (new Update('usuario'))->Update( $Data,  $where);
            if($updateUsuario instanceof Exception) throw $updateUsuario;
            return true;
        }catch (Exception $e){
            return $e;
        }

    }

    public function checarEmailJaEstaCadastrado($post){
        try{
            if(!is_array($post) || empty($post)) throw new Exception('Tem um trem errado aqui!');

            $where[] = ['type' => 'and', 'field' => 'status', 'value' => '1', 'comparation' => '=' ];
            $where[] = ['type' => 'and', 'field' => 'email', 'value' => $post['email'], 'comparation' => '=' ];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
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

            $where[] = ['type' => 'and',  'field' => 'status', 'value' => '1', 'comparation' => '=' ];
            $where[] = ['type' => 'and',  'field' => 'CPF', 'value' => $post['CPF'], 'comparation' => '=' ];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
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

            $where[] = ['type' => 'and',  'field' => 'status', 'value' => '1', 'comparation' => '=' ];
            $where[] = ['type' => 'and',  'field' => $key, 'value' => $valor, 'comparation' => '=' ];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
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

            $colunas = [
                'usuario.idUsuario',
                'usuario.nome',
                'usuario.sobreNome',
                'usuario.email',
                'usuario.idPerfil',
                'usuario.superAdmin',
                'usuario.status',
                'usuario.imgPerfil',
                'perfil.idPerfil',
                'perfil.nomePerfil'
            ];

            $joins[] = 'INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil';

            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'status', 'value' => '1', 'comparation' => '=' ];
            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'email', 'value' => $email, 'comparation' => '=' ];

            $dadosUsuario = (new Select($this->tabela))->Select($colunas, $where, $joins);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;

            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario[0];
        }catch(Exeption $e){
            return $e;
        }
    }

    public function getListaDeUsuarios() {
        try{
            $colunas = [
                'usuario.idUsuario',
                'usuario.nome',
                'usuario.sobreNome',
                'usuario.email',
                'usuario.telefone',
                'usuario.idPerfil',
                'usuario.superAdmin',
                'usuario.status',
                'usuario.imgPerfil',
                'perfil.idPerfil',
                'perfil.nomePerfil'

            ];

            $joins[] = 'INNER JOIN perfil ON usuario.idPerfil = perfil.idPerfil';

            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'idUsuario', 'value' => '1', 'comparation' => '>=' ];

            $listaUsuario = (new Select($this->tabela))->Select($colunas, $where, $joins);
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

            $where[] = ['type' => 'and', 'alias' => 'usuario', 'field' => 'idUsuario', 'value' => $id, 'comparation' => '=' ];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
            if($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if(empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            return $dadosUsuario;
        }catch(Exeption $e){
            return $e;
        }
    }



}
