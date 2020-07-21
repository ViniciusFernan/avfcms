<?php
/**
 * Primeiro arquivo a ser executado.
 * @package Sistema [CMS BASE]
 * @author AVFWEB
 * @version 1.0
 */
$App = [
    ['nameArquivo' => 'config', 'arquivo' => __DIR__.'/core/config.php'],
    ['nameArquivo' => 'autoload_avf', 'arquivo' => __DIR__.'/core/autoload_avf.php'],
];

if (!empty($App) && is_array($App)) {
    foreach ($App as $item) {
        if (empty(@$item['nameArquivo']) || empty(@$item['arquivo'])) echo "Erro inicial predominante";

        if (file_exists($item['arquivo'])) : require_once($item['arquivo']);
        else : echo "O arquivo " . $item['nameArquivo'] . " não encontrado";
        endif;
    }
}

$ExecApp = new Application();
$ExecApp->dispatch();
