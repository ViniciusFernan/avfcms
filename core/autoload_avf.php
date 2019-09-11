<?php
/**
 * Função para carregar automaticamente todas as classes padrão
 * Ver: http://php.net/manual/pt_BR/function.autoload.php.
 * Nossas classes estão na pasta lib/, lib/Conn e lib/Helpers.
 * O autoload identifica qual pasta que contém o arquivo da classe e importa
 * O nome do arquivo deverá ser NomeDaClasse.class.php.
 * Por exemplo: para a classe Application, o arquivo vai chamar Application.class.php
 */
spl_autoload_register("autoload_avf");
function autoload_avf($Class){
    // Diretórios das classes
    $mDir = ['core', 'core/Helpers', 'core/Conn'];
    $inc = null;
    foreach ($mDir as $cDir) {
        $arquivo = ABSPATH . "/{$cDir}/{$Class}.class.php";
        if (file_exists($arquivo) && !is_dir($arquivo)){
            require_once $arquivo;
            $inc=true;
            break;
        }
    } //endoreach
    if($inc==null){
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
    }
}
