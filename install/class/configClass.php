<?php

require_once $_SERVER['DOCUMENT_ROOT']. "/install/class/InstallMenuTables.php";
require_once $_SERVER['DOCUMENT_ROOT']. "/install/class/InstallUsuarioTables.php";

class configClass
{
    private $hash = "502ff82f7f1f8218dd41201fe4353687";

    public function createConfigAvf($configCms) {
        try {
            $this->deleteConfigFile();
            $configAVF = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/config.avf', 'w');
            if ($configAVF == false) throw new Exception('Não foi possível criar o arquivo.');

            $conteudo = "[DataBase] \n";
            $conteudo .= "  db_host           = {$configCms['db_host']} \n";
            $conteudo .= "  db_name           = {$configCms['db_name']} \n";
            $conteudo .= "  db_user           = {$configCms['db_user']} \n";
            $conteudo .= "  db_password       = {$configCms['db_password']} \n";
            $conteudo .= "  db_port           = {$configCms['db_port']} \n\n\n\n";

            $conteudo .= "[Application] \n";
            $conteudo .= "  project_name      = {$configCms['nome_projeto']} \n";
            $conteudo .= "  app_url           = {$configCms['url_projeto']} \n";
            $conteudo .= "  app_hash           = {$this->hash} \n\n\n\n";

            $conteudo .= "[EmailConfg] \n";
            $conteudo .= "  mail_host         = smtp.gmail.com \n";
            $conteudo .= "  mail_user         = avf.sistema@gmail.com \n";
            $conteudo .= "  mail_pass         = ajsmema \n";
            $conteudo .= "  mail_port         = 587 \n";
            $conteudo .= "  mail_send         = smtp.gmail.com \n";
            $conteudo .= "  mail_send_name    = SISTEMA \n";

            fwrite($configAVF, $conteudo);
            fclose($configAVF);

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function conn($configCms) {
        try {
            $conn = new PDO("mysql:host={$configCms['db_host']}:{$configCms['db_port']};dbname={$configCms['db_name']}", $configCms['db_user'], $configCms['db_password']);
            $conn->exec("SET CHARACTER SET utf8");
            return $conn;
        } catch (Exception $e) {
            $this->deleteConfigFile();
            return $e;
        }
    }

    public function DbInit($configCms){
        try {
            $conn = $this->conn($configCms);
            if($conn instanceof Exception) throw $conn;
            if(!$conn instanceof PDO) throw new Exception("PDO ERROR INIT.");
            $conn->beginTransaction();

            $instalationMenu = (new InstallMenuTables($conn))->createTable();
            if($instalationMenu instanceof Exception) throw $instalationMenu;


            $userAdmin = $configCms['user_email'];
            $senha = md5($this->hash . $configCms['password']);

            $instalationUser = (new InstallUsuarioTables($conn))->createTable($userAdmin, $senha);
            if($instalationUser instanceof Exception) throw $instalationUser;

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $this->deleteConfigFile();
            $conn->rollBack();
            return $e;
        }
    }

    private function deleteConfigFile(){
        if (file_exists($_SERVER['DOCUMENT_ROOT']."/config/config.avf")) {
            unlink($_SERVER['DOCUMENT_ROOT']."/config/config.avf");
        }
    }

}