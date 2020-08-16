<?php

class InstallMenuTables
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


    public function createTable()
    {
        try {

            $createMenu = " DROP TABLE IF EXISTS menu_backend;
                            CREATE TABLE menu_backend (
                                idMenu INT(11) NOT NULL AUTO_INCREMENT,
                                icon VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                                nome VARCHAR(250) NOT NULL COLLATE 'utf8_general_ci',
                                controller VARCHAR(250) NOT NULL COLLATE 'utf8_general_ci',
                                ordem INT(11) NULL DEFAULT NULL,
                                dataCadastro DATETIME NULL DEFAULT current_timestamp(),
                                status INT(11) NOT NULL DEFAULT '1',
                                PRIMARY KEY (idMenu) USING BTREE
                            )
                            COLLATE='utf8_general_ci'
                            ENGINE=InnoDB
                            AUTO_INCREMENT=0;";
            $this->Conn->exec($createMenu);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro create');
            }

            $dsRows = $this->createRows();
            if ($dsRows instanceof Exception) throw $dsRows;

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function createRows()
    {
        try {
            $insertMenus = "INSERT INTO menu_backend (idMenu, icon, nome, controller, ordem) 
                            VALUES ('1', 'fas fa-folder-open', 'Menu', 'menu', '1'),
                                   ('2', 'la la-dashboard', 'Dashboard', 'dashboard', '2'),
                                   ('3', 'fas fa-user-friends', 'Usuario', 'usuario', '3');";
            $this->Conn->exec($insertMenus);
            if ($this->Conn->errorInfo()[0] !== '00000') {
                throw new Exception('erro insert');
            }
        } catch (Exception $e) {
            return $e;
        }
    }

}