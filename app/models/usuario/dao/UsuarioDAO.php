<?php
/**
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 * */
require_once APP . "/models/usuario/factory/UsuarioSessaoFactory.php";

class UsuarioDAO extends UsuarioFactory
{

    protected $tabela = 'usuario';
    protected $alias = 'u';
    private $Conn = null;

    public function __construct($Conn = null)
    {
        if ($Conn instanceof PDO && is_object($Conn)) $this->Conn = $Conn;
    }

    /**
     * Verifica se o usuário existe no banco
     * @return array Usuario
     * @throws string
     * @author vinicius fernandes
     */
    public function getUsuarioFromEmailSenha(object $usuario)
    {
        try {
            if(!is_object($usuario)) throw new Exception('usuario não enviado');

            $colunas = [
                $this->alias . '.idUsuario',
                $this->alias . '.nome',
                $this->alias . '.sobreNome',
                $this->alias . '.email',
                $this->alias . '.idPerfil',
                $this->alias . '.superAdmin',
                $this->alias . '.status',
                $this->alias . '.imgPerfil',
                $this->alias . '.idPerfil',
                'p.nomePerfil'
            ];

            $joins[] = "INNER JOIN perfil p ON p.idPerfil = {$this->alias}.idPerfil";

            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'status', 'value' => '1', 'comparation' => '='];
            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'email', 'value' => $usuario->getEmail(), 'comparation' => '='];
            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'senha', 'value' => $usuario->getSenha(), 'comparation' => '= BINARY '];

            $listaUsuarios = (new Select($this->tabela . ' ' . $this->alias))->Select($colunas, $where, $joins, '1');
            if ($listaUsuarios instanceof Exception) throw  $listaUsuarios;
            if (empty($listaUsuarios)) throw new Exception('Nenhum Usuario encontrado nesse trem!');

            $usuario = (new UsuarioSessaoFactory);
            foreach ($listaUsuarios as $userDb) {
                foreach ($userDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($usuario,$atributeSet))) continue;
                    $usuario->$atributeSet($valor);
                }
            }

            return $usuario;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * inserir novos usuarios
     * @param $post
     * @return bool|INT
     * @throws Exception
     */
    public function insertNewUser($post)
    {
        try {
            if (!is_array($post) || empty($post))
                throw new Exception('Error grave nesse trem');

            $userCreate = (new Create($this->tabela, $this->Conn))->Create($post);
            if ($userCreate instanceof Exception) throw  $userCreate;

            return $userCreate;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function editarUsuario($Data, $idUsuario)
    {
        try {
            if (!is_array($Data) || empty($Data)) throw new Exception('Tem um trem errado aqui!');

            unset($Data['idUsuario']);

            $where[] = ['type' => 'and', 'field' => 'idUsuario', 'value' => $idUsuario, 'comparation' => '='];
            $updateUsuario = (new Update($this->tabela, $this->Conn))->Update($Data, $where);
            if ($updateUsuario instanceof Exception) throw $updateUsuario;
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function checarUsuarioCadastrado($key, $valor)
    {
        try {
            if (empty($key) || empty($valor)) throw new Exception('Error grave nesse trem');

            $where[] = ['type' => 'and', 'field' => 'status', 'value' => '1', 'comparation' => '='];
            $where[] = ['type' => 'and', 'field' => $key, 'value' => $valor, 'comparation' => '='];

            $dadosUsuario = (new Select($this->tabela))->Select(null, $where);
            if ($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if (!empty($dadosUsuario)):
                return true;
            else:
                return false;
            endif;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function buscarUsuarioPorEmail($email)
    {
        try {

            $colunas = [
                "{$this->alias}.idUsuario",
                "{$this->alias}.nome",
                "{$this->alias}.sobreNome",
                "{$this->alias}.email",
                "{$this->alias}.telefone",
                "{$this->alias}.superAdmin",
                "{$this->alias}.status",
                "{$this->alias}.imgPerfil",
                "perfil.idPerfil",
                "perfil.nomePerfil"
            ];

            $joins[] = "INNER JOIN perfil ON {$this->alias}.idPerfil = perfil.idPerfil";

            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'status', 'value' => '1', 'comparation' => '='];
            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'email', 'value' => $email, 'comparation' => '='];

            $dadosUsuario = (new Select($this->tabela . ' ' . $this->alias))->Select($colunas, $where, $joins);
            if ($dadosUsuario instanceof Exception) throw $dadosUsuario;

            if (empty($dadosUsuario)) throw new Exception('Não achou nada nesse trem!');

            $usuario = (new UsuarioFactory);
            foreach ($dadosUsuario as $userDb) {
                foreach ($userDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($usuario,$atributeSet))) continue;
                    $usuario->$atributeSet($valor);
                }
            }

            return $usuario;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function getListaDeUsuarios()
    {
        try {
            $colunas = [
                "{$this->alias}.idUsuario",
                "{$this->alias}.nome",
                "{$this->alias}.sobreNome",
                "{$this->alias}.email",
                "{$this->alias}.telefone",
                "{$this->alias}.superAdmin",
                "{$this->alias}.status",
                "{$this->alias}.imgPerfil",
                "{$this->alias}.idPerfil",
                "perfil.nomePerfil"
            ];

            $joins[] = "INNER JOIN perfil ON {$this->alias}.idPerfil = perfil.idPerfil";

            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'idUsuario', 'value' => '1', 'comparation' => '>='];

            $listaUsuario = (new Select($this->tabela . " " . $this->alias))->Select($colunas, $where, $joins);
            if ($listaUsuario instanceof Exception) throw $listaUsuario;

            if (empty($listaUsuario)) throw new Exception('Não achou nada nesse trem!');

            $listaUsuarioRetorno = [];
            foreach ($listaUsuario as $userDb) {
                $usuario = (new UsuarioSessaoFactory);
                foreach ($userDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($usuario,$atributeSet))) continue;
                    $usuario->$atributeSet($valor);
                }
                $listaUsuarioRetorno[] = $usuario;
            }

            return $listaUsuarioRetorno;
        } catch (Exeption $e) {
            return $e;
        }
    }

    public function getUsuarioPorId($id)
    {
        try {
            if (empty($id)) throw new Exception('Erro identificador do usuario não enviado');

            $where[] = ['type' => 'and', 'alias' => $this->alias, 'field' => 'idUsuario', 'value' => $id, 'comparation' => '='];

            $dadosUsuario = (new Select($this->tabela . " " . $this->alias))->Select(null, $where);
            if ($dadosUsuario instanceof Exception) throw $dadosUsuario;
            if (empty($dadosUsuario)) throw new Exception('Usuario não encontrado!');

            $usuario = (new UsuarioFactory);
            foreach ($dadosUsuario as $userDb) {
                foreach ($userDb as $atribute => $valor) {
                    $atributeSet = 'set'.ucfirst($atribute);
                    if((!method_exists($usuario,$atributeSet))) continue;
                    $usuario->$atributeSet($valor);
                }
            }

            return $usuario;
        } catch (Exeption $e) {
            return $e;
        }
    }
}
