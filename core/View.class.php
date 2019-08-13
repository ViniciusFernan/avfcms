<?php

/**
 * Essa classe é responsável por renderizar os arquivos HTML
 * e transmitir as informacoes vindas da model para a view
 *
 * @package Sistema distribuido em modulos
 * @author AVF-WEB
 * @version 1.0
 */
class View {

    /**
     * Armazena o conteúdo HTML
     * @var string
     */
    private $Content;

    /**
     * Armazena o nome do arquivo de visualização
     * @var string
     */
    private $ViewName;

    /**
     * Armazena os dados que devem ser mostrados ao reenderizar o
     * arquivo de visualização
     * @var Array
     */
    private $Params = array();

    /**
     * É possivel efetuar a parametrização do objeto ao instanciar o mesmo,
     * $st_view é o nome do arquivo de visualização a ser usado e
     * $v_params são os dados que devem ser utilizados pela camada de visualização
     *
     * @param string $ViewFile - Nome do arquivo da View
     * @param Array $Params - Parametros para ser passados para a camada View
     */
    function __construct($ViewFile = null, Array $Params = null) {
        if ($ViewFile)
            $this->setView($ViewFile);
        if ($Params)
            $this->setParams($Params);
    }

    /**
     * Define qual arquivo html deve ser renderizado
     * @param string $ViewFile
     * @throws Exception
     */
    public function setView($ViewFile) {
        if ($this->checkViewFile($ViewFile))
            $this->ViewName = $this->checkViewFile($ViewFile);
        else
            trigger_error("Action $ViewFile nao existe.", E_USER_ERROR);
    }

    /**
     * Retorna o nome do arquivo que deve ser renderizado
     * @return string
     */
    public function getView() {
        return $this->ViewName;
    }

    /**
     * Define os dados que devem ser repassados à view
     * <b>Atenção: </b>Este método apaga os parametros já existentes
     *
     * @param Array $Params
     */
    public function setParams(Array $Params) {
        $this->Params = $Params;
    }

    /**
     * Adiciona um índice e um valor no parametro a ser passado para a View
     *
     * @param String $key - Nome do indice do parametro que vai para a View
     * @param array $Valor - Parametros a ser adicionado nesta key
     */
    public function addParams($key, $Valor) {
        $this->Params[$key] = $Valor;
    }

    /**
     * Retorna os dados que foram ser repassados ao arquivo de visualização
     * @return Array
     */
    public function getParams() {
        return $this->Params;
    }

    /**
     * Retorna uma string contendo todo
     * o conteudo do arquivo de visualização
     *
     * @return string
     */
    public function getContents() {
        ob_start();
        //carrega o content
        if (isset($this->ViewName))
            require_once $this->ViewName;
        $this->Content = ob_get_contents();
        ob_end_clean();
        return $this->Content;
    }

    /**
     * Imprime o arquivo de visualização
     */
    public function showContents() {
        echo $this->getContents();
        exit;
    }

    /* ##################################
      ####### PRIVATE METHODS ###########
      ################################### */

    /**
     * Verifica se o arquivo da View existe;
     * @param type $ViewFile
     * @return boolean - True para existente
     */
    private function checkViewFile($ViewFile){
        $return = false;
        if (!empty($ViewFile)){
            if (file_exists(THEME_DIR.'/'.$ViewFile)){
                $return = THEME_DIR.'/'.$ViewFile;
            }

            if(file_exists(MODULES_DIR . '/' . $ViewFile)){
                $return = MODULES_DIR.'/'.$ViewFile;
            }
        }

        return $return;
    }

}
