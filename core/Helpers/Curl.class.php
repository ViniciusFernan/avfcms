<?php
/**
 * DataValid.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */
class Curl{

    public static $url = '';
    public static $header = false;
    public static $body = false;
    public static $cookie = null;
    public static $postField = false;
    public static $file = false;
    public static $followLocation = true;
    public static $maxRedirect = 10;
    public static $binaryTransfer = 0;
    public static $httpHeader = null;
    public static $sslVerifyPeer = false;
    public static $sslVerifyHost = false;
    public static $dnsGlobalCache = null; //default true
    public static $dnsCacheTimeout = null; //default 2
    public static $curlOptCustomRequest = 'POST';
    public static $sslVersion = null;
    public static $CURLOPT_CAINFO = null;

    public static $dominio = null;
    public static $removerTagImg = 0;
    public static $removerTagScript = 0;
    public static $removerTagCss = 0;
    public static $removerOnload = 0;

    public static function init()
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_VERBOSE => true,
            //CURLOPT_COOKIEJAR => self::$cookie,
            //CURLOPT_COOKIE => self::$cookie,
            CURLOPT_HEADER => self::$header,
            CURLOPT_NOBODY => self::$body,
            CURLOPT_USERAGENT => (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '' ,
            CURLOPT_FOLLOWLOCATION => self::$followLocation, // follow redirects
            CURLOPT_ENCODING => '', // handle all encodings
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => self::$maxRedirect, // stop after 10 redirects
            CURLOPT_BINARYTRANSFER => self::$binaryTransfer
        );

        if (self::$postField)
        {
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_VERBOSE => true,
                //CURLOPT_COOKIEJAR => self::$cookie,
                //CURLOPT_COOKIE => self::$cookie,
                CURLOPT_HEADER => self::$header,
                CURLOPT_NOBODY => self::$body,
                CURLOPT_USERAGENT => (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '' ,
                CURLOPT_FOLLOWLOCATION => self::$followLocation, // follow redirects
                CURLOPT_ENCODING => '', // handle all encodings
                CURLOPT_AUTOREFERER => true, // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_MAXREDIRS => self::$maxRedirect, // stop after 10 redirects
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => self::$postField,
                CURLOPT_CUSTOMREQUEST => self::$curlOptCustomRequest,
                CURLOPT_BINARYTRANSFER => self::$binaryTransfer
            );
        }

        if (!empty(self::$httpHeader)) $options[CURLOPT_HTTPHEADER] = self::$httpHeader;

        $ch = curl_init(self::$url);
        curl_setopt_array($ch, $options);

        if(self::$file) curl_setopt($ch, CURLOPT_FILE, self::$file);

        if(!empty(self::$cookie)){
            curl_setopt($ch, CURLOPT_COOKIEJAR, self::$cookie);
            curl_setopt($ch, CURLOPT_COOKIE, self::$cookie);
        }

        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);

        $__header = '';
        $_body = '';
        if (self::$header !== false && self::$header == true)
        {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $__header = substr($content, 0, $headerSize);
            $_body = substr($content, $headerSize);
        }

        self::$header = curl_getinfo($ch);
        curl_close($ch);

        self::$header['errno'] = $err;
        self::$header['errmsg'] = $errmsg;
        self::$header['content'] = $content;
        self::$header['_header'] = $__header;
        self::$header['_body'] = $_body;

        $_header = self::$header;
        self::destruidor();
        return $_header;
    }


    public static function destruidor(){
        self::$url = '';
        self::$header = false;
        self::$body = false;
        self::$cookie = null;
        self::$postField = false;
        self::$file = false;
        self::$followLocation = true;
        self::$maxRedirect = 10;
    }



}
