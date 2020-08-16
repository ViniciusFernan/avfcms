<?php
/**
 * Primeiro arquivo a ser executado.
 * @package Sistema [CMS BASE]
 * @author AVFWEB
 * @version 1.0
 */

if (file_exists(__DIR__ . '/config/config.avf')) :
    define('App', parse_ini_file(__DIR__ . '/config/config.avf', true));
else :
    header('Location: //'.$_SERVER['HTTP_HOST'].'/install');
endif;

$core = [
    ['nameArquivo' => 'config', 'arquivo' => __DIR__.'/core/config.php'],
    ['nameArquivo' => 'autoload_avf', 'arquivo' => __DIR__.'/core/autoload_avf.php'],
];

if (!empty($core) && is_array($core)) {
    foreach ($core as $item) {
        if (empty(@$item['nameArquivo']) || empty(@$item['arquivo'])) echo "Erro inicial predominante";

        if (file_exists($item['arquivo'])) :require_once($item['arquivo']);
        else : echo "O arquivo " . $item['nameArquivo'] . " não encontrado";
        endif;
    }
}

$ExecApp = new Application();
$ExecApp->dispatch();
