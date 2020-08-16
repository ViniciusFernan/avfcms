<?php

class InstallUsuarioTables
{


    private $Conn = null;

    public function __construct($Conn)
    {
        try {
            if ($Conn instanceof PDO && is_object($Conn)) $this->Conn = $Conn;
            else throw new Exception('Conexão não informada');
        } catch (Exception $e) {
            return $e;
        }

    }

    public function createTable($userAdmin, $senha)
    {
        try {

            $dataSetPerfil = $this->createTableAuxPerfil();
            if($dataSetPerfil instanceof Exception) throw $dataSetPerfil;

            $createUser = " DROP TABLE IF EXISTS usuario;
                            CREATE TABLE usuario (
                            idUsuario INT(11) NOT NULL AUTO_INCREMENT,
                            idPerfil INT(11) NOT NULL,
                            nome VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
                            sobreNome VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            email VARCHAR(120) NOT NULL COLLATE 'utf8_general_ci',
                            telefone VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            telefone_aux VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            CPF VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            senha VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci',
                            dataNascimento DATETIME NULL DEFAULT NULL,
                            sexo CHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            dataCadastro DATETIME NOT NULL,
                            dataUltimoAcesso DATETIME NULL DEFAULT NULL,
                            status TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=ATIVO | 2=INATIVO | 0=DELETADO',
                            detalhes MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            superAdmin TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'SuperAdmin é o usuario master do sistema.',
                            imgPerfil VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            chaveDeRecuperacao VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                            PRIMARY KEY (idUsuario) USING BTREE,
                            INDEX FK_usuario_perfil (idPerfil) USING BTREE,
                            CONSTRAINT FK_usuario_perfil FOREIGN KEY (idPerfil) REFERENCES perfil (idPerfil) ON UPDATE NO ACTION ON DELETE NO ACTION
                        )
                        COMMENT='Tabela de Usuário do sistema.'
                        COLLATE='utf8_general_ci'
                        ENGINE=InnoDB
                        ROW_FORMAT=COMPACT
                        AUTO_INCREMENT=0;";

            $this->Conn->exec($createUser);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro insert');
            }


            $dsRows = $this->createRows($userAdmin, $senha);
            if ($dsRows instanceof Exception) throw $dsRows;

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function createRows($userAdmin, $senha)
    {
        try {

            if (empty($userAdmin)) throw new Exception('Usuario admin não informado ');
            if (empty($senha)) throw new Exception('Senha do usuario admin não informada');

            $data = date('Y-m-d H:m:s');
            $insertUser = "INSERT INTO usuario 
                                    (idPerfil, nome, sobreNome, email, telefone, CPF, senha, dataNascimento, sexo, dataCadastro) 
                             VALUES ('1', 'AVFADM', 'ADM_SINGLE', '{$userAdmin}', '(11) 1 1111-1111', '886.509.820-18', '{$senha}', '1988-04-05 00:00:00', '1', '{$data}');";
            $this->Conn->exec($insertUser);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro insert');
            }


            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function createTableAuxPerfil()
    {
        try {

            //Necessario Drop em usuarios para recriar tabela perfil;
            $createPefil = "DROP TABLE IF EXISTS usuario, perfil;
                            CREATE TABLE perfil (
                                idPerfil INT(11) NOT NULL AUTO_INCREMENT,
                                nomePerfil VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
                                tipoPerfil INT(1) NOT NULL DEFAULT '2' COMMENT '[0->admin | 1-anunciante | 2-> usuario]',
                                status INT(1) NOT NULL DEFAULT '1',
                            PRIMARY KEY (idPerfil) USING BTREE )
                            COMMENT='Perfils de usuarios criados pelo administrador do sistema'
                            COLLATE='utf8_general_ci'
                            ENGINE=InnoDB
                            ROW_FORMAT=COMPACT
                            AUTO_INCREMENT=0;";

            $this->Conn->exec($createPefil);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro create');
            }

            $dsRowsPerfil = $this->createRowsAuxPerfil();
            if ($dsRowsPerfil instanceof Exception) throw $dsRowsPerfil;

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function createRowsAuxPerfil()
    {
        try {

            $insertPerfil = "INSERT INTO perfil (idPerfil, nomePerfil, tipoPerfil, status) 
                             VALUES ('1', 'ADMINISTRADOR', '0', '1'),
                                    ('6', 'USUARIO', '2', '1');";
            $this->Conn->exec($insertPerfil);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro insert');
            }

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

}