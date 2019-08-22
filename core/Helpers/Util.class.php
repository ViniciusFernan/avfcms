<?php
/**
 * DataValid.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */
class Util{

    private static $Data;
    private static $Format;
    private static $Var;

    /**
     * Valida DDD
     * @param Int $ddd
     * @return boolean - True para DDD Válido
     */
    public static function DDD($ddd){
        $lista = array('11','12','13','14','15','16','17','18','19','21','22','24','27','28','31','32','33','34','35','37','38','41','42','43','44','45','46','47','48','49','51','53','54','55','61','62','63','64','65','66','67','68','69','71','73','74','75','77','79','81','82','83','84','85','86','87','88','89','91','92','93','94','95','96','97','98','99');
        if (in_array($ddd, $lista)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public static function Email($Email){
        self::$Data = (string) $Email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)):
            return true;
        else:
            return false;
        endif;
    }

    /***
     * format MONEY
     */
    public static function formatRealMoney($num){
        return number_format($num, 2, ',', '.'); // 100000.50 => R$100.000,50
    }

    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public static function limitWords($String, $Limite, $Pointer = null){
        self::$Data = strip_tags(trim($String));
        self::$Format = (int) $Limite;

        $ArrWords = explode(' ', self::$Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, self::$Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer );
        $Result = ( self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data );
        return $Result;
    }


    /**
     * Verifica se o usuario atual é um super administrador
     * SuperAdmin = Usuário com privilégios de administrador geral do sistema
     * @return boolean
     */
    static function SuperAdmin(){
        if ($_SESSION['usuario']['superAdmin']):
            return true;
        else:
            return false;
        endif;
    }
    
    /**
     * Valida CPF
     * @param STRING $cpf
     * @return boolean - True para CPF Válido
     */
      public static function CPF($cpf){
            $cpf = str_replace(['.','-'], '', $cpf);
            $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
            if ( strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
                return FALSE;
            } else { // Calcula os números para verificar se o CPF é verdadeiro
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return FALSE;
                    }
                }
                return TRUE;
            }
    }

    /**
     * Criptografa a senha baseado no HASH e md5
     * @param $senha
     * @return string
     */
    static function encriptaSenha($senha){
        return md5(HASH . $senha);
    }

    /** encripta dados com base em uma chave*/
    public static function encriptaData($data) {
        return base64_encode($data);
    }

    /** desencripta dados com base em uma chave*/
    public static function decriptaData($data) {
        return base64_decode($data);
    }

    /**
     * Remove acentuacao da string
     * @param String $str
     * @return String
     */
    static function removeAcentos($str){
        // assume $str esteja em UTF-8
        $from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
        $to = "aaaaeeiooouucAAAAEEIOOOUUC";
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($str, $mapping);
    }

    /**
     * Retira tags HTML / XML e adiciona "\" antes de aspas simples e aspas duplas
     * @param $st_string
     * @return string
     */
    static function cleanString($st_string){
        return addslashes(strip_tags($st_string));
    }

    /**
     * Filtra uma string contra Sql Injection
     * @param String $string
     * @param Bool $adicionaBarras
     * @return String - String Filtrada
     */
    private static function antiSQLSItring($string, $adicionaBarras = false){
        if (!is_array($string)) {
            // remove palavras que contenham sintaxe sql
            $string = preg_replace("/(from|alter table|select|insert|delete|update|where|drop table|show tables|#|\*|--|\\\\)/i", "", $string);

            $string = trim($string); //limpa espaços vazio
            $string = strip_tags($string); //tira tags html e php
            if ($adicionaBarras || !get_magic_quotes_gpc())
                $string = addslashes($string);
            return $string;
        } else {
            return $string;
        }
    }

    /**
     * Trata sql injection para string e array Se for um array, passa por todos os indices
     * @param Mixed array|string $var
     * @return Mixed - Variavel Limpa
     */
    public static function SqlInjection($var){
        if (empty($var))
            return;

        self::$Var = $var;
        if (is_array(self::$Var)) {
            foreach (self::$Var as $key => $value) {
                if (!is_array($value)) {
                    $resp[$key] = self::antiSQLSItring($value);
                } else {
                    $resp[$key] = self::SqlInjection($value);
                }
            }
            return $resp;
        } else {
            return self::antiSQLSItring($var);
        }
    }

    /**
     * Remove linhas em branco de uma string
     * @param String $str
     * @return String
     */
    public static function RemoveBlankLines($str){

        self::$Var = $str;
        self::$Format = "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/";

        self::$Var = preg_replace(self::$Format, "\n", self::$Var);
        return self::$Var;
    }

    /**
     * CONVERTE DATA BR PARA O FORMATO YYYY-MM-DD
     * @param String $Data
     * @return String
     */
    public static function DataToDate($Data){
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0];
        return self::$Data;
    }

    /**
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function DateToBr($Data, $divisor = NULL){
        $d = ($divisor ? $divisor : '/');
        self::$Data = $Data;
        self::$Format = explode(' ', self::$Data);
        if (!empty(self::$Format[1])):
            return date("d{$d}m{$d}Y H:i:s", strtotime(self::$Data));
        else:
            return date("d{$d}m{$d}Y", strtotime(self::$Data));
        endif;
    }

    /**
     * Converte data br (dd/mm/yyyy hh:mm:ss) para DateTime (YYYY-mm-dd HH:ii:ss)
     * @param type $Data
     * @return type
     */
    public static function DataToDatetime($Data){
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        if (empty(self::$Format[1])):
            self::$Format[1] = date('H:i:s');
        endif;

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        return self::$Data;
    }

    /**
     * Seta as keys de primeiro nivel com o valor de uma coluna
     * Exemplo teste[0] = array('coluna1'=>'valor1','coluna2'=>'valor2') Fica:
     * teste['valor1'] = array('coluna1'=>'valor1','coluna2'=>'valor2')
     * @param Array $Array
     * @param String $nomeColuna
     * @return Array - Array com nome das keys atualizadas
     */
    public static function setKeysComValorDeColuna($Array, $nomeColuna){
        if (!is_array($Array)):
            echo '$Array não é um array';
            return;
        endif;

        foreach ($Array as $result):
            $resultFinal[$result[$nomeColuna]] = $result;
        endforeach;
        return $resultFinal;
    }

    /**
     * Converte o valor passado pelo dia da semana em extenso
     * @param Int $intDiaSemana
     * @return boolean|string
     */
    public static function NumParaDiaSemana($intDiaSemana){

        if (!is_numeric($intDiaSemana)) {
            return false;
        }

        switch ($intDiaSemana) {
            case '0':
                return "Domingo";
                break;
            case '1':
                return "Segunda";
                break;
            case '2':
                return "Terça";
                break;
            case '3':
                return "Quarta";
                break;
            case '4':
                return "Quinta";
                break;
            case '5':
                return "Sexta";
                break;
            case '6':
                return "Sábado";
                break;
            default:
                break;
        }

    }


    /*****
     * Vinicius
     * RETURN TEMPO DE POSTAGEM EM DATA OU STRING.
     * POSTADO AGORA !
     * ALGUNS SEGUNDOS !
     * DIAS ATRÁS
     */
    public static function returnTempoDePostagem($dateDB){
        date_default_timezone_set('America/Sao_Paulo');
        $timestamp = strtotime($dateDB);
        $diferenca = strtotime(date('Y-m-d H:i:s')) - strtotime($dateDB);

        if (date('Y-m-d') == date('Y-m-d', $timestamp)){// se for hoje
            if($diferenca < 60){//menos de 1 minuto

                $hora = "Agora";
            }elseif ($diferenca >= 60 && $diferenca <= 3600) {//menos de uma hora

                $hora = floor($diferenca / 60) . " min. atrás";
            }elseif ($diferenca > 3600) {//mais de uma hora

                $hora = floor($diferenca / 3600) . " horas atrás";
            }
        }elseif (date('Y-m-d', strtotime('-1 day')) == date('Y-m-d', $timestamp)) {//se for ontem

            $hora = "Ontem as " . date('H:i', strtotime($dateDB));
        }else {//se for outros dias

            $hora = date('d/m/Y H:i:s', $timestamp);
        }

        return $hora;
    }

    /**
     * Descreve o tempo restante baseado na hora atual
     * @param STRING $dataHora
     * @return STRING - Tempo faltante em extenso
     */
    public static function TempoRestante($dataHora){
        date_default_timezone_set('America/Sao_Paulo');
        $timestamp = strtotime($dataHora);
        $diferenca = strtotime(date('Y-m-d H:i:s')) - strtotime($dataHora);

        if (date('Y-m-d') == date('Y-m-d', $timestamp)) {// se for hoje
            if ($diferenca < 60) {//menos de 1 minuto
                $hora = "Em 1 minuto.";
            } elseif ($diferenca >= 60 && $diferenca <= 3600) {//menos de uma hora
                $tmp = floor($diferenca / 60);
                $hora = "Em " . $tmp . " minuto" . ($tmp > 1 ? "s" : "") . ".";
            } elseif ($diferenca > 3600) {//mais de uma hora
                $tmp = floor($diferenca / 3600);
                $hora = $tmp . " hora" . ($tmp > 1 ? "s" : "");
            }
        } elseif (date('Y-m-d', strtotime('+1 day')) == date('Y-m-d', $timestamp)) {//se for amanha
            $hora = "Amanhã as " . date('H:i', strtotime($dataHora));
        } else {//se for outros dias
            $hora = date('d/m/Y H:i:s', $timestamp);
        }
        return $hora;
    }

    public static function  transformarMinutosEmHora($mins){
        if ($mins < 0):
            $min = abs($mins);
        else:
            $min = $mins;
        endif;

        $h = floor($min / 60);
        $m = ($min - ($h * 60)) / 100;
        $horas = $h + $m;

        if ($mins < 0):
            $horas *= -1;
        endif;

        $sep = explode('.', $horas);
        $h = $sep[0];
        if (empty($sep[1])):
            $sep[1] = 00;
        endif;
        $m = $sep[1];

        if (strlen($m) < 2):
            $m = $m . 0;
        endif;
        return sprintf('%02d:%02d', $h, $m);
    }


    /*****
     * Vinicius
     * RETURN BROWSER.
     */

    public static function getBrowser(){
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)):
            $platform = 'linux';
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)):
            $platform = 'mac';
        elseif (preg_match('/windows|win32/i', $u_agent)):
            $platform = 'windows';
       endif;

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)):
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        elseif(preg_match('/Firefox/i',$u_agent)):
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        elseif(preg_match('/Chrome/i',$u_agent)):
            $bname = 'Google Chrome';
            $ub = "Chrome";
        elseif(preg_match('/Safari/i',$u_agent)):
            $bname = 'Apple Safari';
            $ub = "Safari";
        elseif(preg_match('/Opera/i',$u_agent)):
            $bname = 'Opera';
            $ub = "Opera";
        elseif(preg_match('/Netscape/i',$u_agent)):
            $bname = 'Netscape';
            $ub = "Netscape";
      endif;

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {
            //return true;
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) :
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)):
                $version= $matches['version'][0];
            else:
                $version= $matches['version'][1];
            endif;
        else:
            $version= $matches['version'][0];
        endif;


        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    /**
     * Redireciona a chamada http para outra página
     * @param string $st_uri
     */
    static function redirect($urlRed) {
        self::$Var = $urlRed;
        header("Location: " . self::$Var);
        exit;
    }

    /**
     * Print_r com a tag <pre> para debugar array
     * @param Array $array
     */
    static function pre($array, $die = false) {
        echo '<pre>';
        print_r($array);
        if ($die)
            die();
        echo '</pre>';
    }

    /**
     * Gera um Cookie para passar mensagem de sucesso para outra pagina
     * @param type $msg
     */
    static function geraCookieSuccess($msg) {
        setcookie('msg', $msg, time() + 10);
    }


    public static function listaDDDRegiao()
    {
        $range = [
            ["11", "São Paulo", "São Paulo e Região Metropolitana"],
            ["12", "São Paulo", "São José dos Campos e Vale do Paraíba"],
            ["13", "São Paulo", "Santos/Baixada Santista/Vale do Ribeira"],
            ["14", "São Paulo", "Bauru/Marília/Jaú/Botucatu"],
            ["15", "São Paulo", "Sorocaba e Itapetininga"],
            ["16", "São Paulo", "Ribeirão Preto/Araraquara/São Carlos"],
            ["17", "São Paulo", "São José do Rio Preto/Barretos"],
            ["18", "São Paulo", "Presidente Prudente/Araçatuba"],
            ["19", "São Paulo", "Campinas e Região Metropolitana/Piracicaba"],
            ["21", "Rio de Janeiro", "Rio de Janeiro, Região Metropolitana e Teresópolis"],
            ["22", "Rio de Janeiro", "Campos dos Goytacazes/Nova Friburgo/Macaé/Cabo Frio"],
            ["24", "Rio de Janeiro", "Petrópolis/Volta Redonda/Angra dos Reis"],
            ["27", "Espírito Santo", "Vitória e Região Metropolitana"],
            ["28", "Espírito Santo", "Cachoeiro de Itapemirim"],
            ["31", "Minas Gerais", "Belo Horizonte, Região Metropolitana e Vale do Aço"],
            ["32", "Minas Gerais", "Juiz de Fora/São João Del Rei"],
            ["33", "Minas Gerais", "Governador Valadares/Teófilo Otoni/Caratinga/Manhuaçu"],
            ["34", "Minas Gerais", "Uberlândia e Triângulo Mineiro"],
            ["35", "Minas Gerais", "Poços de Caldas/Pouso Alegre/Varginha"],
            ["37", "Minas Gerais", "Divinópolis/Itaúna"],
            ["38", "Minas Gerais", "Montes Claros"],
            ["41", "Paraná", "Curitiba e Região Metropolitana"],
            ["42", "Paraná", "Ponta Grossa/Guarapuava"],
            ["43", "Paraná", "Londrina/Apucarana"],
            ["44", "Paraná", "Maringá/Campo Mourão/Umuarama"],
            ["45", "Paraná", "Cascavel/Foz do Iguaçu"],
            ["46", "Paraná", "Francisco Beltrão/Pato Branco"],
            ["47", "Santa Catarina", "Joinville/Blumenau/Itajaí/Balneário Camboriú"],
            ["48", "Santa Catarina", "Florianópolis e Região Metropolitana/Criciúma/Tubarão"],
            ["49", "Santa Catarina", "Chapecó/Lages/Caçador"],
            ["51", "Rio Grande do Sul", "Porto Alegre e Região Metropolitana/Santa Cruz do Sul/Litoral Norte"],
            ["53", "Rio Grande do Sul", "Pelotas/Rio Grande"],
            ["54", "Rio Grande do Sul", "Caxias do Sul/Passo Fundo"],
            ["55", "Rio Grande do Sul", "Santa Maria/Uruguaiana/Santana do Livramento/Santo Ângelo"],
            ["61", "Distrito Federal e Goiás", "Abrangência em todo o distrito federal e entorno"],
            ["62", "Goiás", "Goiânia e Região Metropolitana/Anápolis"],
            ["63", "Tocantins", "Abrangência em todo o estado"],
            ["64", "Goiás", "Rio Verde/Itumbiara"],
            ["65", "Mato Grosso", "Cuiabá e Região Metropolitana"],
            ["66", "Mato Grosso", "Rondonópolis/Sinop"],
            ["67", "Mato Grosso do Sul", "Abrangência em todo o estado"],
            ["68", "Acre", "Abrangência em todo o estado"],
            ["69", "Rondônia", "Abrangência em todo o estado"],
            ["71", "Bahia", "Salvador e Região Metropolitana"],
            ["73", "Bahia", "Itabuna/Ilhéus"],
            ["74", "Bahia", "Juazeiro"],
            ["75", "Bahia", "Feira de Santana/Alagoinhas"],
            ["77", "Bahia", "Vitória da Conquista/Barreiras"],
            ["79", "Sergipe", "Abrangência em todo o estado"],
            ["81", "Pernambuco", "Recife e Região Metropolitana/Caruaru"],
            ["82", "Alagoas", "Abrangência em todo o estado"],
            ["83", "Paraíba", "Abrangência em todo o estado"],
            ["84", "Rio Grande do Norte", "Abrangência em todo o estado"],
            ["85", "Ceará", "Fortaleza e Região Metropolitana"],
            ["86", "Piauí", "Teresina e Região Metropolitana/Parnaíba"],
            ["87", "Pernambuco", "Petrolina/Garanhuns/Serra Talhada/Salgueiro"],
            ["88", "Ceará", "Juazeiro do Norte/Sobral"],
            ["89", "Piauí", "Picos/Floriano"],
            ["91", "Pará", "Belém e Região Metropolitana"],
            ["92", "Amazonas", "Manaus/Parintins"],
            ["93", "Pará", "Santarém/Altamira"],
            ["94", "Pará", "Marabá"],
            ["95", "Roraima", "Abrangência em todo o estado"],
            ["96", "Amapá", "Abrangência em todo o estado"],
            ["97", "Amazonas", "Coari/Tefé"],
            ["98", "Maranhão", "São Luís e Região Metropolitana"],
            ["99", "Maranhão", "Imperatriz/Caxias"]
        ];
        foreach ($range as $ddds) {
            $ddd[$ddds[0]] = $ddds;
        }
        return $ddd;
    }

    public static function getAlert($mensage, $tipoAlert){
        $html ="<div class='alert alert-{$tipoAlert} alert-dismissible fade show' role='alert'>
                    <strong>{$mensage}</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>";
        return $html;
    }

    public static function consultaCNPJ($cnpj){
        if(empty($cnpj)) throw new Exception('Necessário envio do CNPJ');
        //tokem acesso a API Comercial
        $authorization = "Authorization: Bearer ".KEY_WS;

        if(!empty($authorization)){
            Curl::$httpHeader = array('Content-Type: application/json' , $authorization );
        }

        Curl::$url = 'https://www.receitaws.com.br/v1/cnpj/'. $cnpj.'/days/10';
        Curl::$sslVerifyHost = 0;
        Curl::$sslVerifyPeer = 0;

        $resultado = Curl::init();

        if(strpos($resultado['content'], "Gateway Time-out") !== false) throw new Exception('Serviço temporariamente indisponível!<br>Aguarde alguns minutos e tente novamente.');

        $dados = json_decode($resultado['content'], true);

        $dadosReceitaWS = array();

        if($dados['status']==='ERROR') throw new Exception('CNPJ ' . $dados['cnpj'] . ' Rejeitado pela Receita Federal.');

        if (empty($cnpjReceitaWS)) throw new Exception('CNPJ ' . $cnpj . ' não encontrado.');
        $cnpjReceitaWS = str_replace('-', '', $cnpjReceitaWS);
        $cnpjReceitaWS = str_replace('.', '', $cnpjReceitaWS);
        $cnpjReceitaWS = str_replace('/', '', $cnpjReceitaWS);

        $razaoSocialReceitaWS = (!empty($dados['nome']) ? $dados['nome'] : null);
        if (empty($razaoSocialReceitaWS)) throw new Exception('Razão Social do CNPJ ' . $cnpj . ' não encontrado.');

        $fantasiaReceitaWS = (!empty($dados['fantasia']) ? $dados['fantasia'] : null);
        if (empty($razaoSocialReceitaWS)) throw new Exception('Nome Fantasia do CNPJ ' . $cnpj . ' não encontrado.');

        $atividadeEconomicaReceitaWS = (!empty($dados['atividade_principal'][0]['code']) ? $dados['atividade_principal'][0]['code'] : null);
        if (empty($atividadeEconomicaReceitaWS)) throw new Exception('Ramo de Atividade do CNPJ ' . $cnpj . ' não encontrado.');
        $atividadeEconomicaReceitaWS = str_replace('-', '', $atividadeEconomicaReceitaWS);
        $atividadeEconomicaReceitaWS = str_replace('.', '', $atividadeEconomicaReceitaWS);

        $logradouroReceitaWS = (!empty($dados['logradouro']) ? $dados['logradouro'] : null);

        $numeroReceitaWS = (!empty($dados['numero']) ? $dados['numero'] : null);

        $complementoReceitaWS = (!empty($dados['complemento']) ? $dados['complemento'] : '');

        $CEPLogradouroReceitaWS = (!empty($dados['cep']) ? $dados['cep'] : null);
        if (empty($CEPLogradouroReceitaWS)) throw new Exception('CEP do CNPJ ' . $cnpj . ' não encontrado.');

        $CEPLogradouroReceitaWS = str_replace('-', '', $CEPLogradouroReceitaWS);
        $CEPLogradouroReceitaWS = str_replace('.', '', $CEPLogradouroReceitaWS);

        $bairroReceitaWS = (!empty($dados['bairro']) ? $dados['bairro'] : null);

        $municipioReceitaWS = (!empty($dados['municipio']) ? $dados['municipio'] : null);

        $ufReceitaWS = (!empty($dados['uf']) ? $dados['uf'] : null);


        $emailReceitaWS = (!empty($dados['email']) ? $dados['email'] : '');


        $telefoneReceitaWS = (!empty($dados['telefone']) ? $dados['telefone'] : '');

        $telefoneReceitaWS = str_replace(' ', '', $telefoneReceitaWS);
        $telefoneReceitaWS = str_replace('-', '', $telefoneReceitaWS);

        if(empty($logradouroReceitaWS) || empty($bairroReceitaWS) || empty($municipioReceitaWS) || empty($ufReceitaWS)) {

            $recuperaCep = self::getEnderecoPorCep($CEPLogradouroReceitaWS);
            if (empty($logradouroReceitaWS)) {
                $logradouroReceitaWS = $recuperaCep['logradouro'];
            }

            if (!empty($bairroReceitaWS)) {
                $bairroReceitaWS = $recuperaCep['bairro'];
            }

            if (!empty($municipioReceitaWS)) {
                $municipioReceitaWS = $recuperaCep['cidade'];
            }

            if (!empty($ufReceitaWS)) {
                $ufReceitaWS = $recuperaCep['estado'];
            }
        }

        $situacaoCadastralReceitaWS = (!empty($dados['situacao']) ? $dados['situacao'] : null);
        if (empty($situacaoCadastralReceitaWS)) throw new Exception('Situação cadastral do CNPJ ' . $cnpj . ' não encontrado.');

        $dataSituacaoCadastralReceitaWS = (!empty($dados['data_situacao']) ? $dados['data_situacao'] : null);
        if (empty($dataSituacaoCadastralReceitaWS)) throw new Exception('Data situação cadastral do CNPJ ' . $cnpj . ' não encontrado.');

        $dadosReceitaWS['CNPJ']                     = $cnpjReceitaWS;
        $dadosReceitaWS['RAZAOSOCIAL']              = $razaoSocialReceitaWS;
        $dadosReceitaWS['NOMEFANTASIA']             = $fantasiaReceitaWS;
        $dadosReceitaWS['RAMOATIVIDADE']            = $atividadeEconomicaReceitaWS;
        $dadosReceitaWS['LOGRADOURO']               = $logradouroReceitaWS;
        $dadosReceitaWS['NLOGRADOURO']              = $numeroReceitaWS;
        $dadosReceitaWS['COMPLEMENTO']              = $complementoReceitaWS;
        $dadosReceitaWS['CEP']                      = $CEPLogradouroReceitaWS;
        $dadosReceitaWS['BAIRRO']                   = $bairroReceitaWS;
        $dadosReceitaWS['MUNICIPIO']                = $municipioReceitaWS;
        $dadosReceitaWS['UF']                       = $ufReceitaWS;
        $dadosReceitaWS['EMAIL']                    = $emailReceitaWS;
        $dadosReceitaWS['TELEFONE']                 = $telefoneReceitaWS;
        $dadosReceitaWS['SITUACAOCADASTRAL']        = $situacaoCadastralReceitaWS;
        $dadosReceitaWS['DATASITUACAOCADASTRAL']    = $dataSituacaoCadastralReceitaWS;

        return (array) $dadosReceitaWS;

    }


    public static function  templateEmail($template){
        $page = '<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f7f7f7">
            <tbody><tr>
                    <td align="center" valign="top" style="height:100%;margin:0;padding:40px;width:100%;font-family:Helvetica,Arial,sans-serif;line-height:160%">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;width:600px;background-color:#ffffff;border:1px solid #d9d9d9">
                            <tbody><tr>
                                    <td align="center" valign="top" style="font-family:Helvetica,Arial,sans-serif;line-height:160%">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                                            <tbody><tr>
                                                    <td align="center" style="background-color:#ffffff;font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-top:20px;padding-bottom:20px;background:#fff" >
                                                        <img src="'. HOME_URI . '/_assets/images/logoEmail.png" alt="Marombeiros" width="200px" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;height: 40%;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background-color:#ffffff;border-top:1px solid #ffffff;border-bottom:1px solid #ffffff">
                                            <tbody>
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;text-align:center;background:#009ab7;padding: 30px 0 12px 0;">
                                                        <h1 style="color: white;font-family:Helvetica,Arial,sans-serif;font-weight:normal">' .(!empty($template["action"]) ? $template["action"]  : 'Contato pelo site marombeiro' ) .'</h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;color:#404040;font-size:16px;padding-top:64px;padding-bottom:40px;padding-right:72px;padding-left:72px;background:#ffffff">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background-color:#ffffff">
                                            <tbody><tr>
                                                    <td valign="top" style="font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-bottom:32px;text-align:center">
                                             
                                               
                                                        '.(!empty($template["user"]) ? '<p style="text-align: left;"><b>Nome:</b> '. $template["user"] .'</p>' : '' ) .'
                                                        '.(!empty($template["email"]) ? '<p style="text-align: left;"><b>Email:</b> '. $template["email"] .'</p>' : '' ) .'
                                                        '.(!empty($template["telefone"]) ? '<p style="text-align: left;"><b>Telefone:</b> '. $template["telefone"] .'</p>' : '' ) .'
                                                        '.(!empty($template["telefoneOpcional"]) ? '<p style="text-align: left;"><b>Telefone Opcional:</b> '. $template["telefoneOpcional"] .'</p>' : '' ) .'
                                                        
                                                        
                                                        '.(!empty($template["texto"]) ? '<p style="text-align: left;"> '. $template["texto"] .'</p>' : '' ) .'
                                                        '.(!empty($template["url"]) ? '<p style="text-align: left;"> '. $template["url"] .'</p>' : '' ) .'
                                                   
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-bottom:32px;text-align:center">
                                                        <p style="margin:0">' . (!empty($template['texto']) ? $template['texto'] : '') . '</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;background:#ffffff">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background-color:#ffffff">
                                            <tbody>
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;text-align:center;background:#e8e8e8;padding:24px;color:#525252;border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9;">
                                                    Contatos '.HOME_URI.' => Usuarios
                                                    </td>
                                                </tr>
                                                <tr><td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-bottom:24px;text-align:center"></td></tr>
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-bottom:16px;text-align:center;margin-top:32px;padding-left:12%;padding-right:12%">
                                                        <p style="margin:0;color:#666;font-size:13px">
                                                            Em caso de dúvida, fique à vontade para nos contatar.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family:Helvetica,Arial,sans-serif;line-height:160%;padding-bottom:16px;text-align:center">
                                                        <p style="margin:0;padding-bottom:16px;color:#666;font-size:13px">Marombeiro - '. date("Y") .'</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';

        return $page;
    }

    /** base de envio de email **/
    public static function enviarEmail($assunto, $email, $nome, $msg){

        $mail = new Mailer;
        $mail->setAssunto($assunto);
        $mail->setDestinatario($email, $nome);
        $mail->setNomeDe(PROJECT_NAME);
        $mail->setMensagem($msg);
        $resp = $mail->Enviar();
        return $resp;
    }


    /** get endereço com cep == return object**/
    public static function getEnderecoPorCep($cep){
        $cepLimpo = str_replace(array('.', '-'), '', $cep);
        $resp = json_decode( file_get_contents("http://viacep.com.br/ws/".$cepLimpo."/json/ ") );
        return $resp;
    }



    private function realizarConsultaReceitaFederal($cnpjCliente)
    {
        try
        {
            if (Validacoes::isNullOrEmpty($cnpjCliente)) throw new Exception('Envie o CNPJ do cliente!');

            require_once CAMINHO_FISICO . '/NeoRB/Utils/RecursoWeb.php';
            require_once CAMINHO_FISICO . '/NeoRB/Libs/simple_html_dom.php';
            require_once CAMINHO_FISICO . '/NeoRB/Libs/dbc_api_v4_4_php/deathbycaptcha.php';

            $dadosReceita = null;

            $cookiePagina = null;

            RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_solicitacao3.asp';
            RecursoWeb::$header = true;
            RecursoWeb::$body = true;

            $resultado = RecursoWeb::recuperarWebPage();
            $contentPage = $resultado['content'];

            preg_match_all('%Set-Cookie: ([^;]+);%', $contentPage, $saida);

            if (Utilidade::contarArray($saida) > 1 && isset($saida[0]) && isset($saida[0][0]))
            {
                preg_match('%Set-Cookie: ([^;]+);%', $saida[0][0], $_saida);
                $cookiePagina = $_saida[1];
            }
            else throw new Exception('Problemas ao acessar sistema da Receita Federal.');

            RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/captcha/gerarCaptcha.asp';
            RecursoWeb::$cookie = $cookiePagina;
            RecursoWeb::$binaryTransfer = 1;
            RecursoWeb::$httpHeader = array(
                'Pragma: no-cache',
                'Origin: http://www.receita.fazenda.gov.br',
                'Host: www.receita.fazenda.gov.br',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_solicitacao3.asp',
                'Cookie: flag=1; ' . $cookiePagina,
                'Connection: keep-alive'
            );
            $resultado = RecursoWeb::recuperarWebPage();
            $contentPage = $resultado['content'];

            if (@imagecreatefromstring($contentPage) == false) throw new Exception('Não foi possível capturar o captcha');

            $cookiePagina = 'flag=1; ' . $cookiePagina;
            $arrayCaptcha = array(
                'cookie' => $cookiePagina,
                'captchaBase64' => 'data:image/png;base64,' . base64_encode($contentPage)
            );

            $client = new DeathByCaptcha_SocketClient('murilo.dantas', 'murilo');

            $captcha = null;
            $captcha = $client->decode($arrayCaptcha['captchaBase64']);

            if (!isset($captcha['text'])) throw new Exception('Problema ao realizar consulta da IMAGEM');

            $captcha = $captcha['text'];

            $arrayPost = null;
            $arrayPost['origem'] = 'comprovante';
            $arrayPost['cnpj'] = $cnpjCliente;
            $arrayPost['txtTexto_captcha_serpro_gov_br'] = $captcha;
            $arrayPost['submit1'] = 'Consultar';
            $arrayPost['search_type'] = 'cnpj';

            RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp';
            RecursoWeb::$cookie = $arrayCaptcha['cookie'];
            RecursoWeb::$postField = http_build_query($arrayPost);
            RecursoWeb::$httpHeader = array(
                'Host: www.receita.fazenda.gov.br',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp',
                'Cookie: ' . $arrayCaptcha['cookie'],
                'Connection: keep-alive'
            );
            $resultado = RecursoWeb::recuperarWebPage();
            $contentPage = $resultado['content'];

            RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Vstatus.asp?origem=comprovante&cnpj='. $cnpjCliente;
            RecursoWeb::$cookie = $arrayCaptcha['cookie'];
            $resultado = RecursoWeb::recuperarWebPage();
            $contentPage = $resultado['content'];

            $html = new simple_html_dom();
            $html->load($contentPage);

            /*******************LER VALORES RETORNADOS*******************/
            $tableCNPJ = (null !== $html->find('table', 4) ? $html->find('table', 4) : '');
            if (Validacoes::isNullOrEmpty($tableCNPJ))
            {
                RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Campos.asp';
                RecursoWeb::$cookie = $arrayCaptcha['cookie'];
                $resultado = RecursoWeb::recuperarWebPage();
                $contentPage = $resultado['content'];

                RecursoWeb::$url = 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Comprovante.asp';
                RecursoWeb::$cookie = $arrayCaptcha['cookie'];
                $resultado = RecursoWeb::recuperarWebPage();
                $contentPage = $resultado['content'];

                $html = new simple_html_dom();
                $html->load($contentPage);
            }

            /*******************LER VALORES RETORNADOS*******************/
            $tableCNPJ = (null !== $html->find('table', 4) ? $html->find('table', 4) : '');
            if (Validacoes::isNullOrEmpty($tableCNPJ))
            {
                $dadosReceitaWS = $this->consultaReceitaWS($cnpjCliente);
                $dadosReceita = $dadosReceitaWS;
            }
            else
            {
                $trCNPJ = (null !== $tableCNPJ->find('tr', 0) ? $tableCNPJ->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trCNPJ)) throw new Exception('Não encontrado trCNPJ');

                $tdCNPJ = (null !== $trCNPJ->find('td', 0) ? $trCNPJ->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdCNPJ)) throw new Exception('Não encontrado tdCNPJ');

                $fontCNPJ = (null !== $tdCNPJ->find('font', 1) ? $tdCNPJ->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontCNPJ)) throw new Exception('Não encontrado fontCNPJ');

                $bCNPJ = (null !== $fontCNPJ->find('b', 0) ? $fontCNPJ->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bCNPJ)) throw new Exception('Não encontrado bCNPJ');

                $cnpjReceita = $bCNPJ->text();

                $tableRazaoSocial = (null !== $html->find('table', 5) ? $html->find('table', 5) : '');
                if (Validacoes::isNullOrEmpty($tableRazaoSocial)) throw new Exception('Não encontrado tableRazaoSocial');

                $trRazaoSocial = (null !== $tableRazaoSocial->find('tr', 0) ? $tableRazaoSocial->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trRazaoSocial)) throw new Exception('Não encontrado trRazaoSocial');

                $tdRazaoSocial = (null !== $trRazaoSocial->find('td', 0) ? $trRazaoSocial->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdRazaoSocial)) throw new Exception('Não encontrado tdRazaoSocial');

                $fontRazaoSocial = (null !== $tdRazaoSocial->find('font', 1) ? $tdRazaoSocial->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontRazaoSocial)) throw new Exception('Não encontrado fontRazaoSocial');

                $bRazaoSocial = (null !== $fontRazaoSocial->find('b', 0) ? $fontRazaoSocial->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bRazaoSocial)) throw new Exception('Não encontrado bRazaoSocial');

                $razaoSocialReceita = $bRazaoSocial->text();

                $tableNomeFantasia = (null !== $html->find('table', 6) ? $html->find('table', 6) : '');
                if (Validacoes::isNullOrEmpty($tableNomeFantasia)) throw new Exception('Não encontrado tableNomeFantasia');

                $trNomeFantasia = (null !== $tableNomeFantasia->find('tr', 0) ? $tableNomeFantasia->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trNomeFantasia)) throw new Exception('Não encontrado trNomeFantasia');

                $tdNomeFantasia = (null !== $trNomeFantasia->find('td', 0) ? $trNomeFantasia->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdNomeFantasia)) throw new Exception('Não encontrado tdNomeFantasia');

                $fontNomeFantasia = (null !== $tdNomeFantasia->find('font', 1) ? $tdNomeFantasia->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontNomeFantasia)) throw new Exception('Não encontrado fontNomeFantasia');

                $bNomeFantasia = (null !== $fontNomeFantasia->find('b', 0) ? $fontNomeFantasia->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bNomeFantasia)) throw new Exception('Não encontrado bNomeFantasia');

                $nomeFantasiaReceita = $bNomeFantasia->text();

                $tableAtividadeEconomica = (null !== $html->find('table', 7) ? $html->find('table', 7) : '');
                if (Validacoes::isNullOrEmpty($tableAtividadeEconomica)) throw new Exception('Não encontrado tableAtividadeEconomica');

                $trAtividadeEconomica = (null !== $tableAtividadeEconomica->find('tr', 0) ? $tableAtividadeEconomica->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trAtividadeEconomica)) throw new Exception('Não encontrado trAtividadeEconomica');

                $tdAtividadeEconomica = (null !== $trAtividadeEconomica->find('td', 0) ? $trAtividadeEconomica->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdAtividadeEconomica)) throw new Exception('Não encontrado tdAtividadeEconomica');

                $fontAtividadeEconomica = (null !== $tdAtividadeEconomica->find('font', 1) ? $tdAtividadeEconomica->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontAtividadeEconomica)) throw new Exception('Não encontrado fontAtividadeEconomica');

                $bAtividadeEconomica = (null !== $fontAtividadeEconomica->find('b', 0) ? $fontAtividadeEconomica->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bAtividadeEconomica)) throw new Exception('Não encontrado bAtividadeEconomica');

                $atividadeEconomicaReceita = $bAtividadeEconomica->text();

                $tableLogradouro = (null !== $html->find('table', 10) ? $html->find('table', 10) : '');
                if (Validacoes::isNullOrEmpty($tableLogradouro)) throw new Exception('Não encontrado tableLogradouro');

                $trLogradouro= (null !== $tableLogradouro->find('tr', 0) ? $tableLogradouro->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trLogradouro)) throw new Exception('Não encontrado trLogradouro');

                $tdLogradouro = (null !== $trLogradouro->find('td', 0) ? $trLogradouro->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdLogradouro)) throw new Exception('Não encontrado tdLogradouro');

                $fontLogradouro = (null !== $tdLogradouro->find('font', 1) ? $tdLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontLogradouro)) throw new Exception('Não encontrado fontLogradouro');

                $bLogradouro = (null !== $fontLogradouro->find('b', 0) ? $fontLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bLogradouro)) throw new Exception('Não encontrado bLogradouro');

                $logradouroReceita = $bLogradouro->text();

                $tdNumeroLogradouro = (null !== $trLogradouro->find('td', 2) ? $trLogradouro->find('td', 2) : '');
                if (Validacoes::isNullOrEmpty($tdNumeroLogradouro)) throw new Exception('Não encontrado tdNumeroLogradouro');

                $fontNumeroLogradouro = (null !== $tdNumeroLogradouro->find('font', 1) ? $tdNumeroLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontNumeroLogradouro)) throw new Exception('Não encontrado fontNumeroLogradouro');

                $bNumeroLogradouro = (null !== $fontNumeroLogradouro->find('b', 0) ? $fontNumeroLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bNumeroLogradouro)) throw new Exception('Não encontrado bNumeroLogradouro');

                $numeroLogradouroReceita = $bNumeroLogradouro->text();

                $tdComplementoLogradouro = (null !== $trLogradouro->find('td', 4) ? $trLogradouro->find('td', 4) : '');
                if (Validacoes::isNullOrEmpty($tdComplementoLogradouro)) throw new Exception('Não encontrado tdComplementoLogradouro');

                $fontComplementoLogradouro = (null !== $tdComplementoLogradouro->find('font', 1) ? $tdComplementoLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontComplementoLogradouro)) throw new Exception('Não encontrado fontComplementoLogradouro');

                $bComplementoLogradouro = (null !== $fontComplementoLogradouro->find('b', 0) ? $fontComplementoLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bComplementoLogradouro)) throw new Exception('Não encontrado bComplementoLogradouro');

                $complementoLogradouroReceita = $bComplementoLogradouro->text();

                $tableCEPLogradouro = (null !== $html->find('table', 11) ? $html->find('table', 11) : '');
                if (Validacoes::isNullOrEmpty($tableCEPLogradouro)) throw new Exception('Não encontrado tableCEPLogradouro');

                $trCEPLogradouro = (null !== $tableCEPLogradouro->find('tr', 0) ? $tableCEPLogradouro->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trCEPLogradouro)) throw new Exception('Não encontrado trCEPLogradouro');

                $tdCEPLogradouro = (null !== $trCEPLogradouro->find('td', 0) ? $trCEPLogradouro->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdCEPLogradouro)) throw new Exception('Não encontrado tdCEPLogradouro');

                $fontCEPLogradouro = (null !== $tdCEPLogradouro->find('font', 1) ? $tdCEPLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontCEPLogradouro)) throw new Exception('Não encontrado fontCEPLogradouro');

                $bCEPLogradouro = (null !== $fontCEPLogradouro->find('b', 0) ? $fontCEPLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bCEPLogradouro)) throw new Exception('Não encontrado bCEPLogradouro');

                $CEPLogradouroReceita = $bCEPLogradouro->text();

                $tdBairroLogradouro = (null !== $trCEPLogradouro->find('td', 2) ? $trCEPLogradouro->find('td', 2) : '');
                if (Validacoes::isNullOrEmpty($tdBairroLogradouro)) throw new Exception('Não encontrado tdBairroLogradouro');

                $fontBairroLogradouro = (null !== $tdBairroLogradouro->find('font', 1) ? $tdBairroLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontBairroLogradouro)) throw new Exception('Não encontrado fontBairroLogradouro');

                $bBairroLogradouro = (null !== $fontBairroLogradouro->find('b', 0) ? $fontBairroLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bBairroLogradouro)) throw new Exception('Não encontrado bBairroLogradouro');

                $bairroLogradouroReceita = $bBairroLogradouro->text();

                $tdCidadeLogradouro = (null !== $trCEPLogradouro->find('td', 4) ? $trCEPLogradouro->find('td', 4) : '');
                if (Validacoes::isNullOrEmpty($tdCidadeLogradouro)) throw new Exception('Não encontrado tdCidadeLogradouro');

                $fontCidadeLogradouro = (null !== $tdCidadeLogradouro->find('font', 1) ? $tdCidadeLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontCidadeLogradouro)) throw new Exception('Não encontrado fontCidadeLogradouro');

                $bCidadeLogradouro = (null !== $fontCidadeLogradouro->find('b', 0) ? $fontCidadeLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bCidadeLogradouro)) throw new Exception('Não encontrado bCidadeLogradouro');

                $cidadeLogradouroReceita = $bCidadeLogradouro->text();

                $tdUFLogradouro = (null !== $trCEPLogradouro->find('td', 6) ? $trCEPLogradouro->find('td', 6) : '');
                if (Validacoes::isNullOrEmpty($tdUFLogradouro)) throw new Exception('Não encontrado tdUFLogradouro');

                $fontUFLogradouro = (null !== $tdUFLogradouro->find('font', 1) ? $tdUFLogradouro->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontUFLogradouro)) throw new Exception('Não encontrado fontUFLogradouro');

                $bUFLogradouro = (null !== $fontUFLogradouro->find('b', 0) ? $fontUFLogradouro->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bUFLogradouro)) throw new Exception('Não encontrado bUFLogradouro');

                $UFLogradouroReceita = $bUFLogradouro->text();

                $tableEmail = (null !== $html->find('table', 12) ? $html->find('table', 12) : '');
                if (Validacoes::isNullOrEmpty($tableEmail)) throw new Exception('Não encontrado tableEmail');

                $trEmail = (null !== $tableEmail->find('tr', 0) ? $tableEmail->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trEmail)) throw new Exception('Não encontrado trEmail');

                $tdEmail = (null !== $trEmail->find('td', 0) ? $trEmail->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdEmail)) throw new Exception('Não encontrado tdEmail');

                $fontEmail = (null !== $tdEmail->find('font', 1) ? $tdEmail->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontEmail)) throw new Exception('Não encontrado fontEmail');

                $bEmail = (null !== $fontEmail->find('b', 0) ? $fontEmail->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bEmail)) throw new Exception('Não encontrado bEmail');

                $emailReceita = $bEmail->text();

                $tdTelefone = (null !== $trEmail->find('td', 2) ? $trEmail->find('td', 2) : '');
                if (Validacoes::isNullOrEmpty($tdTelefone)) throw new Exception('Não encontrado tdTelefone');

                $fontTelefone = (null !== $tdTelefone->find('font', 1) ? $tdTelefone->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontTelefone)) throw new Exception('Não encontrado fontTelefone');

                $bTelefone = (null !== $fontTelefone->find('b', 0) ? $fontTelefone->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bTelefone)) throw new Exception('Não encontrado bTelefone');

                $telefoneReceita = $bTelefone->text();

                $tableSituacaoCadastral = (null !== $html->find('table', 14) ? $html->find('table', 14) : '');
                if (Validacoes::isNullOrEmpty($tableSituacaoCadastral)) throw new Exception('Não encontrado tableSituacaoCadastral');

                $trSituacaoCadastral = (null !== $tableSituacaoCadastral->find('tr', 0) ? $tableSituacaoCadastral->find('tr', 0) : '');
                if (Validacoes::isNullOrEmpty($trSituacaoCadastral)) throw new Exception('Não encontrado trSituacaoCadastral');

                $tdSituacaoCadastral = (null !== $trSituacaoCadastral->find('td', 0) ? $trSituacaoCadastral->find('td', 0) : '');
                if (Validacoes::isNullOrEmpty($tdSituacaoCadastral)) throw new Exception('Não encontrado tdSituacaoCadastral');

                $fontSituacaoCadastral = (null !== $tdSituacaoCadastral->find('font', 1) ? $tdSituacaoCadastral->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontSituacaoCadastral)) throw new Exception('Não encontrado fontSituacaoCadastral');

                $bSituacaoCadastral = (null !== $fontSituacaoCadastral->find('b', 0) ? $fontSituacaoCadastral->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bSituacaoCadastral)) throw new Exception('Não encontrado bSituacaoCadastral');

                $situacaoCadastral = $bSituacaoCadastral->text();

                $tdDataSituacaoCadastral = (null !== $trSituacaoCadastral->find('td', 2) ? $trSituacaoCadastral->find('td', 2) : '');
                if (Validacoes::isNullOrEmpty($tdDataSituacaoCadastral)) throw new Exception('Não encontrado tdDataSituacaoCadastral');

                $fontDataSituacaoCadastral = (null !== $tdDataSituacaoCadastral->find('font', 1) ? $tdDataSituacaoCadastral->find('font', 1) : '');
                if (Validacoes::isNullOrEmpty($fontDataSituacaoCadastral)) throw new Exception('Não encontrado fontDataSituacaoCadastral');

                $bDataSituacaoCadastral = (null !== $fontDataSituacaoCadastral->find('b', 0) ? $fontDataSituacaoCadastral->find('b', 0) : '');
                if (Validacoes::isNullOrEmpty($bDataSituacaoCadastral)) throw new Exception('Não encontrado bDataSituacaoCadastral');

                $dataSituacaoCadastral = $bDataSituacaoCadastral->text();
                /*******************LER VALORES RETORNADOS*******************/

                $atividadeEconomicaReceita = explode(' ', $atividadeEconomicaReceita);
                $atividadeEconomicaReceita = str_replace('-', '', $atividadeEconomicaReceita[0]);
                $atividadeEconomicaReceita = str_replace('.', '', $atividadeEconomicaReceita);

                $atividadeCEPLogradouroReceita = str_replace('-', '', $CEPLogradouroReceita);
                $atividadeCEPLogradouroReceita = str_replace('.', '', $atividadeCEPLogradouroReceita);

                $dadosReceita['CNPJ'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($cnpjReceita));
                $dadosReceita['RAZAOSOCIAL'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($razaoSocialReceita));
                $dadosReceita['NOMEFANTASIA'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($nomeFantasiaReceita));
                $dadosReceita['RAMOATIVIDADE'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($atividadeEconomicaReceita));
                $dadosReceita['LOGRADOURO'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($logradouroReceita));
                $dadosReceita['NLOGRADOURO'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($numeroLogradouroReceita));
                $dadosReceita['COMPLEMENTO'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($complementoLogradouroReceita));
                $dadosReceita['CEP'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($atividadeCEPLogradouroReceita));
                $dadosReceita['BAIRRO'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($bairroLogradouroReceita));
                $dadosReceita['MUNICIPIO'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($cidadeLogradouroReceita));
                $dadosReceita['UF'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($UFLogradouroReceita));
                $dadosReceita['EMAIL'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($emailReceita));
                $dadosReceita['TELEFONE'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($telefoneReceita));
                $dadosReceita['SITUACAOCADASTRAL'] = Utilidade::retirarCaracteresDesconhecidos(Utilidade::utf8DecodeToUpperDownload($situacaoCadastral));
                $dadosReceita['DATASITUACAOCADASTRAL'] = Utilidade::retirarCaracteresDesconhecidos($dataSituacaoCadastral);
            }


            return (array) $dadosReceita;
        }
        catch (Exception $e)
        {
            return $e->getMessage() . ', ' . $e->getCode() . ', ' . $e->getFile() . ', ' . $e->getLine();
        }
    }


}
