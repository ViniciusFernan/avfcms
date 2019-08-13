<?php
/**
 * Conn.class [ CONEXÃO ]
 * Classe abstrata de conexão. Padrão SingleTon.
 * Retorna um objeto PDO pelo método estático getConn();
 *
 * Camada - Modelo ou Model.
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */
abstract class Conn {

    private static $Host = HOSTNAME;
    private static $User = DB_USER;
    private static $Pass = DB_PASSWORD;
    private static $Dbsa = DB_NAME;
    private static $Porta = PORTA;

    /** @var PDO */
    private static $Connect = null;

    /**
     * Conecta com o banco de dados com o pattern singleton.
     * Retorna um objeto PDO!
     */
    private static function Conectar() {
        try {
            if (self::$Connect == null):
                $dsn = 'mysql:host=' . self::$Host . ':'.self::$Porta.';dbname=' . self::$Dbsa;
                $options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    /** Retorna um objeto PDO Singleton Pattern. */
    protected static function getConn() {
        try {
            return self::Conectar();
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

}
